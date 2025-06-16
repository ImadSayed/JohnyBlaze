<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'caption' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'media' => 'required',
            'media.*' => 'file|mimes:mp4,mov,3gpp|max:2048', // Validate each media file
            'media.*.type' => 'required|string|in:video,audio', // Ensure each media file has a type
            'media.*.url' => 'required|url', // Ensure each media file has a valid URL
        ];
    }
}
