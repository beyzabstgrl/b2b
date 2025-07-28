<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'           => 'sometimes|string|max:255',
            'sku'            => "sometimes|string|unique:products,sku,{$id}",
            'price'          => 'sometimes|numeric|min:0',
            'stock_quantity' => 'sometimes|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'             => 'Ürün adı metin biçiminde olmalıdır.',
            'name.max'                => 'Ürün adı en fazla :max karakter olabilir.',

            'sku.string'              => 'SKU kodu metin biçiminde olmalıdır.',
            'sku.unique'              => 'Bu SKU kodu zaten kullanımda.',

            'price.numeric'           => 'Fiyat sayısal bir değer olmalıdır.',
            'price.min'               => 'Fiyat en az :min olmalıdır.',

            'stock_quantity.integer'  => 'Stok miktarı tam sayı olmalıdır.',
            'stock_quantity.min'      => 'Stok miktarı en az :min olmalıdır.',
        ];
    }
}

