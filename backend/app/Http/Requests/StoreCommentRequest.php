<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; //  per ora permettiamo tutto
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|min:2|max:1000',
        ];
    }
}