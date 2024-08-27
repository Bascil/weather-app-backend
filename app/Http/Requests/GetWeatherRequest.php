<?php

namespace App\Http\Requests;

use App\Helpers\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetWeatherRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'city' => ['required', 'string', 'min:2'],
            'units' => ['required', Rule::in([
                Constants::UNIT_STANDARD,
                Constants::UNIT_METRIC,
                Constants::UNIT_IMPERIAL,
            ])],
        ];
    }
}
