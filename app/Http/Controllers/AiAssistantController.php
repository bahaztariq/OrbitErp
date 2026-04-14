<?php

namespace App\Http\Controllers;

use App\Ai\Agents\AiAssistantAgent;
use App\Models\Company;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    public function index(Company $company)
    {
        $companySlug = $company->slug;
        return view('ai.ai-assistant', compact('companySlug'));
    }

    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');

        if (!$prompt) {
            return response()->json(['response' => 'Please provide a prompt.']);
        }

        try {
            $agent = AiAssistantAgent::make();
            $response = $agent->prompt($prompt);

            return response()->json([
                'response' => $response->text
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'response' => "Sorry, an error occurred: " . $e->getMessage()
            ], 500);
        }
    }
}
