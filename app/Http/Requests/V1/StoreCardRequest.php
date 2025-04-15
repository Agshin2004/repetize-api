<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: check user auth
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
            '*.term' => ['required', 'min:1', 'max:255'],
            '*.definition' => ['required'],
            '*.desk_id' => ['required', 'integer']  // using desk_id because from prepareForValidation we will make and send desk_id
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];
        foreach ($this->toArray() as $obj) {
            // Replace deskId
            $obj['desk_id'] = $obj['deskId'] ?? null;
            $data[] = $obj;
        }
        // merge into user sent data
        $this->merge($data);
    }
}
