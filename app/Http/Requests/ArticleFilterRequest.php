<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleFilterRequest extends FormRequest
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
        return [
            'category_id'    => 'nullable|exists:news_categories,id',
            'author_id'      => 'nullable|exists:authors,id',
            'provider_id'    => 'nullable|exists:news_providers,id',
            'source_id'      => 'nullable|exists:news_sources,id',
            'published_from' => 'nullable|date',
            'published_to'   => 'nullable|date|after_or_equal:published_from',
            'per_page'       => 'nullable|integer|min:1|max:100',
        ];
    }
}
