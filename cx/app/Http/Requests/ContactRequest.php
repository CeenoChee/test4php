<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns,spoof',
            'message' => 'required',
            'job' => Rule::in(['']), // honeypot
            'part-time-job' => Rule::in(['']), // honeypot
        ];

        return $this->addCaptchaValidationInProduction($rules);
    }

    private function addCaptchaValidationInProduction(array $rules): array
    {
        if (config('app.env') === 'production') {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }
}
