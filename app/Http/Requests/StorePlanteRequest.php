<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|unique:plantes,nom',
            'description' => 'required|string',
            'image' => 'required|string',
            'prix' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gt:0',
            'categorie_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est requis',
            'description.required' => 'La description est requise',
            'image.required' => 'L\'image est requise',
            'prix.required' => 'Le prix est requis',
            'prix.gt' => 'Le prix doit être supérieur à 0',
            'stock.gt' => 'Le stock doit être supérieur à 0',
            'stock.required' => 'Le stock est requis',
            'categorie_id.required' => 'La catégorie est requise',
        ];
    }



}
