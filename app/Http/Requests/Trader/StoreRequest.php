<?php

namespace App\Http\Requests\Trader;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'department_id' => ['required', 'integer', 'max:20'],
        ];
    }

    public function traderAttributes(): array
    {
        return $this->only([
            'name',
            'department_id',
        ]);
    }
}
