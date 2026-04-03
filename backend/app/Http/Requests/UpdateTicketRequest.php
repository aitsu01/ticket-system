<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',

            'status' => 'sometimes|in:open,in_progress,resolved,closed',
            'priority' => 'sometimes|in:low,medium,high',

            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}