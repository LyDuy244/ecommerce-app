<?php

namespace App\Http\Requests;

use App\Models\PostCatalogue;
use App\Rules\checkPostCatalogueChildrenRule;
use Illuminate\Foundation\Http\FormRequest;

class DeletePostCatalogueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postCatalogueId = $this->route('id');
        return [
            'catalogue' => ['required', new checkPostCatalogueChildrenRule()],
        ];
    }
}
