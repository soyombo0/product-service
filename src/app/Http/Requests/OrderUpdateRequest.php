<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'name' => 'string',
            'game' => ['string', 'required'],
            'price' => ['integer', 'required'],
            'games_in_total' => ['integer'],
            'efriend_id' => ['integer', 'required'],
            'customer_id' => ['integer'],
        ];
    }
}
