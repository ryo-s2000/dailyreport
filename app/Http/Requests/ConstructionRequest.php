<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstructionRequest extends FormRequest
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
            'number' => ['required', 'unique:constructions', 'string', 'max:10'],
            'name' => ['required', 'string', 'max:150'],
            'orderer' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable', 'integer'],
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date'],
            'place' => ['nullable', 'string'],
            'sales' => ['nullable', 'string'],
            'supervisor' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ];
    }

    public function constructionAttributes()
    {
        return $this->only([
            'number',
            'name',
            'orderer',
            'price',
            'start',
            'end',
            'place',
            'sales',
            'supervisor',
            'remarks',
            'updated_at',
        ]);
    }
}
