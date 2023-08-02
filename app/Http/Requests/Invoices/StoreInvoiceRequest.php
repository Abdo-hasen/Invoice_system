<?php

namespace App\Http\Requests\Invoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|min:3', 
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'product' => 'required|string',
            'section_id' => 'required|exists:sections,id',
            'amount_collection' => 'nullable|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'numeric',
            'rate_vat' => 'required|string',
            'value_vat' => 'numeric',
            'total' => 'numeric',
            'note' => 'nullable|string',
            'payment_date' => 'nullable|date',
            "file" => "nullable|mimes:pdf,jpg,png,jpeg"
        ];
      
    }
}


