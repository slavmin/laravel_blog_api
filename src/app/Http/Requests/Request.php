<?php

namespace App\Http\Requests;

//use App\Concerns\SendsAlerts;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    //use SendsAlerts;

    //    protected function failedValidation(Validator $validator): void
    //    {
    //        // $this->error('errors.fields');
    //
    //        parent::failedValidation($validator);
    //    }
}
