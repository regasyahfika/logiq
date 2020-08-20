<?php

namespace App\Http\Controllers\Registration;

use App\User;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\Membership;
use Illuminate\Http\Request;
use LVR\CreditCard\CardNumber;
use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\ExpirationDateValidator;

class RegisterController extends Controller
{
    public function register(Request $request)
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
            ],
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

        try{
            \DB::beginTransaction();
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->birthday = $request->input('birthday');
            $user->gender = $request->input('gender');
            $user->term_conditional = 1;
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $membership = Membership::find($request->input('membership_id'));
            $additional = [
                'price' => $membership->membership_price,
                'vat' => 10,
                'vat_nominal' => (10 / 100) * $membership->membership_price
            ];
            $age = Carbon::parse($request->input('birthday'))->diffInYears(now());
            if (($membership->membership_slug == 'silver' && $age > 17) ||
                ($membership->membership_slug == 'gold' && $age > 20) ||
                ($membership->membership_slug == 'platinum' && $age > 22)
            ) {
                $additional['vat'] = 0;
                $additional['vat_nominal'] = 0;
            }
            $user->memberships()->sync([$membership->id => $additional]);
            foreach($request->input('address') as $address){
                Address::create([
                    'address'=>$address,
                    'user_id'=>$user->id
                ]);
            }
            $creditCardData = $request->input('credit_card');
            $creditCardData['user_id'] = $user->id;
            CreditCard::create($creditCardData);
            \DB::commit();
            return response()->json(['message'=>'OK']);
        }catch(\Exception $exception){
            \DB::rollBack();
            dd($exception);
        }

    }

    public function checkFeeForMembership(Request $request)
    {
        $rules = [
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
        ];
        $this->validate($request, $rules);
        $membership = Membership::find($request->input('membership_id'));
        $additional = [
            'price' => $membership->membership_price,
            'vat' => 10,
            'vat_nominal' => (10 / 100) * $membership->membership_price
        ];
        $age = Carbon::parse($request->input('birthday'))->diffInYears(now());
        if (($membership->membership_slug == 'silver' && $age > 17) ||
            ($membership->membership_slug == 'gold' && $age > 20) ||
            ($membership->membership_slug == 'platinum' && $age > 22)
        ) {
            $additional['vat'] = 0;
            $additional['vat_nominal'] = 0;
        }
        return response()->json($additional);
    }
}
