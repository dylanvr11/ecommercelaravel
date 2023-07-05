<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
		return [
            'category_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'image' => ['required', 'string'],
            'stock' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
			//'role' => ['required'],
		];
    }
    public function messages()
	{
		return [
            'category_id.required' => 'La categoria es requerido',
            'category_id.string' => 'La categoria no es no es valida.',

			'name.required' => 'El nombre es requerido.',
			'name.string' => 'El nombre no es valido.',

            'image.required' => 'La imagen es requerida.',
            'image.string' => 'La imagen no es valido.',

            'stock.required' => 'El almacenamiento es requerido',
            'stock.numeric'=> 'El almacenamiento no es valido.',

            'description.required' => 'La descripcion es requerida.',
            'description.string' => 'La descripcion no es valido.',

            'price.required' => 'El precio es requerido.',
            'price.numeric' => 'El precio no es valido.'
		];
	}
}
