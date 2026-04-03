<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // dopo lo colleghiamo alle Policy
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',

            'priority' => 'required|in:low,medium,high',

            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}