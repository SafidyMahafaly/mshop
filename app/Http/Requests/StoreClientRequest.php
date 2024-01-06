<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:100'],
            'fb_name'=>['required', 'string', 'max:100'],
            'phone'=>['required',Rule::unique('clients', 'phone')],
            'adress'=>['required', 'string', 'max:100'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Le nom du client est obligatoire',
            'name.string'=>'Le nom doit etre une chaine de caractère',
            'name.max'=>'Le nom ne doit pas depasser :max caractères',
            'fb_name.required'=>'Le fb name du client est obligatoire',
            'fb_name.string'=>'Le fb name doit etre une chaine de caractère',
            'fb_name.max'=>'Le fb name ne doit pas depasser :max caractères',
            'adress.required'=>'L\'adress du client est obligatoire',
            'adress.string'=>'L\'adress doit etre une chaine de caractère',
            'adress.max'=>'L\'adress ne doit pas depasser :max caractères',
            'phone.required'=>'Le numéro téléphone du client est obligatoire',
            'phone.unique'=>'Ce numéro est déjà utilisé',
        ];
    }
}
