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

        \DB::table('products')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Marc\'s  Preferred Picks Executive Football Service Preferred Picks Executive Through The Super Bowl',
                'description' => '<p><strong>Marc\'s Preferred Picks Executive Football Service Preferred Picks Executive Through The Super Bowl</strong></p>',
                'price' => NULL,
                'weekly_price' => '850',
                'img' => '1634230820-MarcsPreferredPicksExecutiveFootballServicePreferredPicksExecutiveThroughTheSuperBowl.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-03 12:34:42',
                'updated_at' => '2021-10-14 17:00:20',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => '2021 Playbook Football Preview Guide Magazine Digital Version',
                'description' => '<p><strong>2021 Playbook Football Preview Guide Magazine Digital Version</strong></p>',
                'price' => NULL,
                'weekly_price' => '12',
                'img' => '1634231024-2021PlaybookFootballPreviewGuideMagazineDigitalVersion.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-03 12:47:46',
                'updated_at' => '2021-10-14 17:03:44',
            ),
            2 =>
            array(
                'id' => 5,
                'name' => '2021 Playbook Football Newsletter With Playbook Digital Yearbook Magazine',
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
                'price' => NULL,
                'weekly_price' => '85',
                'img' => '1634230931-2021PlaybookFootballNewsletterWithPlaybookDigitalYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:02:11',
                'updated_at' => '2021-10-14 17:02:11',
            ),
            3 =>
            array(
                'id' => 6,
                'name' => '2021 Playbook Football Newsletter Issue 8',
                'description' => '<p>&bull; Includes complete NFL preseason schedule, preseason best bets, NFL coaches preseason records, 2-minute handicaps, preseason Over/Unders, preseason Awesome Angle, Incredible Stat and Super Systems, NFL &amp; College Football stats from last season,&nbsp;</p>
<p>&bull; Marc\'s Top 10 ATS teams for 2021, 2021 NFL strength of schedule, NFL Preseason Report, NFL preseason QB rotations,&nbsp;</p>
<p>&bull; Playbook Experts forecasts for the 2021 season, College Football early week game write-ups and more! &nbsp;</p>
<p>&bull; &nbsp;Cost is only $10</p>',
                'price' => NULL,
                'weekly_price' => '10',
                'img' => '1634231558-2021PlaybookFootballNewsletterIssue8.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:12:38',
                'updated_at' => '2021-10-14 17:12:38',
            ),
            4 =>
            array(
                'id' => 7,
                'name' => '2021 Playbook NFL Totals Tipsheet Newsletter With Playbook Digital Yearbook Magazine',
                'description' => '<p align="center">&bull; The only Over/Under NFL Totals Newsletter in the nation</p>
<p align="center">&bull; Best Bets 199-144-4 Last 6 Years</p>
<p align="center">&bull; Winning Seasons 12 of Last 13 Years. Overall 381-279-8 ATS (58%)</p>
<p align="center">&bull; Available every Tuesday thru the end of the NFL regular season via Member Center Thursdays after 5 PM ET</p>
<p align="center">&bull; NFL Team Total Of The Week 25-9 last two seasons!</p>
<p align="center">&bull; You also receive a digital 2021 Playbook Yearbook Magazine</p>
<p align="center">Added bonuses: &nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB<br />and 2021 NFL DRAFT COMPLETE RECAP&nbsp;with full<br />season football newsletter subscription</p>',
                'price' => NULL,
                'weekly_price' => '75',
                'img' => '1634231706-2021PlaybookNFLTotalsTipsheetNewsletterWithPlaybookDigitalYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:15:06',
                'updated_at' => '2021-10-14 17:15:06',
            ),
            5 =>
            array(
                'id' => 8,
                'name' => '2021 Playbook NFL Totals Tipsheet Newsletter Issue 6',
                'description' => '<p align="center">&bull; The only Over/Under NFL Totals Newsletter in the nation</p>
<p align="center">&bull; Best Bets 199-144-4 Last 6 Years</p>
<p align="center">&bull; Winning Seasons 12 of Last 13 Years. Overall 381-279-8 ATS (58%)</p>
<p align="center">&bull; Available every Tuesday thru the end of the NFL regular season via Member Center Thursdays after 5 PM ET</p>
<p align="center">&bull; NFL Team Total Of The Week 25-9 last two seasons!</p>
<p align="center">&bull; You also receive a digital 2021 Playbook Yearbook Magazine</p>
<p align="center">Added bonuses: &nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB<br />and 2021 NFL DRAFT COMPLETE RECAP&nbsp;with full<br />season football newsletter subscription</p>',
                'price' => NULL,
                'weekly_price' => '10',
                'img' => '1634232050-2021PlaybookNFLTotalsTipsheetNewsletterIssue6.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:20:50',
                'updated_at' => '2021-10-14 17:20:50',
            ),
            6 =>
            array(
                'id' => 9,
                'name' => '2021 Playbook Midweek Alert Late Newsletter Issue 4',
                'description' => '<p>&bull; Exclusive weekly Playbook Stat Rankings and Power Ratings for every CFB and NFL team</p>
<p>&bull; Weekly newsletter available starting Sep 22 thru Super Bowl via Member Center every Thursday 3 PM ET</p>',
                'price' => NULL,
                'weekly_price' => '12',
                'img' => '1634232131-2021PlaybookMidweekAlertLateNewsletterIssue4.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:22:11',
                'updated_at' => '2021-10-14 17:22:11',
            ),
            7 =>
            array(
                'id' => 10,
                'name' => '2021 Playbook Midweek Alert Late Newsletter With Playbook College Bowl Stat Report',
                'description' => '<p>&bull; Exclusive weekly Playbook Stat Rankings and Power Ratings for every CFB and NFL team</p>
<p>&bull; Weekly newsletter available starting Sep 22 thru Super Bowl via Member Center every Thursday 3 PM ET</p>
<p>&bull;&nbsp;<a href="https://www.playbook.com/2019MW6.pdf" target="_blank" rel="noopener">Click here</a>&nbsp;for a Sample of last season\'s Midweek Alert Newsletter</p>
<p><strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>
<p>Cost $89 &ndash; save $199 off weekly cost</p>',
                'price' => NULL,
                'weekly_price' => '89',
                'img' => '1634232236-2021PlaybookMidweekAlertLateNewsletterWithPlaybookCollegeBowlStatReport.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:23:56',
                'updated_at' => '2021-10-14 17:23:56',
            ),
            8 =>
            array(
                'id' => 11,
                'name' => '2021 Playbook Newsletter Double Play With Playbook Digital Yearbook Magazine',
                'description' => '<p align="center">&bull; Includes weekly Playbook and Late Breaking Midweek Alert online Football Newsletter subscriptions</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p align="center">&bull; Playbook Midweek Alert Football Newsletter available thru the Super Bowl via Member Center Thursdays after 12 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Midweek%20Alert%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p align="center">&bull; Includes 2021 College Bowl Stat Report ($24 value)</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>',
                'price' => NULL,
                'weekly_price' => '155',
                'img' => '1634232349-2021PlaybookNewsletterDoublePlayWithPlaybookDigitalYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:25:49',
                'updated_at' => '2021-10-14 17:25:49',
            ),
            9 =>
            array(
                'id' => 12,
                'name' => '2021 Playbook Newsletter Dynamic Duo With Playbook Digital Yearbook Magazine',
                'description' => '<p align="center">&bull; Includes weekly Playbook Football and Playbook Totals online Football Newsletter subscriptions</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p>&bull; Playbook Totals Tipsheet Newsletter available thru the NFL regular season via Member Center Tuesdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Tipsheet%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription</p>',
                'price' => NULL,
                'weekly_price' => '149',
                'img' => '1634232411-2021PlaybookNewsletterDynamicDuoWithPlaybookDigitalYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:26:51',
                'updated_at' => '2021-10-14 17:26:51',
            ),
            10 =>
            array(
                'id' => 13,
                'name' => '2021 Playbook Newsletter Triple Play Special With Playbook Digital Yearbook Magazine',
                'description' => '<p>&bull; A collection of the five best selling Playbook Football publications all in one special discount package.</p>
<p>&bull; Includes Playbook Football Newsletter, Midweek Alert Football Newsletter, Totals Tipsheet Newsletter and College Bowl Stat Report.</p>
<p>&bull; Playbook Football Newsletter available every Wednesday thru the College Bowl games via Member Center after 9 PM ET</p>
<p>&bull; Playbook Totals Tipsheet Newsletter available thru the NFL regular season via Member Center Tuesdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Tipsheet%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p>&bull; Playbook Midweek Alert Newsletter available thru the NFL regular season via Member Center Thursdays after 12 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Midweek%20Alert%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p align="center">&bull; Includes a digital version of the 2021 Playbook Yearbook Magazine</p>
<p>&bull;&nbsp;<strong>NEW THIS SEASON</strong>:&nbsp;FREE 7 DAY A WEEK&nbsp;COFFEE CLUB and 2021 NFL DRAFT COMPLETE RECAP with full season football newsletter subscription.</p>',
                'price' => NULL,
                'weekly_price' => '219',
                'img' => '1634232469-2021PlaybookNewsletterTriplePlaySpecialWithPlaybookDigitalYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:27:49',
                'updated_at' => '2021-10-14 17:27:49',
            ),
            11 =>
            array(
                'id' => 14,
                'name' => 'Marc’s Fan Appreciation Football Weekend Of Winners!',
                'description' => '<p>Marc has been on fire this football season, going 22-8 overall. Hop on board his&nbsp;<strong>FAN APPRECIATION WEEKEND OF WINNERS</strong>&nbsp;and get all of his Football and MLB Playoff releases (4-0 first week) this Saturday thru Monday for only $79, including his&nbsp;<strong>College Football False Favorite Game Of the Month</strong>. Click here or call 800.321.7777 now!</p>',
                'price' => NULL,
                'weekly_price' => '79',
                'img' => '1634258874-2021FootballAnd2022BasketballNewsletterWithPrintedPlaybookYearbookMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:29:27',
                'updated_at' => '2021-10-15 00:49:27',
            ),
            12 =>
            array(
                'id' => 15,
                'name' => '2021 Playbook Football Preview Guide Magazine Print Version',
                'description' => '<p>&bull; 256 Pages of previews on every FBS College Football and NFL team for the 2021 season</p>
<p>&bull; Complete team schedules including<br />ATS series history</p>
<p>&bull; Features Best and Worst team trends and complete 2021 team stat-logs<br />for each game played</p>
<p>&bull; Full 10-year ATS history results for every<br />CFB and NFL team</p>
<p>&bull; 4-Year Statistical Review for every<br />CFB and NFL team</p>
<p>&bull; 2021 CFB and NFL team analysis<br />preview and prognosis</p>
<p>&bull; Exclusive Handicapper\'s Corner featuring 2021 CFB and NFL team previews<br />and handicapping edges!</p>
<p>Cost $24 shipped via Priority Mail starting in July.</p>',
                'price' => NULL,
                'weekly_price' => '24',
                'img' => '1634232714-2021PlaybookFootballPreviewGuideMagazinePrintVersion.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 5,
                'created_at' => '2021-10-14 17:31:54',
                'updated_at' => '2021-10-14 17:31:54',
            ),
            13 =>
            array(
                'id' => 16,
                'name' => '2021 Playbook Football Stat Log Book 400 Pages Of Must Have College & NFL Data',
                'description' => '<p align="center">&bull; Weekly work schedules on every college and NFL team to help you prepare for the week\'s games ahead.</p>
<p align="center">&bull;&nbsp;Features two full pages on every FBS College Football and NFL team, including complete 10-year history records versus every opponent.</p>
<p align="center">&bull;&nbsp;10 years of scores and head-to-head match-up results</p>
<p align="center">&bull; Plus 10-year situational records for every team, and complete 10-year game-by-game chronology results of every team.</p>
<p align="center">&bull;&nbsp;The top-selling football reference stat book used by the pros, designed for the true handicapper with room to log all your stats. &nbsp;It\'s Marc\'s bible and it should be yours, too!</p>
<p align="center">&bull; Cost $50.00 (shipping within the US included)</p>',
                'price' => NULL,
                'weekly_price' => '50',
                'img' => '1634232794-2021PlaybookFootballStatLogBook400PagesOfMustHaveCollegeNFLData.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:33:14',
                'updated_at' => '2021-10-14 17:33:14',
            ),
            14 =>
            array(
                'id' => 17,
                'name' => 'Marc Lawrence MLB Playoff Package Available Now',
                'description' => '<p>Marc started the MLB playoffs 4-0 this first week. Get every red-hot release he makes during the MLB playoffs thru the World Series with his $99 MLB Playoff Payoff Package. Join today and starting winning tonight!</p>',
                'price' => NULL,
                'weekly_price' => '99',
                'img' => '1634232870-MarcLawrenceMLBPlayoffPackageAvailableNow.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:34:30',
                'updated_at' => '2021-10-14 17:34:30',
            ),
            15 =>
            array(
                'id' => 18,
                'name' => 'Marc’s Fan Appreciation Football Weekend Of Winners! Starts Sat. 10/16',
                'description' => '<center><span class="verdana16" style="color: black;"><strong>Marc&rsquo;s Fan Appreciation Football Weekend Of Winners!</strong><br /></span><span class="verdana14">Starts Sat. 10/16</span>Marc has been on fire this football season, going 22-8 overall. Hop on board his&nbsp;<strong>FAN APPRECIATION WEEKEND OF WINNERS</strong>&nbsp;and get all of his Football and MLB Playoff releases (4-0 first week) this Saturday thru Monday for only $79, including his&nbsp;<strong>College Football False Favorite Game Of the Month</strong>. Click here or call 800.321.7777 now!</center>',
                'price' => NULL,
                'weekly_price' => '79',
                'img' => '1634232930-MarcsFanAppreciationFootballWeekendOfWinnersStartsSat1016.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:35:30',
                'updated_at' => '2021-10-14 17:35:30',
            ),
            16 =>
            array(
                'id' => 19,
                'name' => 'Marc Lawrence 2021 Playbook Perfect System Club + With Weekly Playbook Football Newsletter And Digital Magazine',
                'description' => '<p>&bull; Marc\'s weekly Perfect System Club football plays from Week One of the NFL season thru the end of the NFL&nbsp;regular&nbsp;season - all plays released every Friday at 1:00 PM ET</p>
<div>&bull; Also includes weekly copy of the Playbook Football Newsletter thru the Super Bowl and free digital copy of the 2021 Playbook&nbsp;Football Preview Guide magazine</div>
<p><br />Cost $229 complete - a savings of $147!</p>',
                'price' => NULL,
                'weekly_price' => '229',
                'img' => '1634233052-MarcLawrence2021PlaybookPerfectSystemClubWithWeeklyPlaybookFootballNewsletterAndDigitalMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:37:32',
                'updated_at' => '2021-10-14 17:37:32',
            ),
            17 =>
            array(
                'id' => 20,
                'name' => '2021 Marc Lawrence Early Week Economy Football Service + Includes Weekly Playbook Football Newsletter And Digital Magazine',
                'description' => '<p>&bull; Marc\'s weekly Economy Club football plays from Week One of the NFL season thru the end of the NFL&nbsp;regular&nbsp;season - All plays released every Thursday at 1:00 PM ET</p>
<div>&bull; Also includes weekly copy of the Playbook Football Newsletter thru the Super Bowl and free digital copy of the 2021 Playbook&nbsp;Football Preview Guide magazine</div>
<p><br />Cost $229 complete - a savings of $147!</p>',
                'price' => NULL,
                'weekly_price' => '229',
                'img' => '1634233105-2021MarcLawrenceEarlyWeekEconomyFootballServiceIncludesWeeklyPlaybookFootballNewsletterAndDigitalMagazine.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:38:25',
                'updated_at' => '2021-10-14 17:38:25',
            ),
            18 =>
            array(
                'id' => 21,
                'name' => 'Marc Lawrence\'s Famous 5* OCTOBERAMA Football Special Available Now',
                'description' => '<p>Marc is on fire to start the 2021 football season,&nbsp;<strong>documented No. 1</strong>&nbsp;by the Sports Monitor in Oklahoma at 20-4 thru the first four weeks of the College Football and NFL season. Get all of his CFB &amp; NFL selections thru October. Get every College Football and NFL release Marc makes for his award-winning Preferred Picks Executive Football Service thru the end of October fo just $229! Includes his&nbsp;<strong>5* October Game Of The Month</strong>&nbsp;(All 5* Game Of The Month Plays documented 78-34-2 since 1990, including Notre Dame over Wisconsin last month) in addition to all College Football and NFL plays - plus get all his of&nbsp;<strong>MLB Playoff selections as a no-charge bonus!</strong>&nbsp;Click here to join today.</p>',
                'price' => NULL,
                'weekly_price' => '229',
                'img' => '1634233226-MarcLawrencesFamous5OCTOBERAMAFootballSpecialAvailableNow.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-14 17:40:26',
                'updated_at' => '2021-10-14 17:40:26',
            ),
            19 =>
            array(
                'id' => 22,
                'name' => '2022 Playbook Basketball Newsletter',
                'description' => '<p>&bull; 2022 Playbook Basketball Newsletter available thru the NCAA Tourney via Member Center Thursdays after 7 PM ET<br />(to receive via your email in-box&nbsp;<a href="mailto:support@playbooksports.com?subject=Please%20Send%20The%20Weekly%20Basketball%20Newsletter%20To%20My%20Email-inbox">click here</a>)</p>
<p>&bull; Includes digital 2021 Playbook Football Preview Guide Magazine and 2021 Playbook NCAA Tourney and Sweet 16 Guides</p>
<p>&nbsp;</p>',
                'price' => NULL,
                'weekly_price' => '99',
                'img' => '1634233466-2022PlaybookBasketballNewsletter.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 3,
                'created_at' => '2021-10-14 17:44:26',
                'updated_at' => '2021-10-14 17:44:26',
            ),
            20 =>
            array(
                'id' => 23,
                'name' => 'Playbucks Tokens - 1 Token',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.<br /><br />Thank you and enjoy all the added benefits of your Playbucks Tokens. This purchase = 1 Green Token. Zero Gold Award Tokens</p>',
                'price' => NULL,
                'weekly_price' => '1',
                'img' => '1634233758-PlaybucksTokens1Token.png',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 6,
                'created_at' => '2021-10-14 17:49:18',
                'updated_at' => '2021-10-14 17:49:18',
            ),
            21 =>
            array(
                'id' => 24,
                'name' => 'Playbucks Tokens - 50 Tokens',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com</p>',
                'price' => NULL,
                'weekly_price' => '50',
                'img' => '1634233808-PlaybucksTokens50Tokens.png',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 6,
                'created_at' => '2021-10-14 17:50:08',
                'updated_at' => '2021-10-14 17:50:08',
            ),
            22 =>
            array(
                'id' => 25,
                'name' => 'Playbucks Tokens - 100 Tokens',
                'description' => '<p class="product_info_desc">Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.</p>',
                'price' => NULL,
                'weekly_price' => '100',
                'img' => '1634233853-PlaybucksTokens100Tokens.png',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 6,
                'created_at' => '2021-10-14 17:50:53',
                'updated_at' => '2021-10-14 17:50:53',
            ),
            23 =>
            array(
                'id' => 26,
                'name' => 'Playbook Playbucks Tokens - 500 Tokens',
                'description' => '<p>Welcome to the PlaybookSports.com Rewards program where you can now use convenient Playbucks Tokens for major purchases on the website. The more you use the more rewards you earn. For example: when you purchase 50 Tokens you receive 10 Award Tokens as a bonus. When you purchase 100 Green Tokens you receive 20 Gold Award Tokens as a bonus. If you have any questions or comments feel free to contact us at support@playbooksports.com.<br /><br />Thank you and enjoy all the added benefits of your Playbucks Tokens.</p>
<p>This purchase includes 500 Tokens | 100 Bonus Tokens</p>',
                'price' => NULL,
                'weekly_price' => '500',
                'img' => '1634233928-PlaybookPlaybucksTokens500Tokens.png',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 6,
                'created_at' => '2021-10-14 17:52:08',
                'updated_at' => '2021-10-14 17:52:08',
            ),
            24 =>
            array(
                'id' => 27,
                'name' => '2021 Playbook Newsletter Dynamic Duo',
                'description' => '<p>Marc is on fire to start the 2021 football season,&nbsp;<strong>documented No. 1</strong>&nbsp;by the Sports Monitor in Oklahoma at 20-4 thru the first four weeks of the College Football and NFL season. Get all of his CFB &amp; NFL selections thru October. Get every College Football and NFL release Marc makes for his award-winning Preferred Picks Executive Football Service thru the end of October fo just $229! Includes his&nbsp;<strong>5* October Game Of The Month</strong>&nbsp;(All 5* Game Of The Month Plays documented 78-34-2 since 1990, including Notre Dame over Wisconsin last month) in addition to all College Football and NFL plays - plus get all his of&nbsp;<strong>MLB Playoff selections as a no-charge bonus!</strong>&nbsp;Click here to join today.</p>',
                'price' => NULL,
                'weekly_price' => '10',
                'img' => '1634256699-centerfontcolor"black"class"verdana16"bbr2021PlaybookNewsletterDynamicDuobbrfontspanspanclass"verdana14"WithPlaybookDigitalYearbookMagazinespanbrbrcenter.jpg',
                'status' => 1,
                'expire_date' => NULL,
                'weekly_price_expire_date' => NULL,
                'display_date' => '2021-10-28',
                'delivery_method' => 'Email',
                'category_id' => 2,
                'created_at' => '2021-10-15 00:11:39',
                'updated_at' => '2021-10-15 00:45:59',
            ),
            25 =>
            array(
                'id' => 28,
                'name' => '2021 PB Football Preview Magazine Digital',
                'description' => '<center><span class="verdana16" style="color: black;"><strong>2021 Playbook Football Preview Guide Magazine</strong><br /></span><span class="verdana14">Digital Version</span><br /><br /></center>
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
                'price' => '12.00',
                'weekly_price' => '12.00',
                'img' => '1635278606-2021PBFootballPreviewMagazineDigital.jpg',
                'status' => 1,
                'expire_date' => '2022-02-15',
                'weekly_price_expire_date' => '2022-02-15',
                'display_date' => '2021-10-26',
                'delivery_method' => 'Online',
                'category_id' => 2,
                'created_at' => '2021-10-26 20:03:26',
                'updated_at' => '2021-10-26 20:03:26',
            ),
            26 =>
            array(
                'id' => 29,
                'name' => 'Playbook Logo',
                'description' => '<p>Lease</p>',
                'price' => '85.00',
                'weekly_price' => '10.00',
                'img' => '1635283293-PlaybookLogo.png',
                'status' => 1,
                'expire_date' => '2022-02-15',
                'weekly_price_expire_date' => '2021-11-01',
                'display_date' => '2021-10-26',
                'delivery_method' => 'Online',
                'category_id' => 2,
                'created_at' => '2021-10-26 21:21:33',
                'updated_at' => '2021-10-27 10:20:52',
            ),
            27 =>
            array(
                'id' => 30,
                'name' => 'SportsData College Football Playoff Interactive',
                'description' => '<p>Get Ready For the College Football Playoff Regular Season Run as the Top Ranked Teams Vie For the Final 4 Playoff Tickets</p>
<p>Download This Week\'s Edition of the CFP Interactive and Increase Your Chances To Add The Do-Re-Me $$$</p>
<p>It\'s Free ... Get Your Copy Today !!</p>',
                'price' => '0',
                'weekly_price' => '0',
                'img' => '1635337588-SportsDataCollegeFootballPlayoffInteractive.jpg',
                'status' => 0,
                'expire_date' => '2021-11-01',
                'weekly_price_expire_date' => '2021-11-01',
                'display_date' => '2021-10-27',
                'delivery_method' => 'Online',
                'category_id' => 2,
                'created_at' => '2021-10-27 12:26:28',
                'updated_at' => '2021-11-01 04:38:38',
            ),
            28 =>
            array(
                'id' => 31,
                'name' => 'token',
                'description' => '<p>token2</p>',
                'price' => '1',
                'weekly_price' => '1',
                'img' => '1635814424-token.png',
                'status' => 1,
                'expire_date' => '2022-01-31',
                'weekly_price_expire_date' => '2022-01-31',
                'display_date' => '2021-11-02',
                'delivery_method' => 'Online',
                'category_id' => 6,
                'created_at' => '2021-11-02 00:53:44',
                'updated_at' => '2021-11-02 00:53:44',
            ),
        ));
    }
}
