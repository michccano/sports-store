<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Orders')->delete();
        
        \DB::table('Orders')->insert(array (
            0 => 
            array (
                'id' => 2,
                'invoice' => 'ORD-00000000',
                'total_bill' => 610,
                'card_payment_amount' => 610,
                'token_payment_amount' => 0,
                'transactionReference' => '60177616150',
                'transactionId' => 'TRN-00000000',
                'cardNumber' => '3088000000000017',
                'user_id' => 1,
                'created_at' => '2021-10-20 06:52:36',
                'updated_at' => '2021-10-20 06:52:36',
            ),
            1 => 
            array (
                'id' => 3,
                'invoice' => 'ORD-00000001',
                'total_bill' => 101,
                'card_payment_amount' => 101,
                'token_payment_amount' => 0,
                'transactionReference' => '60177616287',
                'transactionId' => 'TRN-00000001',
                'cardNumber' => '3088000000000017',
                'user_id' => 1,
                'created_at' => '2021-10-20 06:53:57',
                'updated_at' => '2021-10-20 06:53:57',
            ),
            2 => 
            array (
                'id' => 5,
                'invoice' => 'ORD-00000002',
                'total_bill' => 400,
                'card_payment_amount' => NULL,
                'token_payment_amount' => NULL,
                'transactionReference' => 'TRN-00000001',
                'transactionId' => 'TRN-00000002',
                'cardNumber' => 'TRN-00000001',
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'invoice' => 'ORD-00000003',
                'total_bill' => 610,
                'card_payment_amount' => 610,
                'token_payment_amount' => 0,
                'transactionReference' => '60177690636',
                'transactionId' => 'TRN-00000003',
                'cardNumber' => '6011000000000012',
                'user_id' => 1,
                'created_at' => '2021-10-20 12:07:49',
                'updated_at' => '2021-10-20 12:07:49',
            ),
        ));
        
        
    }
}