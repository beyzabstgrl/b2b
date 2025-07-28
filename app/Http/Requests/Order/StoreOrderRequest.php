<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()?->role === 'customer';
    }

    public function rules(): array
    {
        return [
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'               => 'En az bir ürün eklemelisiniz.',
            'items.*.product_id.exists'    => 'Geçersiz ürün seçimi.',
            'items.*.quantity.min'         => 'Adet en az 1 olabilir.',
        ];
    }
}

