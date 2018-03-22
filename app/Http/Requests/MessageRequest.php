<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'contact' => 'required|max:255',
            'data' => 'required|max:255',
            'provider_type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Введите тип',
            'contact.required' => 'Введите контакт',
            'data.required' => 'Введите данные',
            'provider_type.required' => 'Выберите провайдера/ов',
        ];
    }
}
