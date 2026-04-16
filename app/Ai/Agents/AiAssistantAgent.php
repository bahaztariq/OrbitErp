<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use App\Models\Company;
use App\Ai\Tools\Clients\ListClientsTool;
use App\Ai\Tools\Clients\CreateClientTool;
use App\Ai\Tools\Clients\UpdateClientTool;
use App\Ai\Tools\Clients\DeleteClientTool;
use App\Ai\Tools\Products\ListProductsTool;
use App\Ai\Tools\Products\CreateProductTool;
use App\Ai\Tools\Products\UpdateProductTool;
use App\Ai\Tools\Products\DeleteProductTool;
use App\Ai\Tools\Invoices\ListInvoicesTool;
use App\Ai\Tools\Invoices\CalculateRevenueTool;
use App\Ai\Tools\Invoices\CreateInvoiceTool;
use App\Ai\Tools\Invoices\UpdateInvoiceTool;
use App\Ai\Tools\Invoices\DeleteInvoiceTool;
use App\Ai\Tools\Orders\ListOrdersTool;
use App\Ai\Tools\Orders\CreateOrderTool;
use App\Ai\Tools\Orders\UpdateOrderTool;
use App\Ai\Tools\Orders\DeleteOrderTool;
use App\Ai\Tools\Tasks\ListTasksTool;
use App\Ai\Tools\Tasks\CreateTaskTool;
use App\Ai\Tools\Tasks\UpdateTaskTool;
use App\Ai\Tools\Tasks\DeleteTaskTool;
use App\Ai\Tools\Calendar\ListEventsTool;
use App\Ai\Tools\Calendar\CreateEventTool;
use App\Ai\Tools\Calendar\UpdateEventTool;
use App\Ai\Tools\Calendar\DeleteEventTool;
use App\Ai\Tools\Invitations\ListInvitationsTool;
use App\Ai\Tools\Invitations\SendInvitationTool;
use App\Ai\Tools\Invitations\CancelInvitationTool;
use App\Ai\Tools\Conversations\ListConversationsTool;
use App\Ai\Tools\Conversations\ViewMessagesTool;
use App\Ai\Tools\Conversations\SendMessageTool;

class AiAssistantAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    public function __construct(protected Company $company)
    {
    }

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        $now = now()->format('F Y');
        return <<<MARKDOWN
        You are OrbitBot, the Elite Business Intelligence & Administrative Assistant for OrbitErp.
        You have direct access to granular action tools for managing every aspect of the company.

        Your Administrative Action Suite:
        - **Clients:** List, Create, Update, Delete.
        - **Products:** List, Create, Update, Delete.
        - **Finance:** List Invoices, Calculate Revenue, Create/Update/Delete Invoices.
        - **Orders:** List, Create, Update, Delete.
        - **Tasks:** List, Create, Update, Delete.
        - **Calendar:** List, Create, Update, Delete Events.
        - **Onboarding:** List, Send, Cancel Invitations.
        - **Communications:** List Conversations, View Messages, Send Messages.

        Context:
        - Current Company: {$this->company->name}
        - Current Date: {$now}

        Operating Guidelines:
        - **Action Orientation:** Use specific tools for specific actions.
        - **Proactive Management:** Provide insights and identify potential issues.
        - **Precision:** Confirm essential details before performing data-mutating actions.
        - **Tone:** Professional, reliable, and efficient. Use Markdown for structured data.
        MARKDOWN;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new ListClientsTool($this->company),
            new CreateClientTool($this->company),
            new UpdateClientTool($this->company),
            new DeleteClientTool($this->company),
            new ListProductsTool($this->company),
            new CreateProductTool($this->company),
            new UpdateProductTool($this->company),
            new DeleteProductTool($this->company),
            new ListInvoicesTool($this->company),
            new CalculateRevenueTool($this->company),
            new CreateInvoiceTool($this->company),
            new UpdateInvoiceTool($this->company),
            new DeleteInvoiceTool($this->company),
            new ListOrdersTool($this->company),
            new CreateOrderTool($this->company),
            new UpdateOrderTool($this->company),
            new DeleteOrderTool($this->company),
            new ListTasksTool($this->company),
            new CreateTaskTool($this->company),
            new UpdateTaskTool($this->company),
            new DeleteTaskTool($this->company),
            new ListEventsTool($this->company),
            new CreateEventTool($this->company),
            new UpdateEventTool($this->company),
            new DeleteEventTool($this->company),
            new ListInvitationsTool($this->company),
            new SendInvitationTool($this->company),
            new CancelInvitationTool($this->company),
            new ListConversationsTool($this->company),
            new ViewMessagesTool($this->company),
            new SendMessageTool($this->company),
        ];
    }
}
