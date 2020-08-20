<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use LVR\CreditCard\CardNumber;
use App\Http\Controllers\Controller;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\ExpirationDateValidator;

class ValidatorStepController extends Controller
{
    public function checkValidationStepOne(Request $request)
    {
        $rules = [
            'first_name' => [
                'nullable',
                'alpha_spaces'
            ],
            'last_name' => [
                'required',
                'alpha_spaces'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'term_and_condition' => [
                'accepted'
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed'
            ]
        ];
        $this->validate($request, $rules);
        return \response()->json(['message' => 'OK']);
    }

    public function checkValidationStepTwo(Request $request)
    {
        $rules = [
            'address' => [
                'required',
                'array'
            ],
            'address.*' => [
                'required',
                'min:10'
            ],
            'birthday' => [
                'required',
                'date',
                'before:' . \now()->subYears(10)->toDateString()
            ],
            'gender' => [
                'required',
                'in:male,female'
            ],
            'membership_id' => [
                'required',
                'exists:memberships,id'
            ],
            'membership_fee' => [
                'required',
                'numeric',
                'min:0'
            ],
            'membership_vat' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],
            'credit_card.credit_card_number' => [
                'required',
                new CardNumber,
            ],
            'credit_card.credit_card_type' => [
                'required',
                'in:visa,mastercard,amex,jcb',
            ],
            'credit_card.expired_month' => [
                'required',
                'digits:2',

            ],
            'credit_card.expired_year' => [
                'required',
                'digits:4',
            ]
        ];
        $this->validate($request, $rules);
        $a = ExpirationDateValidator::validate(
            $request->input('credit_card')['expired_year'],
            $request->input('credit_card')['expired_month'],
        );
        if (!$a) {
            return \response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'credit_card.expired_month' => 'Expired Date invalid',
                    'credit_card.expired_year' => 'Expired Date invalid',
                ]
            ], 422);
        }
        return \response()->json(['message' => 'OK']);
    }
}
