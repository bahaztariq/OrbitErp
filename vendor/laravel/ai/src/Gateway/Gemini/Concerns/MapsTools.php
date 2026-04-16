<?php

namespace Laravel\Ai\Gateway\Gemini\Concerns;

use Illuminate\JsonSchema\JsonSchemaTypeFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Ai\Contracts\Providers\SupportsFileSearch;
use Laravel\Ai\Contracts\Providers\SupportsWebFetch;
use Laravel\Ai\Contracts\Providers\SupportsWebSearch;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\ObjectSchema;
use Laravel\Ai\Providers\Provider;
use Laravel\Ai\Providers\Tools\FileSearch;
use Laravel\Ai\Providers\Tools\ProviderTool;
use Laravel\Ai\Providers\Tools\WebFetch;
use Laravel\Ai\Providers\Tools\WebSearch;
use RuntimeException;

trait MapsTools
{
    /**
     * Map the given tools to Gemini tool definitions.
     */
    protected function mapTools(array $tools, Provider $provider): array
    {
        $functionDeclarations = [];
        $providerTools = [];

        foreach ($tools as $tool) {
            if ($tool instanceof ProviderTool) {
                $providerTool = $this->mapProviderTool($tool, $provider);

                if (filled($providerTool)) {
                    $providerTools[] = $providerTool;
                }
            } elseif ($tool instanceof Tool) {
                $functionDeclarations[] = $this->mapTool($tool);
            }
        }

        $toolsArray = [];

        if (filled($functionDeclarations)) {
            $toolsArray[] = ['function_declarations' => $functionDeclarations];
        }

        foreach ($providerTools as $providerTool) {
            $toolsArray[] = $providerTool;
        }

        return $toolsArray;
    }

    /**
     * Map a regular tool to a Gemini function declaration.
     */
    protected function mapTool(Tool $tool): array
    {
        $schema = $tool->schema(new JsonSchemaTypeFactory);

        $definition = [
            'name' => class_basename($tool),
            'description' => (string) $tool->description(),
        ];

        if (filled($schema)) {
            $schemaArray = (new ObjectSchema($schema))->toSchema();

            $definition['parameters'] = $this->normalizeSchema([
                'type' => 'OBJECT',
                'properties' => $schemaArray['properties'] ?? [],
                'required' => $schemaArray['required'] ?? [],
            ]);
        }

        return $definition;
    }

    /**
     * Normalize the given schema for Gemini's strict validation.
     *
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    protected function normalizeSchema(array $schema): array
    {
        if (isset($schema['type'])) {
            if (is_array($schema['type'])) {
                if (in_array('null', $schema['type'])) {
                    $schema['nullable'] = true;
                }

                $schema['type'] = (new Collection($schema['type']))
                    ->filter(fn ($type) => $type !== 'null')
                    ->first() ?? 'string';
            }

            $schema['type'] = match (strtolower($schema['type'])) {
                'string' => 'STRING',
                'number' => 'NUMBER',
                'integer' => 'INTEGER',
                'boolean' => 'BOOLEAN',
                'array' => 'ARRAY',
                'object' => 'OBJECT',
                default => strtoupper($schema['type']),
            };
        }

        if (isset($schema['properties'])) {
            foreach ($schema['properties'] as $key => $property) {
                $schema['properties'][$key] = $this->normalizeSchema($property);
            }
        }

        if (isset($schema['items'])) {
            $schema['items'] = $this->normalizeSchema($schema['items']);
        }

        return Arr::except($schema, ['additionalProperties']);
    }

    /**
     * Map a provider tool to a Gemini provider tool definition.
     */
    protected function mapProviderTool(ProviderTool $tool, Provider $provider): array
    {
        return match (true) {
            $tool instanceof FileSearch => $this->mapFileSearchTool($tool, $provider),
            $tool instanceof WebFetch => $this->mapWebFetchTool($tool, $provider),
            $tool instanceof WebSearch => $this->mapWebSearchTool($tool, $provider),
            default => [],
        };
    }

    /**
     * Map a file search tool to a Gemini file search definition.
     */
    protected function mapFileSearchTool(FileSearch $tool, Provider $provider): array
    {
        if (! $provider instanceof SupportsFileSearch) {
            throw new RuntimeException('Provider ['.$provider->name().'] does not support file search.');
        }

        return [
            'fileSearch' => $provider->fileSearchToolOptions($tool),
        ];
    }

    /**
     * Map a web fetch tool to a Gemini URL context definition.
     */
    protected function mapWebFetchTool(WebFetch $tool, Provider $provider): array
    {
        if (! $provider instanceof SupportsWebFetch) {
            throw new RuntimeException('Provider ['.$provider->name().'] does not support web fetch.');
        }

        return [
            'url_context' => (object) $provider->webFetchToolOptions($tool),
        ];
    }

    /**
     * Map a web search tool to a Gemini Google Search definition.
     */
    protected function mapWebSearchTool(WebSearch $tool, Provider $provider): array
    {
        if (! $provider instanceof SupportsWebSearch) {
            throw new RuntimeException('Provider ['.$provider->name().'] does not support web search.');
        }

        return [
            'google_search' => (object) $provider->webSearchToolOptions($tool),
        ];
    }
}
