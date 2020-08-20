<?php

use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $memberships = [
            [
                'membership_name' => 'Silver',
                'membership_slug' => 'silver',
                'membership_price' => 100000,
                'vat_in_percentage' => 10
            ],
            [
                'membership_name' => 'Gold',
                'membership_slug' => 'gold',
                'membership_price' => 200000,
                'vat_in_percentage' => 10
            ],
            [
                'membership_name' => 'Platinum',
                'membership_slug' => 'platinum',
                'membership_price' => 300000,
                'vat_in_percentage' => 10
            ],
            [
                'membership_name' => 'Black',
                'membership_slug' => 'black',
                'membership_price' => 500000,
                'vat_in_percentage' => 10
            ],
            [
                'membership_name' => 'VIP',
                'membership_slug' => 'vip',
                'membership_price' => 1000000,
                'vat_in_percentage' => 10
            ],
            [
                'membership_name' => 'VVIP',
                'membership_slug' => 'vvip',
                'membership_price' => 300000,
                'vat_in_percentage' => 10
            ],
        ];

        foreach ($memberships as $membership) :
            \App\Models\Membership::create($membership);
        endforeach;
    }
}
