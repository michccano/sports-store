<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('products')->delete();

        \DB::table('products')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Marc\'s Preferred Picks Executive Football Service',
                'description' => '<center><span class="verdana14">Preferred Picks Executive Through The Super Bowl</span><br /><br /></center>
<p>&nbsp;</p>
<p class="product_info_desc">&nbsp;</p>
<table border="0" width="94%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="verdana14" align="center">
<p align="center">&bull;&nbsp;Includes every Preferred Picks Executive Football selection Marc makes through the Super Bowl&nbsp;</p>
<p align="center">&bull; Documented winning seasons 11 of last 13 years&nbsp;</p>
<p align="center">&bull; Only professional handicapper with over 500 Documented Top 10 Handicapping Achievement awards verified by The Sports Monitor in Oklahoma&nbsp;</p>
<p align="center">&bull; NFL columnist for the USA Today Sports Weekly&nbsp;</p>
<p align="center">&bull; All selections released every Friday after 1:00 PM ET&nbsp;</p>
<p align="center">&bull;&nbsp;Includes weekly Playbook Football Newsletter and weekly Playbook Midweek Alert Late Football Newsletter&nbsp;thru the Super Bowl&nbsp;</p>
<p align="center">&nbsp;&bull; Also included is Marc\'s Daily Playbook Coffee Club e-newsletter delivered to your in-box through the Super Bowl</p>
<p align="center">&nbsp;</p>
<p align="center">&bull; Cost is only $899 complete &ndash; Save over $500</p>
<p>To order click on&nbsp;<span style="color: blue;"><strong>ADD TO CART&nbsp;</strong></span>below or call<br /><strong>954.377.8000</strong></p>
</td>
</tr>
</tbody>
</table>',
                'price' => NULL,
                'weekly_price' => '500',
                'img' => '1633264482-MarcsPreferredPicksExecutiveFootballService.jpg',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-03 12:34:42',
                'updated_at' => '2021-10-03 12:34:42',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => '2021 Playbook Football Preview Guide Magazine',
                'description' => '<center><span class="verdana14">Digital Version</span><br /><br /></center>
<p>&nbsp;</p>
<p class="product_info_desc">&nbsp;</p>
<table border="0" width="94%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="verdana14" align="center">
<p>&bull; 248 Pages of previews on every FBS College Football and NFL team for the 2021 season</p>
<p>&bull; Complete team schedules including<br />ATS series history</p>
<p>&bull; Features Best and Worst team trends and complete 2021 team stat-logs<br />for each game played</p>
<p>&bull; Full 10-year ATS history results for every<br />CFB and NFL team</p>
<p>&bull; 4-Year Statistical Review for every<br />CFB and NFL team</p>
<p>&bull; 2021 CFB and NFL team analysis<br />preview and prognosis</p>
<p>&bull; Exclusive Handicapper\'s Corner featuring 2021 CFB and NFL team previews<br />and handicapping edges!</p>
<p>&bull; To order click on&nbsp;<strong><span style="color: navy;">ADD TO CART</span></strong>&nbsp;below or call<br /><strong>954.377.8000</strong></p>
</td>
</tr>
</tbody>
</table>',
                'price' => NULL,
                'weekly_price' => '110',
                'img' => '1633265266-2021PlaybookFootballPreviewGuideMagazine.jpg',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-03 12:47:46',
                'updated_at' => '2021-10-03 12:47:46',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Playbook Playbucks Tokens - 1',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.<br /><br />Thank you and enjoy all the added benefits of your Playbucks Tokens. This purchase = 1 Green Token. Zero Gold Award Tokens<br /><br /><strong>Type in quantity requested and hit Update Cart. Confirm that your Qty and Price match, then click CheckoutService.</strong></p>',
                'price' => NULL,
                'weekly_price' => '1',
                'img' => '1633331339-PlaybookPlaybucksTokens1.png',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 4,
                'created_at' => '2021-10-04 07:08:59',
                'updated_at' => '2021-10-04 07:08:59',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Playbook Playbucks Tokens - 100',
                'description' => '<p><strong>Playbook Playbucks Tokens - 100</strong></p>',
                'price' => NULL,
                'weekly_price' => '100',
                'img' => '1633350408-PlaybookPlaybucksTokens100.png',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 4,
                'created_at' => '2021-10-04 12:26:49',
                'updated_at' => '2021-10-04 12:26:49',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Coin',
                'description' => '<p>dfszxxx</p>',
                'price' => '10',
                'weekly_price' => '80',
                'img' => '1634479521-Coin.jpg',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-17 14:05:21',
                'updated_at' => '2021-10-18 08:40:34',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Coin2',
                'description' => '<p>sdfsf</p>',
                'price' => '20',
                'weekly_price' => '90',
                'img' => '1634544669-Coin2.jpg',
                'status' => 1,
                "display_date" =>  '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-18 08:11:09',
                'updated_at' => '2021-10-18 08:11:09',
            ),
        ));


    }
}
