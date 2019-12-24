<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'medical_service_ids' => 'required|array|exists:medical_services,id|min:1',
            'discount' => 'numeric|min:0'.(request('discount_type') == 'percentage' ? '|max:100' : null),
            'discount_type' => 'string|in:percentage,flat'
        ];
    }
}
