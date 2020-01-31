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
            'number' => ['required' , 'unique:constructions', 'string' , 'max:10'],
            'name' => ['required' , 'string', 'max:150'],
            'orderer' => ['nullable' , 'string', 'max:50' ],
            'price' => ['nullable' , 'integer'],
        ];
    }

    public function constructionAttributes()
    {
        return $this->only([
            'number',
            'name',
            'orderer',
            'price',
            'updated_at'
        ]);
    }
}
