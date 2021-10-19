<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PublishedProductsTableSeeder extends Seeder
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
                'category_id' => 2,
                'created_at' => '2021-10-03 12:34:42',
                'description' => '<center><span class="verdana14">Preferred Picks Executive Through The Super Bowl</span><br />
<p align="center">&bull;&nbsp;Includes every Preferred Picks Executive Football selection Marc makes through the Super Bowl&nbsp;</p>
<p align="center">&bull; Documented winning seasons 11 of last 13 years&nbsp;</p>
<p align="center">&bull; Only professional handicapper with over 500 Documented Top 10 Handicapping Achievement awards verified by The Sports Monitor in Oklahoma&nbsp;</p>
<p align="center">&bull; NFL columnist for the USA Today Sports Weekly&nbsp;</p>
<p align="center">&bull; All selections released every Friday after 1:00 PM ET&nbsp;</p>
<p align="center">&bull;&nbsp;Includes weekly Playbook Football Newsletter and weekly Playbook Midweek Alert Late Football Newsletter&nbsp;thru the Super Bowl&nbsp;</p>
<p align="center">&nbsp;&bull; Also included is Marc\'s Daily Playbook Coffee Club e-newsletter delivered to your in-box through the Super Bowl</p>
<p align="center">&nbsp;Cost is only $850 complete &ndash; Save over $500</p>
<p>To order click on&nbsp;<span style="color: blue;"><strong>ADD TO CART&nbsp;</strong></span>below or call<br /><strong>954.377.8000</strong></p>
</center>
<p>&nbsp;</p>
<p class="product_info_desc">&nbsp;</p>',
                'id' => 1,
                'img' => '1634230820-MarcsPreferredPicksExecutiveFootballServicePreferredPicksExecutiveThroughTheSuperBowl.jpg',
                'name' => 'Marc\'s Preferred Picks Executive Football Service Preferred Picks Executive Through The Super Bowl',
                'price' => '850',
                'status' => 1,
                'updated_at' => '2021-10-14 17:00:20',
            ),
            1 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-03 12:47:46',
                'description' => '<table border="0" width="94%" cellspacing="0" cellpadding="0">
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
                'id' => 2,
                'img' => '1634231024-2021PlaybookFootballPreviewGuideMagazineDigitalVersion.jpg',
                'name' => '2021 Playbook Football Preview Guide Magazine Digital Version',
                'price' => '12',
                'status' => 1,
                'updated_at' => '2021-10-14 17:03:44',
            ),
            2 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:02:11',
                'description' => '<table border="0" width="94%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="verdana14" align="center">
<p>&bull; Includes weekly&nbsp;online Playbook Football Newsletter subscription thru the&nbsp;Super Bowl</p>
<p>&bull;&nbsp;&nbsp;Playbook Football Newsletter available every Wednesday thru the Member Center after 9 PM ET<br /><br />&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine viewed online.<br /><br />&bull; Includes 2021 Playbook NFL Draft Complete Recap.<br /><br />&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription!<br /><br /><strong>Cost $85 complete for a limited time.</strong></p>
To order click on<br /><span style="color: blue;"><strong>ADD TO CART&nbsp;</strong></span>below or call<br /><strong>954.377.8000</strong></td>
</tr>
</tbody>
</table>',
                'id' => 5,
                'img' => '1634230931-2021PlaybookFootballNewsletterWithPlaybookDigitalYearbookMagazine.jpg',
                'name' => '2021 Playbook Football Newsletter With Playbook Digital Yearbook Magazine',
                'price' => '85',
                'status' => 1,
                'updated_at' => '2021-10-14 17:02:11',
            ),
            3 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:12:38',
                'description' => '<p>&bull; Includes complete NFL preseason schedule, preseason best bets, NFL coaches preseason records, 2-minute handicaps, preseason Over/Unders, preseason Awesome Angle, Incredible Stat and Super Systems, NFL &amp; College Football stats from last season,&nbsp;</p>
<p>&bull; Marc\'s Top 10 ATS teams for 2021, 2021 NFL strength of schedule, NFL Preseason Report, NFL preseason QB rotations,&nbsp;</p>
<p>&bull; Playbook Experts forecasts for the 2021 season, College Football early week game write-ups and more! &nbsp;</p>
<p>&bull; &nbsp;Cost is only $10</p>',
                'id' => 6,
                'img' => '1634231558-2021PlaybookFootballNewsletterIssue8.jpg',
                'name' => '2021 Playbook Football Newsletter Issue 8',
                'price' => '10',
                'status' => 1,
                'updated_at' => '2021-10-14 17:12:38',
            ),
            4 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:15:06',
                'description' => '<p align="center">&bull; The only Over/Under NFL Totals Newsletter in the nation</p>
<p align="center">&bull; Best Bets 199-144-4 Last 6 Years</p>
<p align="center">&bull; Winning Seasons 12 of Last 13 Years. Overall 381-279-8 ATS (58%)</p>
<p align="center">&bull; Available every Tuesday thru the end of the NFL regular season via Member Center Thursdays after 5 PM ET</p>
<p align="center">&bull; NFL Team Total Of The Week 25-9 last two seasons!</p>
<p align="center">&bull; You also receive a digital 2021 Playbook Yearbook Magazine</p>
<p align="center">Added bonuses: &nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB<br />and 2021 NFL DRAFT COMPLETE RECAP&nbsp;with full<br />season football newsletter subscription</p>',
                'id' => 7,
                'img' => '1634231706-2021PlaybookNFLTotalsTipsheetNewsletterWithPlaybookDigitalYearbookMagazine.jpg',
                'name' => '2021 Playbook NFL Totals Tipsheet Newsletter With Playbook Digital Yearbook Magazine',
                'price' => '75',
                'status' => 1,
                'updated_at' => '2021-10-14 17:15:06',
            ),
            5 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:20:50',
                'description' => '<p align="center">&bull; The only Over/Under NFL Totals Newsletter in the nation</p>
<p align="center">&bull; Best Bets 199-144-4 Last 6 Years</p>
<p align="center">&bull; Winning Seasons 12 of Last 13 Years. Overall 381-279-8 ATS (58%)</p>
<p align="center">&bull; Available every Tuesday thru the end of the NFL regular season via Member Center Thursdays after 5 PM ET</p>
<p align="center">&bull; NFL Team Total Of The Week 25-9 last two seasons!</p>
<p align="center">&bull; You also receive a digital 2021 Playbook Yearbook Magazine</p>
<p align="center">Added bonuses: &nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB<br />and 2021 NFL DRAFT COMPLETE RECAP&nbsp;with full<br />season football newsletter subscription</p>',
                'id' => 8,
                'img' => '1634232050-2021PlaybookNFLTotalsTipsheetNewsletterIssue6.jpg',
                'name' => '2021 Playbook NFL Totals Tipsheet Newsletter Issue 6',
                'price' => '10',
                'status' => 1,
                'updated_at' => '2021-10-14 17:20:50',
            ),
            6 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:22:11',
                'description' => '<p>&bull; Exclusive weekly Playbook Stat Rankings and Power Ratings for every CFB and NFL team</p>
<p>&bull; Weekly newsletter available starting Sep 22 thru Super Bowl via Member Center every Thursday 3 PM ET</p>',
                'id' => 9,
                'img' => '1634232131-2021PlaybookMidweekAlertLateNewsletterIssue4.jpg',
                'name' => '2021 Playbook Midweek Alert Late Newsletter Issue 4',
                'price' => '12',
                'status' => 1,
                'updated_at' => '2021-10-14 17:22:11',
            ),
            7 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:23:56',
                'description' => '<p>&bull; Exclusive weekly Playbook Stat Rankings and Power Ratings for every CFB and NFL team</p>
<p>&bull; Weekly newsletter available starting Sep 22 thru Super Bowl via Member Center every Thursday 3 PM ET</p>
<p>&bull;&nbsp;<a href="https://www.playbook.com/2019MW6.pdf" target="_blank" rel="noopener">Click here</a>&nbsp;for a Sample of last season\'s Midweek Alert Newsletter</p>
<p><strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>
<p>Cost $89 &ndash; save $199 off weekly cost</p>',
                'id' => 10,
                'img' => '1634232236-2021PlaybookMidweekAlertLateNewsletterWithPlaybookCollegeBowlStatReport.jpg',
                'name' => '2021 Playbook Midweek Alert Late Newsletter With Playbook College Bowl Stat Report',
                'price' => '89',
                'status' => 1,
                'updated_at' => '2021-10-14 17:23:56',
            ),
            8 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:25:49',
                'description' => '<p align="center">&bull; Includes weekly Playbook and Late Breaking Midweek Alert online Football Newsletter subscriptions</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p align="center">&bull; Playbook Midweek Alert Football Newsletter available thru the Super Bowl via Member Center Thursdays after 12 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Midweek%20Alert%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p align="center">&bull; Includes 2021 College Bowl Stat Report ($24 value)</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>',
                'id' => 11,
                'img' => '1634232349-2021PlaybookNewsletterDoublePlayWithPlaybookDigitalYearbookMagazine.jpg',
                'name' => '2021 Playbook Newsletter Double Play With Playbook Digital Yearbook Magazine',
                'price' => '155',
                'status' => 1,
                'updated_at' => '2021-10-14 17:25:49',
            ),
            9 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:26:51',
                'description' => '<p align="center">&bull; Includes weekly Playbook Football and Playbook Totals online Football Newsletter subscriptions</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p>&bull; Playbook Totals Tipsheet Newsletter available thru the NFL regular season via Member Center Tuesdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Tipsheet%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>',
                'id' => 12,
                'img' => '1634232411-2021PlaybookNewsletterDynamicDuoWithPlaybookDigitalYearbookMagazine.jpg',
                'name' => '2021 Playbook Newsletter Dynamic Duo With Playbook Digital Yearbook Magazine',
                'price' => '149',
                'status' => 1,
                'updated_at' => '2021-10-14 17:26:51',
            ),
            10 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:27:49',
                'description' => '<p>&bull; A collection of the five best selling Playbook Football publications all in one special discount package.</p>
<p>&bull; Includes Playbook Football Newsletter, Midweek Alert Football Newsletter, Totals Tipsheet Newsletter and College Bowl Stat Report.</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p>&bull; Playbook Totals Tipsheet Newsletter available thru the NFL regular season via Member Center Tuesdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Tipsheet%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p>&bull; Playbook Midweek Alert Newsletter available thru the NFL regular season via Member Center Thursdays after 12 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Midweek%20Alert%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription.</p>',
                'id' => 13,
                'img' => '1634232469-2021PlaybookNewsletterTriplePlaySpecialWithPlaybookDigitalYearbookMagazine.jpg',
                'name' => '2021 Playbook Newsletter Triple Play Special With Playbook Digital Yearbook Magazine',
                'price' => '219',
                'status' => 1,
                'updated_at' => '2021-10-14 17:27:49',
            ),
            11 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:29:27',
            'description' => '<p>Marc has been on fire this football season, going 22-8 overall. Hop on board his&nbsp;<strong>FAN APPRECIATION WEEKEND OF WINNERS</strong>&nbsp;and get all of his Football and MLB Playoff releases (4-0 first week) this Saturday thru Monday for only $79, including his&nbsp;<strong>College Football False Favorite Game Of the Month</strong>. Click here or call 800.321.7777 now!</p>',
                'id' => 14,
                'img' => '1634258874-2021FootballAnd2022BasketballNewsletterWithPrintedPlaybookYearbookMagazine.jpg',
                'name' => 'Marc’s Fan Appreciation Football Weekend Of Winners!',
                'price' => '79',
                'status' => 1,
                'updated_at' => '2021-10-15 00:49:27',
            ),
            12 => 
            array (
                'category_id' => 5,
                'created_at' => '2021-10-14 17:31:54',
                'description' => '<p>&bull; 256 Pages of previews on every FBS College Football and NFL team for the 2021 season</p>
<p>&bull; Complete team schedules including<br />ATS series history</p>
<p>&bull; Features Best and Worst team trends and complete 2021 team stat-logs<br />for each game played</p>
<p>&bull; Full 10-year ATS history results for every<br />CFB and NFL team</p>
<p>&bull; 4-Year Statistical Review for every<br />CFB and NFL team</p>
<p>&bull; 2021 CFB and NFL team analysis<br />preview and prognosis</p>
<p>&bull; Exclusive Handicapper\'s Corner featuring 2021 CFB and NFL team previews<br />and handicapping edges!</p>
<p>Cost $24 shipped via Priority Mail starting in July.</p>',
                'id' => 15,
                'img' => '1634232714-2021PlaybookFootballPreviewGuideMagazinePrintVersion.jpg',
                'name' => '2021 Playbook Football Preview Guide Magazine Print Version',
                'price' => '24',
                'status' => 1,
                'updated_at' => '2021-10-14 17:31:54',
            ),
            13 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:33:14',
                'description' => '<p align="center">&bull; Weekly work schedules on every college and NFL team to help you prepare for the week\'s games ahead.</p>
<p align="center">&bull;&nbsp;Features two full pages on every FBS College Football and NFL team, including complete 10-year history records versus every opponent.</p>
<p align="center">&bull;&nbsp;10 years of scores and head-to-head match-up results</p>
<p align="center">&bull; Plus 10-year situational records for every team, and complete 10-year game-by-game chronology results of every team.</p>
<p align="center">&bull;&nbsp;The top-selling football reference stat book used by the pros, designed for the true handicapper with room to log all your stats. &nbsp;It\'s Marc\'s bible and it should be yours, too!</p>
<p align="center">&bull; Cost $50.00 (shipping within the US included)</p>',
                'id' => 16,
                'img' => '1634232794-2021PlaybookFootballStatLogBook400PagesOfMustHaveCollegeNFLData.jpg',
                'name' => '2021 Playbook Football Stat Log Book 400 Pages Of Must Have College & NFL Data',
                'price' => '50',
                'status' => 1,
                'updated_at' => '2021-10-14 17:33:14',
            ),
            14 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:34:30',
                'description' => '<p>Marc started the MLB playoffs 4-0 this first week. Get every red-hot release he makes during the MLB playoffs thru the World Series with his $99 MLB Playoff Payoff Package. Join today and starting winning tonight!</p>',
                'id' => 17,
                'img' => '1634232870-MarcLawrenceMLBPlayoffPackageAvailableNow.jpg',
                'name' => 'Marc Lawrence MLB Playoff Package Available Now',
                'price' => '99',
                'status' => 1,
                'updated_at' => '2021-10-14 17:34:30',
            ),
            15 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:35:30',
            'description' => '<center><span class="verdana16" style="color: black;"><strong>Marc&rsquo;s Fan Appreciation Football Weekend Of Winners!</strong><br /></span><span class="verdana14">Starts Sat. 10/16</span>Marc has been on fire this football season, going 22-8 overall. Hop on board his&nbsp;<strong>FAN APPRECIATION WEEKEND OF WINNERS</strong>&nbsp;and get all of his Football and MLB Playoff releases (4-0 first week) this Saturday thru Monday for only $79, including his&nbsp;<strong>College Football False Favorite Game Of the Month</strong>. Click here or call 800.321.7777 now!</center>',
                'id' => 18,
                'img' => '1634232930-MarcsFanAppreciationFootballWeekendOfWinnersStartsSat1016.jpg',
                'name' => 'Marc’s Fan Appreciation Football Weekend Of Winners! Starts Sat. 10/16',
                'price' => '79',
                'status' => 1,
                'updated_at' => '2021-10-14 17:35:30',
            ),
            16 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:37:32',
                'description' => '<p>&bull; Marc\'s weekly Perfect System Club football plays from Week One of the NFL season thru the end of the NFL&nbsp;regular&nbsp;season - all plays released every Friday at 1:00 PM ET</p>
<div>&bull; Also includes weekly copy of the Playbook Football Newsletter thru the Super Bowl and free digital copy of the 2021 Playbook&nbsp;Football Preview Guide magazine</div>
<p><br />Cost $229 complete - a savings of $147!</p>',
                'id' => 19,
                'img' => '1634233052-MarcLawrence2021PlaybookPerfectSystemClubWithWeeklyPlaybookFootballNewsletterAndDigitalMagazine.jpg',
                'name' => 'Marc Lawrence 2021 Playbook Perfect System Club + With Weekly Playbook Football Newsletter And Digital Magazine',
                'price' => '229',
                'status' => 1,
                'updated_at' => '2021-10-14 17:37:32',
            ),
            17 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:38:25',
                'description' => '<p>&bull; Marc\'s weekly Economy Club football plays from Week One of the NFL season thru the end of the NFL&nbsp;regular&nbsp;season - All plays released every Thursday at 1:00 PM ET</p>
<div>&bull; Also includes weekly copy of the Playbook Football Newsletter thru the Super Bowl and free digital copy of the 2021 Playbook&nbsp;Football Preview Guide magazine</div>
<p><br />Cost $229 complete - a savings of $147!</p>',
                'id' => 20,
                'img' => '1634233105-2021MarcLawrenceEarlyWeekEconomyFootballServiceIncludesWeeklyPlaybookFootballNewsletterAndDigitalMagazine.jpg',
                'name' => '2021 Marc Lawrence Early Week Economy Football Service + Includes Weekly Playbook Football Newsletter And Digital Magazine',
                'price' => '229',
                'status' => 1,
                'updated_at' => '2021-10-14 17:38:25',
            ),
            18 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-14 17:40:26',
            'description' => '<p>Marc is on fire to start the 2021 football season,&nbsp;<strong>documented No. 1</strong>&nbsp;by the Sports Monitor in Oklahoma at 20-4 thru the first four weeks of the College Football and NFL season. Get all of his CFB &amp; NFL selections thru October. Get every College Football and NFL release Marc makes for his award-winning Preferred Picks Executive Football Service thru the end of October fo just $229! Includes his&nbsp;<strong>5* October Game Of The Month</strong>&nbsp;(All 5* Game Of The Month Plays documented 78-34-2 since 1990, including Notre Dame over Wisconsin last month) in addition to all College Football and NFL plays - plus get all his of&nbsp;<strong>MLB Playoff selections as a no-charge bonus!</strong>&nbsp;Click here to join today.</p>',
                'id' => 21,
                'img' => '1634233226-MarcLawrencesFamous5OCTOBERAMAFootballSpecialAvailableNow.jpg',
                'name' => 'Marc Lawrence\'s Famous 5* OCTOBERAMA Football Special Available Now',
                'price' => '229',
                'status' => 1,
                'updated_at' => '2021-10-14 17:40:26',
            ),
            19 => 
            array (
                'category_id' => 3,
                'created_at' => '2021-10-14 17:44:26',
            'description' => '<p>&bull; 2022 Playbook Basketball Newsletter available thru the NCAA Tourney via Member Center Thursdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Basketball%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p>&bull; Includes digital 2021 Playbook Football Preview Guide Magazine and 2021 Playbook NCAA Tourney and Sweet 16 Guides</p>
<p>&nbsp;</p>',
                'id' => 22,
                'img' => '1634233466-2022PlaybookBasketballNewsletter.jpg',
                'name' => '2022 Playbook Basketball Newsletter',
                'price' => '99',
                'status' => 1,
                'updated_at' => '2021-10-14 17:44:26',
            ),
            20 => 
            array (
                'category_id' => 6,
                'created_at' => '2021-10-14 17:49:18',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.<br /><br />Thank you and enjoy all the added benefits of your Playbucks Tokens. This purchase = 1 Green Token. Zero Gold Award Tokens</p>',
                'id' => 23,
                'img' => '1634233758-PlaybucksTokens1Token.png',
                'name' => 'Playbucks Tokens - 1 Token',
                'price' => '1',
                'status' => 1,
                'updated_at' => '2021-10-14 17:49:18',
            ),
            21 => 
            array (
                'category_id' => 6,
                'created_at' => '2021-10-14 17:50:08',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com</p>',
                'id' => 24,
                'img' => '1634233808-PlaybucksTokens50Tokens.png',
                'name' => 'Playbucks Tokens - 50 Tokens',
                'price' => '50',
                'status' => 1,
                'updated_at' => '2021-10-14 17:50:08',
            ),
            22 => 
            array (
                'category_id' => 6,
                'created_at' => '2021-10-14 17:50:53',
                'description' => '<p class="product_info_desc">Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.</p>',
                'id' => 25,
                'img' => '1634233853-PlaybucksTokens100Tokens.png',
                'name' => 'Playbucks Tokens - 100 Tokens',
                'price' => '100',
                'status' => 1,
                'updated_at' => '2021-10-14 17:50:53',
            ),
            23 => 
            array (
                'category_id' => 6,
                'created_at' => '2021-10-14 17:52:08',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.<br /><br />Thank you and enjoy all the added benefits of your Playbucks Tokens.</p>
<p>This purchase includes 500 Tokens | 100 Bonus Tokens</p>',
                'id' => 26,
                'img' => '1634233928-PlaybookPlaybucksTokens500Tokens.png',
                'name' => 'Playbook Playbucks Tokens - 500 Tokens',
                'price' => '500',
                'status' => 1,
                'updated_at' => '2021-10-14 17:52:08',
            ),
            24 => 
            array (
                'category_id' => 2,
                'created_at' => '2021-10-15 00:11:39',
            'description' => '<p>Marc is on fire to start the 2021 football season,&nbsp;<strong>documented No. 1</strong>&nbsp;by the Sports Monitor in Oklahoma at 20-4 thru the first four weeks of the College Football and NFL season. Get all of his CFB &amp; NFL selections thru October. Get every College Football and NFL release Marc makes for his award-winning Preferred Picks Executive Football Service thru the end of October fo just $229! Includes his&nbsp;<strong>5* October Game Of The Month</strong>&nbsp;(All 5* Game Of The Month Plays documented 78-34-2 since 1990, including Notre Dame over Wisconsin last month) in addition to all College Football and NFL plays - plus get all his of&nbsp;<strong>MLB Playoff selections as a no-charge bonus!</strong>&nbsp;Click here to join today.</p>',
                'id' => 27,
                'img' => '1634256699-centerfontcolor"black"class"verdana16"bbr2021PlaybookNewsletterDynamicDuobbrfontspanspanclass"verdana14"WithPlaybookDigitalYearbookMagazinespanbrbrcenter.jpg',
                'name' => '2021 Playbook Newsletter Dynamic Duo',
                'price' => '10.00',
                'status' => 1,
                'updated_at' => '2021-10-15 00:45:59',
            ),
        ));
        
        
    }
}