<?php

namespace App\Http\Controllers;

use App\Models\EcapperRating;
use App\Models\Pick;
use App\Models\SportStatus;
use App\Utilities\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SportController extends Controller
{
    public $utilities;

    public function __construct()
    {
        $this->utilities = new Utilities();
    }

    public function list()
    {
        $sports_list = SportStatus::where('status', true)->get();
        return view('admin.sport.list')->with(compact('sports_list'));
    }

    public function getSportsData(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SportStatus::all())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row['id'];
                    $actionBtn = '<a href="/admin/sport/edit/' . $id .'" data-id="' . $id . '" class="btn btn-xs btn-warning edit"><i class="far fa-edit"></i></a>
                                  <button type="submit" class="btn btn-xs btn-danger" data-categoryid="' . $id . '" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return back(); // if http request
        }
    }

    public function getSportSchedule(Request $request)
    {
        date_default_timezone_set("America/New_York");
        $data = '';
        if($request->ajax()):
            // if(true):
            // $query_get_rating_types = $this->mdl_admin->get_data('*', 'ecapper_rating', array('ecapper_id' => $this->session->userdata('SESS_LOGGED_USERID')));
            $query_get_rating_types = EcapperRating::all();
            $rating_type 			= '';
            if(count($query_get_rating_types) > 0):
                foreach($query_get_rating_types as $rating):
                    if($rating->lean != 'N/A'):
                        $rating_type .= '<option value="LEAN">LEAN</option>';
                    endif;
                    if($rating->reg != 'N/A'):
                        $rating_type .= '<option value="REG">REGULAR</option>';
                    endif;
                    if($rating->strong != 'N/A'):
                        $rating_type .= '<option value="STRONG">STRONG</option>';
                    endif;
                    if($rating->topplay != 'N/A'):
                        $rating_type .= '<option value="TOPPLAY">T-PLAY</option>';
                    endif;
                endforeach;
            endif;
            $game_ou_league			= array(1, 2, 3, 4, 5, 7, 8, 9, 13, 17, 18);
            $moneyline_league 		= array(1, 2, 3, 4, 8, 13, 17, 18);
            $firsthalf_league 		= array(1, 2, 3, 4, 8, 13, 17, 18);
            $first_inn_league 		= array(5);
            $first_per_league 		= array(7);
            $runline_league 		= array(5);
            $puckline_league 		= array(7);
            $goalline_league 		= array(9);
            $matchup_league 		= array(10, 14, 105);
            $towin_league 			= array(14, 22, 105);
            $golf_league 			= array(11);
            $rounds_league 			= array(10);
            $draw_league 			= array(9);
            $series_playoffs_league = array(1, 3, 5, 7);
            $context  				= stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
            $donbest_url 			= 'http://xml.donbest.com/v2/';
            $token 					= 'H!T-u8!J5hC-I!!i';
            $league_id 				= $request->league_id ?? 1;
            $sport_id 				= $request->sport_id ?? 1;
            $league_abbreviation 	= $request->league_abbreviation ?? 1;

            $fetch_sport_status 	= SportStatus::where('league_id', $league_id)->first();
            $get_series_playoffs 	= $fetch_sport_status->playoffs_series;

            $schedule_xml 			= $this->utilities->curl_get_request($donbest_url.'schedule/?token='.$token);
            $schedule_xml = json_encode($schedule_xml);
            $schedule_xml = json_decode($schedule_xml, true);
            $schedule_xml = simplexml_load_string($schedule_xml);
            if(!$schedule_xml):
                $data .= '<div class="col-md-12 text-center"><h3>Error fetching XML data from source API!</h3></div>';
            else:
                $schedule_xml_to_array 	= $this->utilities->xml_to_array($schedule_xml);
                $schedule_xml_to_array = (array)$schedule_xml;
                $array_sched_info = $this->utilities->arrange_sports_schedule($schedule_xml_to_array, $league_id, $sport_id);

                $line_odds_xml 			= $this->utilities->curl_get_request($donbest_url.'odds/'.$league_id.'/?token='.$token);
                $line_odds_xml = json_encode($line_odds_xml);
                $line_odds_xml = json_decode($line_odds_xml, true);
                $line_odds_xml 			= simplexml_load_string($line_odds_xml);
                if(!$line_odds_xml):
                    $data .= '<div class="col-md-12 text-center"><h3>#1 Error fetching XML data from source API!</h3></div>';
                else:
                    $line_odds_xml_to_array = $this->utilities->xml_to_array($line_odds_xml);

                    $line_odds_info = array();

                    if(isset($line_odds_xml_to_array) AND count($line_odds_xml_to_array) > 0):
                        if(count($line_odds_xml_to_array) > 0):
                            $line_odds_info = $line_odds_xml_to_array['event'];
                        endif;
                    endif;

                    $has_event_arr = array();

                    if(isset($array_sched_info['schedules']['sports'])):
                        if(count($array_sched_info['schedules']['sports']) > 0):
                            foreach($array_sched_info['schedules']['sports'] as $sport):
                                if(isset($sport['leagues'])):
                                    if(count($sport['leagues']) > 0):
                                        foreach($sport['leagues'] as $league):
                                            $league =  (array)$league;
                                            if(isset($league['groups'])):
                                                if(count($league['groups']) > 0):
                                                    $current_group_id = "";
                                                    foreach($league['groups'] as $group):
                                                        $group = (array)$group;
                                                        if(isset($group['events']) AND count($group['events']) > 0 AND count($line_odds_info) > 0):
                                                            foreach($group['events'] as $event):
                                                                $event = (array)$event;
                                                                if(count($event) > 0):
                                                                    if(count($event['event_participant']) > 0):
                                                                        if (
                                                                            isset($event['event_participant'][0]['rot']) AND
                                                                            isset($event['event_participant'][1]['rot'])
                                                                        )://Added
                                                                            if(
                                                                                $league['league_id'] != '14' AND
                                                                                $league['league_id'] != '11' AND
                                                                                strlen($event['event_participant'][0]['rot']) == 4 AND
                                                                                strlen($event['event_participant'][1]['rot']) == 4
                                                                            ):
                                                                                continue;
                                                                            endif;
                                                                        endif;
                                                                        if($league['league_id'] == '2' AND (strlen($event['event_participant'][0]['rot']) > 3 AND strlen($event['event_participant'][1]['rot']) > 3)):
                                                                            continue;
                                                                        endif;
                                                                    endif;
                                                                    if (isset($event['event_date'])):
                                                                        if(strtotime(date('Y-m-d h:i:s A', strtotime($event['event_date']))) >= strtotime(date('Y-m-d h:i:s A')) ):
                                                                            if(count($line_odds_info) == 1):
                                                                                $line_odds = array();
                                                                                $line_odds[0] = $line_odds_info;
                                                                            else:
                                                                                $line_odds = $line_odds_info;
                                                                            endif;
                                                                            if($current_group_id == "" OR $current_group_id != $group['group_id'] ):
                                                                                $data .= '<div class="p-2 bg-pick-date-label text-white text-center bg-dark">'.date('l, F dS, Y', strtotime($event['event_date'])).'</div>';
                                                                            endif;

                                                                            array_push($has_event_arr, 1);

                                                                            $half_header = '';
                                                                            $ou_header = '';
                                                                            $line_header = '';
                                                                            $current_group_id = $group['group_id'];
                                                                            $data .= '<div class="table-responsive" style="overflow-y: hidden !important;">';
                                                                            $data .= '<table id="'.$event['event_id'].'" class="table table-hover table-bordered pick-list" data-sportid="'.$sport['sport_id'].'" data-sportname="'.$sport['sport_name'].'" data-leagueid="'.$league['league_id'].'" data-leaguename="'.$league['league_name'].'">';
                                                                            // Table Heading
                                                                            $data .= '<thead>';
                                                                            $data .= '<th class="col-md-3 col-sm-3 col-xs-3" style="text-align: left !important;"><span>'.date('m/d g:i A', strtotime($event['event_date'])).'</span> - ';
                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-l-5 m-r-10"><input type="checkbox" id="start_multi_'.$event['event_id'].'" class="custom-control-input start-multi-input"><span class="custom-control-label start-multi-label">START MULTI</span></label>';
                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-r-10"><input type="checkbox" id="make_solo_'.$event['event_id'].'" class="custom-control-input make-solo-input" disabled><span class="custom-control-label make-solo-label">MAKE SOLO</span></label>';
                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-r-10" style="width: 10% !important;"><input type="checkbox" id="make_free_'.$event['event_id'].'" class="custom-control-input make-free-input"><span class="custom-control-label make-free-label">FREE</span></label>';
                                                                            $data .= '	<div class="multi-price display-none"> <span class="p-l-10"> MULTI PRICE</span> <input type="text" class="form-control picks-input-text text-dark font-bold multi-price-input" name="input_multi_price_'.$event["event_id"].'" id="input_multi_price_'.$event["event_id"].'" value="05" /></div>';
                                                                            $data .= '</th>';
                                                                            if(in_array((int)$league_id, $game_ou_league)):
                                                                                $data .= '<th>Game</th>';
                                                                                $data .= '<th>Over/Under</th>';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $firsthalf_league)):
                                                                                $data .= '<th>1st Half</th>';
                                                                                $data .= '<th>1st Half O/U</th>';
                                                                                $half_header = '1st Half';
                                                                                $ou_header = '1st Half O/U';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $first_inn_league)):
                                                                                $data .= '<th>1st 5 Inn</th>';
                                                                                $data .= '<th>1st 5 Inn O/U</th>';
                                                                                $half_header = '1st 5 Inn';
                                                                                $ou_header = '1st 5 Inn O/U';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $first_per_league)):
                                                                                $data .= '<th>1st 5 Per</th>';
                                                                                $data .= '<th>1st 5 Per O/U</th>';
                                                                                $half_header = '1st 5 Per';
                                                                                $ou_header = '1st 5 Per O/U';
                                                                            endif;

                                                                            if(in_array((int)$league_id, $draw_league)):
                                                                                $data .= '<th>Draw</th>';
                                                                                $draw_header = 'Draw';
                                                                            endif;

                                                                            if(in_array((int)$league_id, $moneyline_league)):
                                                                                $data .= '<th>Money Line</th>';
                                                                                $line_header = 'Money Line';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $runline_league)):
                                                                                $data .= '<th>Run Line</th>';
                                                                                $line_header = 'Run Line';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $puckline_league)):
                                                                                $data .= '<th>Puck Line</th>';
                                                                                $line_header = 'Puck Line';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $goalline_league)):
                                                                                $data .= '<th>Goal Line</th>';
                                                                                $line_header = 'Goal Line';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $towin_league)):
                                                                                $data .= '<th>To Win</th>';
                                                                                $towin_header = 'To Win';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $matchup_league)):
                                                                                $data .= '<th>Matchup</th>';
                                                                                $matchup_header = 'Matchup';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $golf_league)):
                                                                                $data .= '<th>Match</th>';
                                                                                $data .= '<th>Strokes</th>';
                                                                                $data .= '<th>Draw</th>';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $rounds_league)):
                                                                                $data .= '<th>Rounds</th>';
                                                                                $round_header = 'Rounds';
                                                                            endif;
                                                                            if(in_array((int)$league_id, $series_playoffs_league) AND $get_series_playoffs == 1):
                                                                                $data .= '<th>Playoffs/Series</th>';
                                                                            endif;
                                                                            $data .= '</thead>';

                                                                            // Table Body
                                                                            $data .= '<tbody>';
                                                                            $time_FG 				= "";
                                                                            $time_1H 				= "";
                                                                            $away_spread_FG 		= "";
                                                                            $home_spread_FG 		= "";
                                                                            $away_price_FG 			= "";
                                                                            $home_price_FG 			= "";
                                                                            $away_money_FG 			= "";
                                                                            $home_money_FG 			= "";
                                                                            $draw_money_FG 			= "";
                                                                            $total_FG 				= "";
                                                                            $over_price_FG 			= "";
                                                                            $under_price_FG 		= "";
                                                                            $away_total_FG 			= "";
                                                                            $away_over_price_FG 	= "";
                                                                            $away_under_price_FG 	= "";
                                                                            $home_total_FG 			= "";
                                                                            $home_over_price_FG 	= "";
                                                                            $home_under_price_FG 	= "";
                                                                            $home_FG 				= "";
                                                                            $away_FG 				= "";

                                                                            $away_spread_1H 		= "";
                                                                            $home_spread_1H 		= "";
                                                                            $away_price_1H 			= "";
                                                                            $home_price_1H 			= "";
                                                                            $away_money_1H 			= "";
                                                                            $home_money_1H 			= "";
                                                                            $draw_money_1H 			= "";
                                                                            $total_1H 				= "";
                                                                            $over_price_1H 			= "";
                                                                            $under_price_1H 		= "";
                                                                            $away_total_1H 			= "";
                                                                            $away_over_price_1H 	= "";
                                                                            $away_under_price_1H 	= "";
                                                                            $home_total_1H 			= "";
                                                                            $home_over_price_1H 	= "";
                                                                            $home_under_price_1H 	= "";
                                                                            $home_1H 				= "";
                                                                            $away_1H 				= "";
                                                                            foreach($line_odds as $line_event):
                                                                                $line_event = (array)$line_event;
                                                                                if(isset($line_event['@attributes']) AND $line_event['@attributes']['id'] == $event['event_id']):
                                                                                    if(isset($line_event['line']) AND count($line_event['line']) > 0):
                                                                                        foreach($line_event['line'] as $line):
                                                                                            $line = (array)$line;
                                                                                            if(isset($line['@attributes']) AND isset($line['@attributes']['type']) AND strtoupper($line['@attributes']['type']) == "CURRENT" AND isset($line['@attributes']['no_line']) AND strtoupper($line['@attributes']['no_line']) == "FALSE"):
                                                                                                if(in_array((int)$league_id, $game_ou_league) OR in_array((int)$league_id, $towin_league) OR in_array((int)$league_id, $matchup_league) OR in_array((int)$league_id, $golf_league) OR in_array((int)$league_id, $rounds_league) OR in_array((int)$league_id, $draw_league)):
                                                                                                    if($line['@attributes']['period_id'] == "1"):
                                                                                                        if($time_FG == ""):
                                                                                                            $time_FG = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if(isset($line['ps'])):
                                                                                                                $away_spread_FG = $line['ps']['@attributes']['away_spread'];
                                                                                                                $home_spread_FG = $line['ps']['@attributes']['home_spread'];
                                                                                                                $away_price_FG = $line['ps']['@attributes']['away_price'];
                                                                                                                $home_price_FG = $line['ps']['@attributes']['home_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['money'])):
                                                                                                                $away_money_FG 	= $line['money']['@attributes']['away_money'];
                                                                                                                $home_money_FG 	= $line['money']['@attributes']['home_money'];
                                                                                                                $draw_money_FG 	= $line['money']['@attributes']['draw_money'];
                                                                                                            endif;

                                                                                                            if(isset($line['total'])):
                                                                                                                $over_price_FG 	= $line['total']['@attributes']['over_price'];
                                                                                                                $under_price_FG = $line['total']['@attributes']['under_price'];
                                                                                                                $total_FG 		= $line['total']['@attributes']['total'];
                                                                                                            endif;

                                                                                                            if(isset($line['team_total'])):
                                                                                                                $away_total_FG 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                $away_over_price_FG 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                $away_under_price_FG 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                $home_total_FG 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                $home_over_price_FG 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                $home_under_price_FG 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['display'])):
                                                                                                                $away_FG 	= (float)$line['display']['@attributes']['away'];
                                                                                                                $home_FG 	= (float)$line['display']['@attributes']['home'];
                                                                                                            endif;

                                                                                                        else:
                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if($time_FG < $new):
                                                                                                                $time_FG = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                if(isset($line['ps'])):
                                                                                                                    $away_spread_FG = $line['ps']['@attributes']['away_spread'];
                                                                                                                    $home_spread_FG = $line['ps']['@attributes']['home_spread'];
                                                                                                                    $away_price_FG = $line['ps']['@attributes']['away_price'];
                                                                                                                    $home_price_FG = $line['ps']['@attributes']['home_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['money'])):
                                                                                                                    $away_money_FG 	= $line['money']['@attributes']['away_money'];
                                                                                                                    $home_money_FG 	= $line['money']['@attributes']['home_money'];
                                                                                                                    $draw_money_FG 	= $line['money']['@attributes']['draw_money'];
                                                                                                                endif;

                                                                                                                if(isset($line['total'])):
                                                                                                                    $over_price_FG 	= $line['total']['@attributes']['over_price'];
                                                                                                                    $under_price_FG = $line['total']['@attributes']['under_price'];
                                                                                                                    $total_FG 		= $line['total']['@attributes']['total'];
                                                                                                                endif;

                                                                                                                if(isset($line['team_total'])):
                                                                                                                    $away_total_FG 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                    $away_over_price_FG 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                    $away_under_price_FG 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                    $home_total_FG 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                    $home_over_price_FG 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                    $home_under_price_FG 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['display'])):
                                                                                                                    $away_FG 	= $line['display']['@attributes']['away'];
                                                                                                                    $home_FG 	= $line['display']['@attributes']['home'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                endif;

                                                                                                if(in_array((int)$league_id, $firsthalf_league) OR in_array((int)$league_id, $first_inn_league)):
                                                                                                    if($line['@attributes']['period_id'] == "2"):
                                                                                                        if($time_1H == ""):
                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if(isset($line['ps'])):
                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['money'])):
                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                            endif;

                                                                                                            if(isset($line['total'])):
                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                            endif;

                                                                                                            if(isset($line['team_total'])):
                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['display'])):
                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                            endif;

                                                                                                        else:
                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if($time_1H < $new):
                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                if(isset($line['ps'])):
                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['money'])):
                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                endif;

                                                                                                                if(isset($line['total'])):
                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                endif;

                                                                                                                if(isset($line['team_total'])):
                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['display'])):
                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                elseif(in_array((int)$league_id, $first_inn_league)):
                                                                                                    if($line['@attributes']['period_id'] == "25"):
                                                                                                        if($time_1H == ""):
                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if(isset($line['ps'])):
                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['money'])):
                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                            endif;

                                                                                                            if(isset($line['total'])):
                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                            endif;

                                                                                                            if(isset($line['team_total'])):
                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['display'])):
                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                            endif;

                                                                                                        else:
                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if($time_1H < $new):
                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                if(isset($line['ps'])):
                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['money'])):
                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                endif;

                                                                                                                if(isset($line['total'])):
                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                endif;

                                                                                                                if(isset($line['team_total'])):
                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['display'])):
                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                elseif(in_array((int)$league_id, $first_per_league)):
                                                                                                    if($line['@attributes']['period_id'] == "30"):
                                                                                                        if($time_1H == ""):
                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if(isset($line['ps'])):
                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['money'])):
                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                            endif;

                                                                                                            if(isset($line['total'])):
                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                            endif;

                                                                                                            if(isset($line['team_total'])):
                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                            endif;

                                                                                                            if(isset($line['display'])):
                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                            endif;

                                                                                                        else:
                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                            if($time_1H < $new):
                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                if(isset($line['ps'])):
                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['money'])):
                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                endif;

                                                                                                                if(isset($line['total'])):
                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                endif;

                                                                                                                if(isset($line['team_total'])):
                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                endif;

                                                                                                                if(isset($line['display'])):
                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                endif;
                                                                                            endif;
                                                                                        endforeach;
                                                                                    endif;
                                                                                endif;
                                                                            endforeach;


                                                                            // dd($event['event_participant']);

                                                                            if(count($event['event_participant']) > 0):
                                                                                foreach($event['event_participant'] as $participant):
                                                                                    if(isset($participant['rot'])): #added
                                                                                        if(($league['league_id'] != '14' AND $league['league_id'] != '11') AND strlen($participant['rot']) == 4):
                                                                                            continue;
                                                                                        endif;
                                                                                    endif;
                                                                                    if(isset($participant['rot'])): #added
                                                                                        if($league['league_id'] == '2' AND strlen($participant['rot']) > 3 ):
                                                                                            continue;
                                                                                        endif;
                                                                                    endif;

                                                                                    $game 					= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_spread_FG : $home_spread_FG;
                                                                                    if(strpos($game, '-') !== FALSE AND $game != ""):
                                                                                        $game = (abs($game) == 0) ? 'pk' : '-'.abs($game);
                                                                                    elseif(strpos($game, '-') === FALSE AND $game != ""):
                                                                                        $game = (abs($game) == 0) ? 'pk' : '+'.abs($game);
                                                                                    else:
                                                                                        $game = "";
                                                                                    endif;

                                                                                    $game_price 			= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_price_FG : $home_price_FG;

                                                                                    if($game != ""):
                                                                                        if(strpos($game_price, '-') !== FALSE AND $game_price != ""):
                                                                                            $game_price = '-'.abs($game_price);
                                                                                        elseif(strpos($game_price, '-') === FALSE AND $game_price != ""):
                                                                                            $game_price = '+'.abs($game_price);
                                                                                        else:
                                                                                            $game_price = "";
                                                                                        endif;
                                                                                    else:
                                                                                        $game_price = "";
                                                                                    endif;


                                                                                    $ov_un 					= (float)$total_FG;
                                                                                    if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                        if($ov_un == 0):
                                                                                            $ov_un = "";
                                                                                        else:
                                                                                            $ov_un = 'o'.abs($ov_un);
                                                                                        endif;
                                                                                    else:
                                                                                        if($ov_un == 0):
                                                                                            $ov_un = "";
                                                                                        else:
                                                                                            $ov_un = 'u'.abs($ov_un);
                                                                                        endif;
                                                                                    endif;

                                                                                    $ov_un_price 			= (strtoupper($participant['side'] ?? '') == "AWAY") ? $under_price_FG : $over_price_FG;
                                                                                    if($ov_un != ""):
                                                                                        if(strpos($ov_un_price, '-') !== FALSE AND $ov_un_price != ""):
                                                                                            $ov_un_price = '-'.abs($ov_un_price);
                                                                                        elseif(strpos($ov_un_price, '-') === FALSE AND $ov_un_price != ""):
                                                                                            $ov_un_price = '+'.abs($ov_un_price);
                                                                                        else:
                                                                                            $ov_un_price = "";
                                                                                        endif;
                                                                                    else:
                                                                                        $ov_un_price = "";
                                                                                    endif;

                                                                                    $first_half_game 		= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_spread_1H : $home_spread_1H;
                                                                                    if(strpos($first_half_game, '-') !== FALSE AND $first_half_game != ""):
                                                                                        $first_half_game = '-'.abs($first_half_game);
                                                                                    elseif(strpos($first_half_game, '-') === FALSE AND $first_half_game != ""):
                                                                                        $first_half_game = '+'.abs($first_half_game);
                                                                                    else:
                                                                                        $first_half_game = "";
                                                                                    endif;

                                                                                    $first_half_game_price 	= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_price_1H : $home_price_1H;
                                                                                    if($first_half_game != ""):
                                                                                        if(strpos($first_half_game_price, '-') !== FALSE AND $first_half_game_price != ""):
                                                                                            $first_half_game_price = '-'.abs($first_half_game_price);
                                                                                        elseif(strpos($first_half_game, '-') === FALSE AND $first_half_game_price != ""):
                                                                                            $first_half_game_price = '+'.abs($first_half_game_price);
                                                                                        else:
                                                                                            $first_half_game_price = "";
                                                                                        endif;
                                                                                    else:
                                                                                        $first_half_game_price = "";
                                                                                    endif;

                                                                                    $first_half_ov_un 		= (float)$total_1H;
                                                                                    if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                        if($first_half_ov_un == 0):
                                                                                            $first_half_ov_un = "";
                                                                                        else:
                                                                                            $first_half_ov_un = 'o'.abs($first_half_ov_un);
                                                                                        endif;
                                                                                    else:
                                                                                        if($first_half_ov_un == 0):
                                                                                            $first_half_ov_un = "";
                                                                                        else:
                                                                                            $first_half_ov_un = 'u'.abs($first_half_ov_un);
                                                                                        endif;
                                                                                    endif;

                                                                                    $first_half_ov_un_price = (strtoupper($participant['side'] ?? '') == "AWAY") ? $under_price_1H : $over_price_1H;
                                                                                    if($first_half_ov_un != ""):
                                                                                        if(strpos($first_half_ov_un_price, '-') !== FALSE AND $first_half_ov_un_price != ""):
                                                                                            $first_half_ov_un_price = '-'.abs($first_half_ov_un_price);
                                                                                        elseif(strpos($first_half_ov_un_price, '-') === FALSE AND $first_half_ov_un_price != ""):
                                                                                            $first_half_ov_un_price = '+'.abs($first_half_ov_un_price);
                                                                                        else:
                                                                                            $first_half_ov_un_price = "";
                                                                                        endif;
                                                                                    else:
                                                                                        $first_half_ov_un_price = "";
                                                                                    endif;

                                                                                    $money_line = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_money_FG : $home_money_FG;
                                                                                    if(strpos($money_line, '-') !== FALSE AND $money_line != ""):
                                                                                        $money_line = '-'.abs($money_line);
                                                                                    elseif(strpos($money_line, '-') === FALSE AND $money_line != ""):
                                                                                        $money_line = '+'.abs($money_line);
                                                                                    else:
                                                                                        $money_line = "";
                                                                                    endif;

                                                                                    $money_line_1H = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_money_1H : $home_money_1H;
                                                                                    if(strpos($money_line_1H, '-') !== FALSE AND $money_line_1H != ""):
                                                                                        $money_line_1H = '-'.abs($money_line_1H);
                                                                                    elseif(strpos($money_line_1H, '-') === FALSE AND $money_line_1H != ""):
                                                                                        $money_line_1H = '+'.abs($money_line_1H);
                                                                                    else:
                                                                                        $money_line_1H = "";
                                                                                    endif;

                                                                                    $display = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_FG : $home_FG;
                                                                                    $display = (float)$display;

                                                                                    if(strpos($display, '%2B') !== FALSE):
                                                                                        $display = substr($display, 3);
                                                                                    endif;

                                                                                    if(strpos($display, '-') !== FALSE AND $display != "" AND abs($display) > 0):
                                                                                        $display = '-'.abs($display);
                                                                                    elseif(strpos($display, '-') === FALSE AND $display != "" AND abs($display) > 0):
                                                                                        $display = '+'.abs($display);
                                                                                    else:
                                                                                        $display = "";
                                                                                    endif;

                                                                                    $display_reverse = (strtoupper($participant['side'] ?? '') == "AWAY") ? $home_FG : $away_FG;

                                                                                    if(strpos($display_reverse, '%2B') !== FALSE):
                                                                                        $display_reverse = substr($display_reverse, 3);
                                                                                    endif;

                                                                                    $display_reverse = (float)$display_reverse;
                                                                                    $away_FG = (float)$away_FG;
                                                                                    $home_FG = (float)$home_FG;
                                                                                    if(strpos($display_reverse, '-') !== FALSE AND $display_reverse != "" AND abs($display_reverse) > 0):
                                                                                        $display_reverse = '-'.abs($display_reverse);
                                                                                        if(abs($away_FG) > abs($home_FG)):
                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                $display_reverse.= ' No';
                                                                                            else:
                                                                                                $display_reverse.= ' Yes';
                                                                                            endif;
                                                                                        elseif(abs($away_FG) < abs($home_FG)):
                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                $display_reverse.= ' Yes';
                                                                                            else:
                                                                                                $display_reverse.= ' No';
                                                                                            endif;
                                                                                        else:
                                                                                            $display_reverse.= ' Even';
                                                                                        endif;
                                                                                    elseif(strpos($display_reverse, '-') === FALSE AND $display_reverse != "" AND abs($display_reverse) > 0):
                                                                                        $display_reverse = '+'.abs($display_reverse);
                                                                                        if(abs($away_FG) > abs($home_FG)):
                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                $display_reverse.= ' No';
                                                                                            else:
                                                                                                $display_reverse.= ' Yes';
                                                                                            endif;
                                                                                        elseif(abs($away_FG) < abs($home_FG)):
                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                $display_reverse.= ' Yes';
                                                                                            else:
                                                                                                $display_reverse.= ' No';
                                                                                            endif;
                                                                                        else:
                                                                                            $display_reverse.= ' Even';
                                                                                        endif;
                                                                                    else:
                                                                                        $display_reverse = "";
                                                                                    endif;

                                                                                    $data .= '<tr class="game-info">';
                                                                                    $data .= '<td class="game-team"><span class="p-2">'.((strlen($participant['rot'] ?? 0) > 3) ? substr($participant['rot'], -3) : $participant['rot'] ?? 0).' - '.$participant['team_name'].'</span></td>';
                                                                                    if(in_array((int)$league_id, $game_ou_league)):
                                                                                        if((int)$league_id == 9 OR (int)$league_id == 7 OR (int)$league_id == 5):
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="A'.$event['event_id'].'" data-head="Game" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Game" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Game" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                        else:
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="A'.$event['event_id'].'" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.'</span><span class="display-block fs-11 selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game_price.'</span></div>' : "").'</td>';
                                                                                        endif;
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="B'.$event['event_id'].'" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.(($ov_un != "") ? '<div class="display-block odds-hover selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.$ov_un.'</span><span class="display-block fs-11 selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.$ov_un_price.'</span></div>' : "").'</td>';
                                                                                    endif;
                                                                                    if(in_array((int)$league_id, $firsthalf_league) OR in_array((int)$league_id, $first_inn_league) OR in_array((int)$league_id, $first_per_league)):
                                                                                        if((int)$league_id == 5 OR (int)$league_id == 7):
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="C'.$event['event_id'].'" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'">'.(($money_line_1H != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'">'.$money_line_1H.'</span></div>' : "" ).'</td>';
                                                                                        else:
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="C'.$event['event_id'].'" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.(($first_half_game != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.$first_half_game.'</span><span class="display-block fs-11 selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.$first_half_game_price.'</span></div>' : "").'</td>';
                                                                                        endif;
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="D'.$event['event_id'].'" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.(($first_half_ov_un != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.$first_half_ov_un.'</span><span class="display-block fs-11 selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.$first_half_ov_un_price.'</span></div>': "").'</td>';
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $draw_league)):
                                                                                        if((int)$league_id == 9):
                                                                                            if(((strtoupper($participant['side'])) == "AWAY")):
                                                                                                $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes">'.(($draw_money_FG != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes">'.$draw_money_FG.' Yes</span></div>' : "" ).'</td>';
                                                                                            else:
                                                                                                $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes"></td>';
                                                                                            endif;
                                                                                        else:
                                                                                            $draw_value = ((strtoupper($participant['side'])) == "AWAY") ? 'Yes' : 'No';
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'">'.(($draw_money_FG != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'">'.$draw_money_FG.' '.$draw_value.'</span></div>' : "" ).'</td>';
                                                                                        endif;
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $moneyline_league) OR in_array((int)$league_id, $runline_league) OR in_array((int)$league_id, $puckline_league) OR in_array((int)$league_id, $goalline_league)):
                                                                                        if((int)$league_id == 9 OR (int)$league_id == 7 OR (int)$league_id == 5):
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="E'.$event['event_id'].'" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.'</span><span class="display-block fs-11 selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game_price.'</span></div>' : "").'</td>';
                                                                                        else:
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="E'.$event['event_id'].'" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                        endif;
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $golf_league)):
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="F'.$event['event_id'].'" data-head="Match" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Match" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Match" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="G'.$event['event_id'].'" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.' ('.$game_price.')</span></div>' : "").'</td>';
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="H'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$display_reverse.'">'.(($display_reverse != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$display_reverse.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$display_reverse.'">'.$display_reverse.'</span></div>' : "" ).'</td>';
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $towin_league)):
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="I'.$event['event_id'].'" data-head="ToWin" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="ToWin" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="ToWin" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $matchup_league)):
                                                                                        if($league_id == '14'):
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="J'.$event['event_id'].'" data-head="Matchup" data-juice="" data-value="'.$game_price.'">'.(($game_price != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Matchup" data-juice="" data-value="'.$game_price.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Matchup" data-juice="" data-value="'.$game_price.'">'.$game_price.'</span></div>' : "" ).'</td>';
                                                                                        else:
                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="J'.$event['event_id'].'" data-head="Matchup" data-juice="" data-value="'.$display.'">'.(($display != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Matchup" data-juice="" data-value="'.$display.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Matchup" data-juice="" data-value="'.$display.'">'.$display.'</span></div>' : "" ).'</td>';
                                                                                        endif;
                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $rounds_league)):
                                                                                        if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                            $total_rounds = "o".$total_FG;
                                                                                        else:
                                                                                            $total_rounds = "u".$total_FG;
                                                                                        endif;
                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'">'.(($ov_un_price != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'">'.$total_rounds.' '.$ov_un_price.'</span></div>' : "" ).'</td>';

                                                                                    endif;

                                                                                    if(in_array((int)$league_id, $series_playoffs_league) AND $get_series_playoffs == 1):
                                                                                        $data .= '<td></td>';
                                                                                    endif;

                                                                                    $data .= '</tr>';

                                                                                    $data .= '<tr class="display-none pick-details">';
                                                                                    $data .= '<td colspan="7">';
                                                                                    $data .= '<div class="row m-0">';
                                                                                    $data .= '<div class="col-md-12 m-b-10">';
                                                                                    $data .= '<button type="button" id="btn_reset_selected_pick_'.$event['event_id'].'" class="btn btn-sm btn-danger pull-right btn_reset_selected_pick"><i class="fas fa-times"></i></button>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-12" style="border-top: 1px solid #aaa;">';
                                                                                    $data .= '<div class="row">';

                                                                                    $data .= '<div class="col-md-2 p-l-5 p-r-5">';
                                                                                    $data .= '<input type="hidden" value="'.((strlen($participant['rot'] ?? 0) > 3) ? substr($participant['rot'] ?? 0, -3) : $participant['rot'] ?? 0).'" class="rot-input" />';
                                                                                    $data .= '<input type="hidden" value="'.date('Y-m-d g:i:s', strtotime($event['event_date'])).'" class="event-datetime-input" />';
                                                                                    $data .= '<input type="hidden" value="'.$participant['team_name'].'" class="team-name-input" />';
                                                                                    if (!isset($participant['side'])) :
                                                                                        $participant['side'] = '';
                                                                                    endif;
                                                                                    $data .= '<input type="hidden" value="'.$participant['side'].'" class="side-input" />';
                                                                                    $data .= '<span class="font-bold display-block p-2">'.date('g:i A T', strtotime($event['event_date'])).'</span>';
                                                                                    $data .= '<span class="display-block p-2">'.((strlen($participant['rot'] ?? 0) > 3) ? substr($participant['rot'] ?? 0, -3) : $participant['rot'] ?? 0).' - '.$participant['team_name'].'</span>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-1 text-center p-l-5 p-r-5">';
                                                                                    $data .= '<input type="hidden" class="selected-header-input"/>';
                                                                                    $data .= '<input type="hidden" class="selected-juice-input"/>';
                                                                                    $data .= '<span class="font-bold display-block p-2 selected-header"></span>';
                                                                                    $data .= '<input type="hidden" class="selected-value-input"/>';
                                                                                    $data .= '<span class="display-block selected-value"></span>';
                                                                                    $data .= '<input type="hidden" class="selected-integrity-id"/>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-1 text-center single-price p-l-5 p-r-5">';
                                                                                    $data .= '<span class="font-bold display-block p-2">Price</span>';
                                                                                    $data .= '<input type="text" id="single_price_input_'.$event['event_id'].'" class="form-control picks-input-text text-dark font-bold display-block single-price-input" value="05" style="width:100% !important;" name="price"/>';
                                                                                    $data .= '</div>';

                                                                                    if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                        $data .= '<div class="col-md-1 text-center pitcher-details p-l-5 p-r-5">';
                                                                                        $data .= '<span class="font-bold display-block p-2">Pitcher</span>';
                                                                                        $data .= '<select class="picks-select pitcher-select form-control" id="pitcher_select_'.$event['event_id'].'">';
                                                                                        $data .= '<option value="" selected disabled>Select</option>';
                                                                                        $data .= '<option value="ACTION">Action</option>';
                                                                                        $data .= '<option value="BOX">Box</option>';
                                                                                        $data .= '<option value="'.$participant['pitcher_full_name'].'" data-pitcherid="'.$participant['pitcher_id'].'" data-pitcherhand="'.$participant['pitcher_hand'].'">'.$participant['pitcher_name'].'</option>';
                                                                                        $data .= '</select>';
                                                                                        $data .= '</div>';
                                                                                    endif;

                                                                                    $data .= '<div class="col-md-1 text-center rating-type p-l-5 p-r-5">';
                                                                                    $data .= '<span class="font-bold display-block p-2">Rating Type</span>';
                                                                                    $data .= '<select class="form-control picks-select rating-type-select form-control" id="rating_type_select_'.$event['event_id'].'">';
                                                                                    $data .= '<option value="" selected disabled>Select Type</option>';

                                                                                    $data .= $rating_type;
                                                                                    $data .= '</select>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-1 text-center rating-number p-l-5 p-r-5">';
                                                                                    $data .= '<span class="font-bold display-block p-2">Rating #</span>';
                                                                                    $data .= '<select class="picks-select rating-number-select form-control" id="rating_number_select_'.$event['event_id'].'" disabled>';
                                                                                    $data .= '</select>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-1 text-center tplay p-l-5 p-r-5 display-none">';
                                                                                    $data .= '<span class="font-bold display-block p-2">T-Play</span>';
                                                                                    $data .= '<select class="picks-select tplay-designation-select form-control" id="tplay_select_'.$event['event_id'].'" disabled>';
                                                                                    $data .= '<option value="" selected disabled>Select</option>';
                                                                                    $data .= '<option value="GOW">GOW</option>';
                                                                                    $data .= '<option value="GOM">GOM</option>';
                                                                                    $data .= '<option value="GOY">GOY</option>';
                                                                                    $data .= '</select>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-2 text-center p-l-5 p-r-5 tplay-title display-none">';
                                                                                    $data .= '<span class="font-bold display-block p-2">T-Play Title</span>';
                                                                                    $data .= '<select class="picks-select tplay-title-select form-control" id="tplay_title_select_'.$event['event_id'].'" disabled>';
                                                                                    $data .= '<option value="" selected disabled>Select</option>';
                                                                                    $data .= '<option value="Sport">Sport</option>';
                                                                                    $data .= '<option value="Division">Division</option>';
                                                                                    $data .= '<option value="Non-Division">Non-Division</option>';
                                                                                    $data .= '<option value="Conference">Conference</option>';
                                                                                    $data .= '<option value="Non-Conference">Non-Conference</option>';
                                                                                    $data .= '<option value="Revenge">Revenge</option>';
                                                                                    $data .= '<option value="Underdog">Underdog</option>';
                                                                                    $data .= '<option value="False Favorite">False Favorite</option>';
                                                                                    $data .= '</select>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '<div class="col-md-2 text-center p-t-10 p-l-5 p-r-5">';
                                                                                    $data .= '<button type="button" id="btn_save_'.$event['event_id'].'" class="btn btn-sm btn-info btn-block m-b-10 display-none btn_save mt-3" style="height: fit-content;"><i class="fas fa-save"></i> Save</button>';
                                                                                    $data .= '<button type="button" id="btn_continue_'.$event['event_id'].'" class="btn btn-sm btn-primary btn-block display-none btn_continue" style="height: fit-content;"><i class="fas fa-play"></i> Continue</button>';
                                                                                    $data .= '</div>';

                                                                                    $data .= '</div>';
                                                                                    $data .= '</div>';
                                                                                    $data .= '</div>';
                                                                                    $data .= '</td>';
                                                                                    $data .= '</tr>';

                                                                                    ob_flush();
                                                                                    flush();
                                                                                    usleep(5);
                                                                                endforeach;
                                                                            endif;
                                                                            $data .= '</tbody>';
                                                                            $data .= '</table>';
                                                                            $data .= '</div>';
                                                                        endif;
                                                                    endif;
                                                                else:
                                                                    break;
                                                                    $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    break;
                                                    $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                                endif;
                                            else:
                                                continue;
                                            endif;
                                        endforeach;
                                    else:
                                        break;
                                        $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                    endif;
                                else:
                                    continue;
                                endif;
                            endforeach;
                        else:
                            $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                        endif;
                    endif;

                    if(count($has_event_arr) == 0):
                        $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                    endif;
                endif;

            endif;

            echo $data;
        else:
            abort(404);
        endif;
    }

    public function getSportsSchedleMulti(Request $request)
    {
        date_default_timezone_set("America/New_York");
        if($request->ajax()):
            $rotations = $request->rotations;
            $rotations = explode(',', $rotations);

            $query_get_rating_types = EcapperRating::all();

            $rating_type 			= '';
            if(count($query_get_rating_types) > 0):
                foreach($query_get_rating_types as $rating):
                    if($rating->lean != 'N/A'):
                        $rating_type .= '<option value="LEAN">LEAN</option>';
                    endif;
                    if($rating->reg != 'N/A'):
                        $rating_type .= '<option value="REG">REGULAR</option>';
                    endif;
                    if($rating->strong != 'N/A'):
                        $rating_type .= '<option value="STRONG">STRONG</option>';
                    endif;
                    if($rating->topplay != 'N/A'):
                        $rating_type .= '<option value="TOPPLAY">T-PLAY</option>';
                    endif;
                endforeach;
            endif;

            $game_ou_league			= array(1, 2, 3, 4, 5, 7, 8, 9, 13, 17, 18);
            $moneyline_league 		= array(1, 2, 3, 4, 8, 13, 17, 18);
            $firsthalf_league 		= array(1, 2, 3, 4, 8, 13, 17, 18);
            $first_inn_league 		= array(5);
            $first_per_league 		= array(7);
            $runline_league 		= array(5);
            $puckline_league 		= array(7);
            $goalline_league 		= array(9);
            $matchup_league 		= array(10, 14, 105);
            $towin_league 			= array(10, 14, 22, 105);
            $golf_league 			= array(11);
            $rounds_league 			= array(10);
            $draw_league 			= array(9);
            $series_playoffs_league = array(1, 3, 5, 7);
            $donbest_url 			= 'http://xml.donbest.com/v2/';
            $token 					= 'H!T-u8!J5hC-I!!i';

            $schedule_xml = ((new \GuzzleHttp\Client())->request('get', $donbest_url.'schedule/?token='.$token))->getBody();
            $schedule_xml = simplexml_load_string($schedule_xml);

            if(!$schedule_xml):
                return response()->json('<div class="col-md-12 text-center"><h3>Error fetching XML data from source API!</h3></div>');
            else:
                $schedule_xml_to_array = (array)$schedule_xml;
                $multi_sports_list = array();
                $sports = (array)$schedule_xml_to_array['schedule']->sport;

                if(count($sports) > 0):

                    $sports = (array)$sports;


                    if(is_array($sports['league'])):
                        foreach($sports as $sport_key => $sport):
                            $sport = (array)$sport;

                            if(count($sports['league']) > 0):
                                if(is_array($sports['league'])):
                                    foreach($sports['league'] as $league_key => $league):
                                        $league = (array)$league;
                                        if(count($league['group']) > 0):
                                            if(is_array($league['group'])):
                                                foreach($league['group'] as $group):
                                                    $group = (array)$group;
                                                    if(count($group['event']) > 0):
                                                        if(is_array($group['event'])):
                                                            foreach($group['event'] as $event):
                                                                $event = (array)$event;
                                                                if(count($event['participant']) > 0):
                                                                    foreach($event['participant'] as $participant):
                                                                        $participant = (array)$participant;
                                                                        if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                            if(isset($multi_sports_list['sports'])):
                                                                                if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                                    $multi_sports_list['sports'][$sport_key] = array();
                                                                                endif;
                                                                                if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                                    if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                        $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                    endif;
                                                                                else:
                                                                                    $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                endif;

                                                                                if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                    if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                        array_push($multi_sports_list['sports'][$sport_key]['leagues'], $league['@attributes']['id']);
                                                                                    endif;
                                                                                else:
                                                                                    $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                            endif;
                                                                        endif;
                                                                    endforeach;
                                                                endif;
                                                            endforeach;
                                                        else:
                                                            $participants = (array)$group['event']->participant;
                                                            if(count($participants) > 0):
                                                                foreach($participants as $participant):
                                                                    $participant = (array)$participant;
                                                                    if(in_array($participants['@attributes']['rot'], $rotations)):
                                                                        if(isset($multi_sports_list['sports'])):
                                                                            if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                                $multi_sports_list['sports'][$sport_key] = array();
                                                                            endif;
                                                                            if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                                if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                    $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;

                                                                            if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                    array_push($multi_sports_list['sports'][$sport_key]['leagues'], $league['@attributes']['id']);
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endif;
                                                    endif;
                                                endforeach;
                                            else:
                                                if(count($league['group']['event']) > 0):
                                                    if(is_array($league['group']['event'])):
                                                        foreach($league['group']['event'] as $event):
                                                            if(count($event['participant']) > 0):
                                                                foreach($event['participant'] as $participant):
                                                                    if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                        if(isset($multi_sports_list['sports'])):
                                                                            if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                                $multi_sports_list['sports'][$sport_key] = array();
                                                                            endif;
                                                                            if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                                if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                    $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;

                                                                            if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                    array_push($multi_sports_list['sports'][$sport_key]['leagues'], $league['@attributes']['id']);
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endforeach;
                                                    else:
                                                        if(count($league['group']['event']['participant']) > 0):
                                                            foreach($league['group']['event']['participant'] as $participant):
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(!isset($$multi_sports_list['sports'][$sport_key])):
                                                                            $multi_sports_list['sports'][$sport_key] = array();
                                                                        endif;
                                                                        if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                            if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                            if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                array_push($multi_sports_list['sports'][$sport_key]['leagues'], $league['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        $multi_sports_list['sports'][$sport_key]['leagues'] = array($league['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endif;
                                                endif;
                                            endif;
                                        endif;
                                    endforeach;
                                else:
                                    if(count($sport['league']['group']) > 0):
                                        if(is_array($sport['league']['group'])):
                                            foreach($sport['league']['group'] as $group):
                                                if(count($group['event']) > 0):
                                                    if(is_array($group['event'])):
                                                        foreach($group['event'] as $event):
                                                            if(count($event['participant']) > 0):
                                                                foreach($event['participant'] as $participant):
                                                                    if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                        if(isset($multi_sports_list['sports'])):
                                                                            if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                                $multi_sports_list['sports'][$sport_key] = array();
                                                                            endif;
                                                                            if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                                if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                    $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;

                                                                            if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                if(!in_array($sport['league']['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                    array_push($multi_sports_list['sports'][$sport_key]['leagues'], $sport['league']['@attributes']['id']);
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                        endif;
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endforeach;
                                                    else:
                                                        if(count($group['event']['participant']) > 0):
                                                            foreach($group['event']['participant'] as $participant):
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                            $multi_sports_list['sports'][$sport_key] = array();
                                                                        endif;
                                                                        if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                            if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                            if(!in_array($sport['league']['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                array_push($multi_sports_list['sports'][$sport_key]['leagues'], $sport['league']['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endif;
                                                endif;
                                            endforeach;
                                        else:
                                            if(count($sport['league']['group']['event']) > 0):
                                                if(is_array($sport['league']['group']['event'])):
                                                    foreach($sport['league']['group']['event'] as $event):
                                                        if(count($event['participant']) > 0):
                                                            foreach($event['participant'] as $participant):
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                            $multi_sports_list['sports'][$sport_key] = array();
                                                                        endif;
                                                                        if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                            if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                                $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                            if(!in_array($sport['league']['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                                array_push($multi_sports_list['sports'][$sport_key]['leagues'], $sport['league']['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    if(count($sport['league']['group']['event']['participant']) > 0):
                                                        foreach($sport['league']['group']['event']['participant'] as $participant):
                                                            if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                if(isset($multi_sports_list['sports'])):
                                                                    if(!isset($multi_sports_list['sports'][$sport_key])):
                                                                        $multi_sports_list['sports'][$sport_key] = array();
                                                                    endif;
                                                                    if(isset($multi_sports_list['sports'][$sport_key]['id'])):
                                                                        if($multi_sports_list['sports'][$sport_key]['id'] == ''):
                                                                            $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                    endif;

                                                                    if(isset($multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                        if(!in_array($sport['league']['@attributes']['id'], $multi_sports_list['sports'][$sport_key]['leagues'])):
                                                                            array_push($multi_sports_list['sports'][$sport_key]['leagues'], $sport['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][$sport_key]['id'] = $sport['@attributes']['id'];
                                                                    $multi_sports_list['sports'][$sport_key]['leagues'] = array($sport['league']['@attributes']['id']);
                                                                endif;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                endif;
                                            endif;
                                        endif;
                                    endif;
                                endif;
                            endif;
                        endforeach;
                    else:
                        if(count($sports['league']) > 0):
                            if(is_array($sports['league'])):
                                foreach($sports['league'] as $league_key => $league):
                                    $league = (array)$league;
                                    if(count($league['group']) > 0):
                                        if(is_array($league['group'])):
                                            foreach($league['group'] as $group):
                                                $group = (array)$group;
                                                if(count($group['event']) > 0):
                                                    $group['event'] = (array)$group['event'];
                                                    if(is_array($group['event'])):
                                                        foreach($group['event'] as $event):
                                                            $event = (array)$event;
                                                            if(count($event['participant']) > 0):
                                                                foreach($event['participant'] as $participant):
                                                                    $participant = (array)$participant;
                                                                    if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                        if(isset($multi_sports_list['sports'])):
                                                                            if(isset($multi_sports_list['sports'][0]['id'])):
                                                                                if($multi_sports_list['sports'][0]['id'] == ''):
                                                                                    $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                            endif;
                                                                            if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                                if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                                    array_push($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues']);
                                                                                endif;
                                                                            else:
                                                                                $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                            $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                        endforeach;
                                                    else:
                                                        if(count($group['event']['participant']) > 0):
                                                            foreach($group['event']['participant'] as $participant):
                                                                $participant = (array)$participant;
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(isset($multi_sports_list['sports'][0]['id'])):
                                                                            if($multi_sports_list['sports'][0]['id'] == ''):
                                                                                $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                            if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                                array_push($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endif;
                                                endif;
                                            endforeach;
                                        else:
                                            if(count($league['group']['event']) > 0):
                                                if(is_array($league['group']['event'])):
                                                    foreach($league['group']['event'] as $event):
                                                        if(count($event['participant']) > 0):
                                                            foreach($event['participant'] as $participant):
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(isset($multi_sports_list['sports'][0]['id'])):
                                                                            if($multi_sports_list['sports'][0]['id'] == ''):
                                                                                $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                            if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                                array_push($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    if(count($league['group']['event']['participant']) > 0):
                                                        foreach($league['group']['event']['participant'] as $participant):
                                                            if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                if($multi_sports_list['sports']):
                                                                    if(isset($multi_sports_list['sports'][0]['id'])):
                                                                        if($multi_sports_list['sports'][0]['id'] == ''):
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    endif;

                                                                    if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                        if(!in_array($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                            array_push($league['@attributes']['id'], $multi_sports_list['sports'][0]['leagues']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    $multi_sports_list['sports'][0]['leagues'] = array($league['@attributes']['id']);
                                                                endif;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                endif;
                                            endif;
                                        endif;
                                    endif;
                                endforeach;
                            else:
                                if(count($sports['league']['group']) > 0):
                                    if(is_array($sports['league']['group'])):
                                        foreach($sports['league']['group'] as $group):
                                            if(count($group['event']) > 0):
                                                if(is_array($group['event'])):
                                                    foreach($group['event'] as $event):
                                                        if(count($event['participant']) > 0):
                                                            foreach($event['participant'] as $participant):
                                                                $participant = (array)$participant;
                                                                if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                    if(isset($multi_sports_list['sports'])):
                                                                        if(isset($multi_sports_list['sports'][0]['id'])):
                                                                            if($multi_sports_list['sports'][0]['id'] == ''):
                                                                                $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;

                                                                        if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                            if(!in_array($sports['league']['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                                array_push($multi_sports_list['sports'][0]['leagues'], $sports['league']['@attributes']['id']);
                                                                            endif;
                                                                        else:
                                                                            $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                    endif;
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    if(count($group['event']['participant']) > 0):
                                                        foreach($group['event']['participant'] as $participant):
                                                            if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                if(isset($multi_sports_list['sports'])):
                                                                    if(isset($multi_sports_list['sports'][0]['id'])):
                                                                        if($multi_sports_list['sports'][0]['id'] == ''):
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    endif;

                                                                    if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                        if(!in_array($sports['league']['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                            array_push($multi_sports_list['sports'][0]['leagues'], $sports['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                endif;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                endif;
                                            endif;
                                        endforeach;
                                    else:
                                        if(count($sports['league']['group']['event']) > 0):
                                            if(is_array($sports['league']['group']['event'])):
                                                foreach($sports['league']['group']['event'] as $event):
                                                    if(count($event['participant']) > 0):
                                                        foreach($event['participant'] as $participant):
                                                            if(in_array($participant['@attributes']['rot'], $rotations)):
                                                                if(isset($multi_sports_list['sports'])):
                                                                    if(isset($multi_sports_list['sports'][0]['id'])):
                                                                        if($multi_sports_list['sports'][0]['id'] == ''):
                                                                            $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    endif;

                                                                    if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                        if(!in_array($sports['league']['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                            array_push($multi_sports_list['sports'][0]['leagues'], $sports['league']['@attributes']['id']);
                                                                        endif;
                                                                    else:
                                                                        $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                endif;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                endforeach;
                                            else:
                                                if(count($sports['league']['group']['event']['participant']) > 0):
                                                    foreach($sports['league']['group']['event']['participant'] as $participant):
                                                        if(in_array($participant['@attributes']['rot'], $rotations)):
                                                            if(isset($multi_sports_list['sports'])):
                                                                if(isset($multi_sports_list['sports'][0]['id'])):
                                                                    if($multi_sports_list['sports'][0]['id'] == ''):
                                                                        $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                endif;

                                                                if(isset($multi_sports_list['sports'][0]['leagues'])):
                                                                    if(!in_array($sports['league']['@attributes']['id'], $multi_sports_list['sports'][0]['leagues'])):
                                                                        array_push($multi_sports_list['sports'][0]['leagues'], $sports['league']['@attributes']['id']);
                                                                    endif;
                                                                else:
                                                                    $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                                endif;
                                                            else:
                                                                $multi_sports_list['sports'][0]['id'] = $sports['@attributes']['id'];
                                                                $multi_sports_list['sports'][0]['leagues'] = array($sports['league']['@attributes']['id']);
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                endif;
                                            endif;
                                        endif;
                                    endif;
                                endif;
                            endif;
                        endif;
                    endif;
                endif;

                dd($multi_sports_list);

                $league_bg_color = array('alert-primary', 'alert-secondary', 'alert-success', 'alert-danger', 'alert-warning', 'alert-info', 'alert-dark');
                if(count($multi_sports_list) > 0):
                    if(count($multi_sports_list['sports']) > 0):
                        foreach($multi_sports_list['sports'] as $msl):
                            $sport_id = $msl['id'];
                            foreach($msl['leagues'] as $l):
                                $league_id = $l;

                                $array_sched_info = $this->arrange_sports_schedule($schedule_xml_to_array, $league_id, $sport_id);
                                $line_odds_xml = $this->curl_get_request($donbest_url.'odds/'.$league_id.'/?token='.$token);
                                $line_odds_xml = simplexml_load_string($line_odds_xml);

                                if(!$line_odds_xml):
                                    $data .= '<div class="col-md-12 text-center"><h3>Error fetching XML data from source API!</h3></div>';
                                else:
                                    $line_odds_xml_to_array = $this->xml_to_array($line_odds_xml);

                                    $line_odds_info = array();

                                    $get_sports_details = $this->mdl_admin->get_data('playoffs_series, league_name, sport_name', 'sport_status', array('league_id' => $league_id));

                                    if(isset($line_odds_xml_to_array['event']) AND count($line_odds_xml_to_array) > 0):
                                        $line_odds_info = $line_odds_xml_to_array['event'];
                                    endif;

                                    $has_event_arr = array();

                                    $data .= '<div class="m-b-30" style="border-bottom: 3px solid #555;">';
                                    $data .= '<div class="alert '.$league_bg_color[array_rand($league_bg_color)].'" role="alert">
												<span class="font-bold">'.strtoupper($get_sports_details->row()->sport_name).' - '.strtoupper($get_sports_details->row()->league_name).'</span>
										</div>';

                                    if(isset($array_sched_info['schedules']['sports'])):
                                        if(count($array_sched_info['schedules']['sports']) > 0):
                                            foreach($array_sched_info['schedules']['sports'] as $sport):
                                                $sport =(array)$sport;
                                                if(isset($sport['leagues'])):
                                                    if(count($sport['leagues']) > 0):
                                                        foreach($sport['leagues'] as $league):
                                                            $league = (array)$league;
                                                            if(isset($league['groups'])):
                                                                if(count($league['groups']) > 0):
                                                                    $current_group_id = "";
                                                                    foreach($league['groups'] as $group):
                                                                        $group = (array)$group;
                                                                        if(isset($$group['events']) AND count($group['events']) > 0 AND count($line_odds_info) > 0):
                                                                            foreach($group['events'] as $event):
                                                                                $event = (array)$event;
                                                                                if(count($event) > 0):
                                                                                    if(count($event['event_participant']) > 0):
                                                                                        if($league['league_id'] != '14' AND $league['league_id'] != '11' AND strlen($event['event_participant'][0]['rot']) == 4 AND strlen($event['event_participant'][1]['rot']) == 4):
                                                                                            continue;
                                                                                        endif;
                                                                                        if($league['league_id'] == '2' AND (strlen($event['event_participant'][0]['rot']) > 3 AND strlen($event['event_participant'][1]['rot']) > 3)):
                                                                                            continue;
                                                                                        endif;
                                                                                    endif;
                                                                                    $has_rot = FALSE;
                                                                                    if(isset($event['event_participant'])):
                                                                                        foreach($event['event_participant'] as $p):
                                                                                            $p = (array)$p;
                                                                                            if(in_array($p['rot'], $rotations)):
                                                                                                $has_rot = TRUE;
                                                                                            endif;
                                                                                        endforeach;
                                                                                    endif;
                                                                                    if($has_rot):
                                                                                        if(strtotime(date('Y-m-d h:i:s A', strtotime($event['event_date']))) >= strtotime(date('Y-m-d h:i:s A')) ):
                                                                                            if(count($line_odds_info) == 1):
                                                                                                $line_odds = array();
                                                                                                $line_odds[0] = $line_odds_info;
                                                                                            else:
                                                                                                $line_odds = $line_odds_info;
                                                                                            endif;
                                                                                            if($current_group_id == "" OR $current_group_id != $group['group_id'] ):
                                                                                                $data .= '<div class="p-2 bg-pick-date-label text-white text-center bg-dark">'.date('l, F dS, Y', strtotime($event['event_date'])).'</div>';
                                                                                            endif;

                                                                                            array_push($has_event_arr, 1);

                                                                                            $half_header = '';
                                                                                            $ou_header = '';
                                                                                            $line_header = '';
                                                                                            $current_group_id = $group['group_id'];
                                                                                            $data .= '<div class="table-responsive" style="overflow-y: hidden !important;">';
                                                                                            $data .= '<table id="'.$event['event_id'].'" class="table table-hover table-bordered pick-list" data-sportid="'.$sport['sport_id'].'" data-sportname="'.$sport['sport_name'].'" data-leagueid="'.$league['league_id'].'" data-leaguename="'.$league['league_name'].'">';
                                                                                            // Table Heading
                                                                                            $data .= '<thead>';
                                                                                            $data .= '<th class="col-md-3 col-sm-3 col-xs-3" style="text-align: left !important;"><span>'.date('m/d g:i A', strtotime($event['event_date'])).'</span> - ';
                                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-l-5 m-r-10"><input type="checkbox" id="start_multi_'.$event['event_id'].'" class="custom-control-input start-multi-input"><span class="custom-control-label start-multi-label">START MULTI</span></label>';
                                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-r-10"><input type="checkbox" id="make_solo_'.$event['event_id'].'" class="custom-control-input make-solo-input" disabled><span class="custom-control-label make-solo-label">MAKE SOLO</span></label>';
                                                                                            $data .= '	<label class="custom-control custom-checkbox custom-control-inline custom-checkbox-picks m-r-10" style="width: 10% !important;"><input type="checkbox" id="make_free_'.$event['event_id'].'" class="custom-control-input make-free-input"><span class="custom-control-label make-free-label">FREE</span></label>';
                                                                                            $data .= '	<div class="multi-price display-none"> <span class="p-l-10"> MULTI PRICE</span> <input type="text" class="form-control picks-input-text text-dark font-bold multi-price-input" name="input_multi_price_'.$event["event_id"].'" id="input_multi_price_'.$event["event_id"].'" value="05" /></div>';
                                                                                            $data .= '</th>';
                                                                                            if(in_array((int)$league_id, $game_ou_league)):
                                                                                                $data .= '<th>Game</th>';
                                                                                                $data .= '<th>Over/Under</th>';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $firsthalf_league)):
                                                                                                $data .= '<th>1st Half</th>';
                                                                                                $data .= '<th>1st Half O/U</th>';
                                                                                                $half_header = '1st Half';
                                                                                                $ou_header = '1st Half O/U';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $first_inn_league)):
                                                                                                $data .= '<th>1st 5 Inn</th>';
                                                                                                $data .= '<th>1st 5 Inn O/U</th>';
                                                                                                $half_header = '1st 5 Inn';
                                                                                                $ou_header = '1st 5 Inn O/U';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $first_per_league)):
                                                                                                $data .= '<th>1st 5 Per</th>';
                                                                                                $data .= '<th>1st 5 Per O/U</th>';
                                                                                                $half_header = '1st 5 Per';
                                                                                                $ou_header = '1st 5 Per O/U';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $draw_league)):
                                                                                                $data .= '<th>Draw</th>';
                                                                                                $draw_header = 'Draw';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $moneyline_league)):
                                                                                                $data .= '<th>Money Line</th>';
                                                                                                $line_header = 'Money Line';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $runline_league)):
                                                                                                $data .= '<th>Run Line</th>';
                                                                                                $line_header = 'Run Line';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $puckline_league)):
                                                                                                $data .= '<th>Puck Line</th>';
                                                                                                $line_header = 'Puck Line';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $goalline_league)):
                                                                                                $data .= '<th>Goal Line</th>';
                                                                                                $line_header = 'Goal Line';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $towin_league)):
                                                                                                $data .= '<th>To Win</th>';
                                                                                                $towin_header = 'To Win';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $matchup_league)):
                                                                                                $data .= '<th>Matchup</th>';
                                                                                                $matchup_header = 'Matchup';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $golf_league)):
                                                                                                $data .= '<th>Match</th>';
                                                                                                $data .= '<th>Strokes</th>';
                                                                                                $data .= '<th>Draw</th>';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $rounds_league)):
                                                                                                $data .= '<th>Rounds</th>';
                                                                                                $round_header = 'Rounds';
                                                                                            endif;
                                                                                            if(in_array((int)$league_id, $series_playoffs_league) AND $get_sports_details->row()->playoffs_series == 1):
                                                                                                $data .= '<th>Playoffs/Series</th>';
                                                                                            endif;
                                                                                            $data .= '</thead>';

                                                                                            // Table Body
                                                                                            $data .= '<tbody>';

                                                                                            $time_FG 				= "";
                                                                                            $time_1H 				= "";
                                                                                            $away_spread_FG 		= "";
                                                                                            $home_spread_FG 		= "";
                                                                                            $away_price_FG 			= "";
                                                                                            $home_price_FG 			= "";
                                                                                            $away_money_FG 			= "";
                                                                                            $home_money_FG 			= "";
                                                                                            $draw_money_FG 			= "";
                                                                                            $total_FG 				= "";
                                                                                            $over_price_FG 			= "";
                                                                                            $under_price_FG 		= "";
                                                                                            $away_total_FG 			= "";
                                                                                            $away_over_price_FG 	= "";
                                                                                            $away_under_price_FG 	= "";
                                                                                            $home_total_FG 			= "";
                                                                                            $home_over_price_FG 	= "";
                                                                                            $home_under_price_FG 	= "";
                                                                                            $home_FG 				= "";
                                                                                            $away_FG 				= "";

                                                                                            $away_spread_1H 		= "";
                                                                                            $home_spread_1H 		= "";
                                                                                            $away_price_1H 			= "";
                                                                                            $home_price_1H 			= "";
                                                                                            $away_money_1H 			= "";
                                                                                            $home_money_1H 			= "";
                                                                                            $draw_money_1H 			= "";
                                                                                            $total_1H 				= "";
                                                                                            $over_price_1H 			= "";
                                                                                            $under_price_1H 		= "";
                                                                                            $away_total_1H 			= "";
                                                                                            $away_over_price_1H 	= "";
                                                                                            $away_under_price_1H 	= "";
                                                                                            $home_total_1H 			= "";
                                                                                            $home_over_price_1H 	= "";
                                                                                            $home_under_price_1H 	= "";
                                                                                            $home_1H 				= "";
                                                                                            $away_1H 				= "";

                                                                                            foreach($line_odds as $line_event):
                                                                                                $line_event = (array)$line_event;
                                                                                                if(isset($line_event['@attributes']) AND $line_event['@attributes']['id'] == $event['event_id']):
                                                                                                    if(isset($line_event['line']) AND count($line_event['line']) > 0):
                                                                                                        foreach($line_event['line'] as $line):
                                                                                                            if(
                                                                                                                isset($line['@attributes']) AND
                                                                                                                isset($line['@attributes']['type']) AND
                                                                                                                strtoupper($line['@attributes']['type']) == "CURRENT" AND
                                                                                                                isset($line['@attributes']['no_line']) AND
                                                                                                                strtoupper($line['@attributes']['no_line']) == "FALSE"
                                                                                                            ):
                                                                                                                if(in_array((int)$league_id, $game_ou_league) OR in_array((int)$league_id, $towin_league) OR in_array((int)$league_id, $matchup_league) OR in_array((int)$league_id, $golf_league) OR in_array((int)$league_id, $rounds_league) OR in_array((int)$league_id, $draw_league)):
                                                                                                                    if($line['@attributes']['period_id'] == "1"):
                                                                                                                        if($time_FG == ""):
                                                                                                                            $time_FG = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if(isset($$line['ps'])):
                                                                                                                                $away_spread_FG = $line['ps']['@attributes']['away_spread'];
                                                                                                                                $home_spread_FG = $line['ps']['@attributes']['home_spread'];
                                                                                                                                $away_price_FG = $line['ps']['@attributes']['away_price'];
                                                                                                                                $home_price_FG = $line['ps']['@attributes']['home_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['money'])):
                                                                                                                                $away_money_FG 	= $line['money']['@attributes']['away_money'];
                                                                                                                                $home_money_FG 	= $line['money']['@attributes']['home_money'];
                                                                                                                                $draw_money_FG 	= $line['money']['@attributes']['draw_money'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['total'])):
                                                                                                                                $over_price_FG 	= $line['total']['@attributes']['over_price'];
                                                                                                                                $under_price_FG = $line['total']['@attributes']['under_price'];
                                                                                                                                $total_FG 		= $line['total']['@attributes']['total'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['team_total'])):
                                                                                                                                $away_total_FG 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                $away_over_price_FG 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                $away_under_price_FG 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                $home_total_FG 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                $home_over_price_FG 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                $home_under_price_FG 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['display'])):
                                                                                                                                $away_FG 	= $line['display']['@attributes']['away'];
                                                                                                                                $home_FG 	= $line['display']['@attributes']['home'];
                                                                                                                            endif;
                                                                                                                        else:
                                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if($time_FG < $new):
                                                                                                                                $time_FG = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                                if(isset($line['ps'])):
                                                                                                                                    $away_spread_FG = $line['ps']['@attributes']['away_spread'];
                                                                                                                                    $home_spread_FG = $line['ps']['@attributes']['home_spread'];
                                                                                                                                    $away_price_FG = $line['ps']['@attributes']['away_price'];
                                                                                                                                    $home_price_FG = $line['ps']['@attributes']['home_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['money'])):
                                                                                                                                    $away_money_FG 	= $line['money']['@attributes']['away_money'];
                                                                                                                                    $home_money_FG 	= $line['money']['@attributes']['home_money'];
                                                                                                                                    $draw_money_FG 	= $line['money']['@attributes']['draw_money'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['total'])):
                                                                                                                                    $over_price_FG 	= $line['total']['@attributes']['over_price'];
                                                                                                                                    $under_price_FG = $line['total']['@attributes']['under_price'];
                                                                                                                                    $total_FG 		= $line['total']['@attributes']['total'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['team_total'])):
                                                                                                                                    $away_total_FG 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                    $away_over_price_FG 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                    $away_under_price_FG 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                    $home_total_FG 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                    $home_over_price_FG 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                    $home_under_price_FG 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['display'])):
                                                                                                                                    $away_FG 	= $line['display']['@attributes']['away'];
                                                                                                                                    $home_FG 	= $line['display']['@attributes']['home'];
                                                                                                                                endif;
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;

                                                                                                                if(in_array((int)$league_id, $firsthalf_league) OR in_array((int)$league_id, $first_inn_league)):
                                                                                                                    if($line['@attributes']['period_id'] == "2"):
                                                                                                                        if($time_1H == ""):
                                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if(isset($line['ps'])):
                                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['money'])):
                                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['total'])):
                                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['team_total'])):
                                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['display'])):
                                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                            endif;
                                                                                                                        else:
                                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if($time_1H < $new):
                                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                                if(isset($line['ps'])):
                                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['money'])):
                                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['total'])):
                                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['team_total'])):
                                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['display'])):
                                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                                endif;
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                elseif(in_array((int)$league_id, $first_inn_league)):
                                                                                                                    if($line['@attributes']['period_id'] == "25"):
                                                                                                                        if($time_1H == ""):
                                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if(isset($line['ps'])):
                                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['money'])):
                                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['total'])):
                                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['team_total'])):
                                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['display'])):
                                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                            endif;

                                                                                                                        else:
                                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if($time_1H < $new):
                                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                                if(isset($line['ps'])):
                                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['money'])):
                                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['total'])):
                                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['team_total'])):
                                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['display'])):
                                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                                endif;
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                elseif(in_array((int)$league_id, $first_per_league)):
                                                                                                                    if($line['@attributes']['period_id'] == "30"):
                                                                                                                        if($time_1H == ""):
                                                                                                                            $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if(isset($line['ps'])):
                                                                                                                                $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['money'])):
                                                                                                                                $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['total'])):
                                                                                                                                $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['team_total'])):
                                                                                                                                $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                            endif;

                                                                                                                            if(isset($line['display'])):
                                                                                                                                $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                            endif;

                                                                                                                        else:
                                                                                                                            $new = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                            if($time_1H < $new):
                                                                                                                                $time_1H = strtotime(date('Y-m-d h:i:s A', strtotime($line['@attributes']['time'])));
                                                                                                                                if(isset($line['ps'])):
                                                                                                                                    $away_spread_1H = $line['ps']['@attributes']['away_spread'];
                                                                                                                                    $home_spread_1H = $line['ps']['@attributes']['home_spread'];
                                                                                                                                    $away_price_1H = $line['ps']['@attributes']['away_price'];
                                                                                                                                    $home_price_1H = $line['ps']['@attributes']['home_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['money'])):
                                                                                                                                    $away_money_1H 	= $line['money']['@attributes']['away_money'];
                                                                                                                                    $home_money_1H 	= $line['money']['@attributes']['home_money'];
                                                                                                                                    $draw_money_1H 	= $line['money']['@attributes']['draw_money'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['total'])):
                                                                                                                                    $over_price_1H 	= $line['total']['@attributes']['over_price'];
                                                                                                                                    $under_price_1H = $line['total']['@attributes']['under_price'];
                                                                                                                                    $total_1H 		= $line['total']['@attributes']['total'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['team_total'])):
                                                                                                                                    $away_total_1H 			= $line['team_total']['@attributes']['away_total'];
                                                                                                                                    $away_over_price_1H 	= $line['team_total']['@attributes']['away_over_price'];
                                                                                                                                    $away_under_price_1H 	= $line['team_total']['@attributes']['away_under_price'];
                                                                                                                                    $home_total_1H 	 		= $line['team_total']['@attributes']['home_total'];
                                                                                                                                    $home_over_price_1H 	= $line['team_total']['@attributes']['home_over_price'];
                                                                                                                                    $home_under_price_1H 	= $line['team_total']['@attributes']['home_under_price'];
                                                                                                                                endif;

                                                                                                                                if(isset($line['display'])):
                                                                                                                                    $away_1H 	= $line['display']['@attributes']['away'];
                                                                                                                                    $home_1H 	= $line['display']['@attributes']['home'];
                                                                                                                                endif;
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endforeach;
                                                                                                    endif;
                                                                                                endif;
                                                                                            endforeach;

                                                                                            if(count($event['event_participant']) > 0):
                                                                                                foreach($event['event_participant'] as $participant):
                                                                                                    if(($league['league_id'] != '14' AND $league['league_id'] != '11') AND strlen($participant['rot']) == 4):
                                                                                                        continue;
                                                                                                    endif;
                                                                                                    if($league['league_id'] == '2' AND strlen($participant['rot']) > 3 ):
                                                                                                        continue;
                                                                                                    endif;
                                                                                                    $game 					= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_spread_FG : $home_spread_FG;
                                                                                                    if(strpos($game, '-') !== FALSE AND $game != ""):
                                                                                                        $game = (abs($game) == 0) ? 'pk' : '-'.abs($game);
                                                                                                    elseif(strpos($game, '-') === FALSE AND $game != ""):
                                                                                                        $game = (abs($game) == 0) ? 'pk' : '+'.abs($game);
                                                                                                    else:
                                                                                                        $game = "";
                                                                                                    endif;

                                                                                                    $game_price 			= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_price_FG : $home_price_FG;

                                                                                                    if($game != ""):
                                                                                                        if(strpos($game_price, '-') !== FALSE AND $game_price != ""):
                                                                                                            $game_price = '-'.abs($game_price);
                                                                                                        elseif(strpos($game_price, '-') === FALSE AND $game_price != ""):
                                                                                                            $game_price = '+'.abs($game_price);
                                                                                                        else:
                                                                                                            $game_price = "";
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $game_price = "";
                                                                                                    endif;


                                                                                                    $ov_un 					= $total_FG;
                                                                                                    if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                                        if($ov_un == 0):
                                                                                                            $ov_un = "";
                                                                                                        else:
                                                                                                            $ov_un = 'o'.abs($ov_un);
                                                                                                        endif;
                                                                                                    else:
                                                                                                        if($ov_un == 0):
                                                                                                            $ov_un = "";
                                                                                                        else:
                                                                                                            $ov_un = 'u'.abs($ov_un);
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    $ov_un_price 			= (strtoupper($participant['side'] ?? '') == "AWAY") ? $under_price_FG : $over_price_FG;
                                                                                                    if($ov_un != ""):
                                                                                                        if(strpos($ov_un_price, '-') !== FALSE AND $ov_un_price != ""):
                                                                                                            $ov_un_price = '-'.abs($ov_un_price);
                                                                                                        elseif(strpos($ov_un_price, '-') === FALSE AND $ov_un_price != ""):
                                                                                                            $ov_un_price = '+'.abs($ov_un_price);
                                                                                                        else:
                                                                                                            $ov_un_price = "";
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $ov_un_price = "";
                                                                                                    endif;

                                                                                                    $first_half_game 		= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_spread_1H : $home_spread_1H;
                                                                                                    if(strpos($first_half_game, '-') !== FALSE AND $first_half_game != ""):
                                                                                                        $first_half_game = '-'.abs($first_half_game);
                                                                                                    elseif(strpos($first_half_game, '-') === FALSE AND $first_half_game != ""):
                                                                                                        $first_half_game = '+'.abs($first_half_game);
                                                                                                    else:
                                                                                                        $first_half_game = "";
                                                                                                    endif;

                                                                                                    $first_half_game_price 	= (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_price_1H : $home_price_1H;
                                                                                                    if($first_half_game != ""):
                                                                                                        if(strpos($first_half_game_price, '-') !== FALSE AND $first_half_game_price != ""):
                                                                                                            $first_half_game_price = '-'.abs($first_half_game_price);
                                                                                                        elseif(strpos($first_half_game, '-') === FALSE AND $first_half_game_price != ""):
                                                                                                            $first_half_game_price = '+'.abs($first_half_game_price);
                                                                                                        else:
                                                                                                            $first_half_game_price = "";
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $first_half_game_price = "";
                                                                                                    endif;

                                                                                                    $first_half_ov_un 		= $total_1H;
                                                                                                    if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                                        if($first_half_ov_un == 0):
                                                                                                            $first_half_ov_un = "";
                                                                                                        else:
                                                                                                            $first_half_ov_un = 'o'.abs($first_half_ov_un);
                                                                                                        endif;
                                                                                                    else:
                                                                                                        if($first_half_ov_un == 0):
                                                                                                            $first_half_ov_un = "";
                                                                                                        else:
                                                                                                            $first_half_ov_un = 'u'.abs($first_half_ov_un);
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    $first_half_ov_un_price = (strtoupper($participant['side'] ?? '') == "AWAY") ? $under_price_1H : $over_price_1H;
                                                                                                    if($first_half_ov_un != ""):
                                                                                                        if(strpos($first_half_ov_un_price, '-') !== FALSE AND $first_half_ov_un_price != ""):
                                                                                                            $first_half_ov_un_price = '-'.abs($first_half_ov_un_price);
                                                                                                        elseif(strpos($first_half_ov_un_price, '-') === FALSE AND $first_half_ov_un_price != ""):
                                                                                                            $first_half_ov_un_price = '+'.abs($first_half_ov_un_price);
                                                                                                        else:
                                                                                                            $first_half_ov_un_price = "";
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $first_half_ov_un_price = "";
                                                                                                    endif;

                                                                                                    $money_line = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_money_FG : $home_money_FG;
                                                                                                    if(strpos($money_line, '-') !== FALSE AND $money_line != ""):
                                                                                                        $money_line = '-'.abs($money_line);
                                                                                                    elseif(strpos($money_line, '-') === FALSE AND $money_line != ""):
                                                                                                        $money_line = '+'.abs($money_line);
                                                                                                    else:
                                                                                                        $money_line = "";
                                                                                                    endif;

                                                                                                    $money_line_1H = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_money_1H : $home_money_1H;
                                                                                                    if(strpos($money_line_1H, '-') !== FALSE AND $money_line_1H != ""):
                                                                                                        $money_line_1H = '-'.abs($money_line_1H);
                                                                                                    elseif(strpos($money_line_1H, '-') === FALSE AND $money_line_1H != ""):
                                                                                                        $money_line_1H = '+'.abs($money_line_1H);
                                                                                                    else:
                                                                                                        $money_line_1H = "";
                                                                                                    endif;

                                                                                                    $display = (strtoupper($participant['side'] ?? '') == "AWAY") ? $away_FG : $home_FG;

                                                                                                    if(strpos($display, '%2B') !== FALSE):
                                                                                                        $display = substr($display, 3);
                                                                                                    endif;

                                                                                                    if(strpos($display, '-') !== FALSE AND $display != "" AND abs($display) > 0):
                                                                                                        $display = '-'.abs($display);
                                                                                                    elseif(strpos($display, '-') === FALSE AND $display != "" AND abs($display) > 0):
                                                                                                        $display = '+'.abs($display);
                                                                                                    else:
                                                                                                        $display = "";
                                                                                                    endif;

                                                                                                    $display_reverse = (strtoupper($participant['side'] ?? '') == "AWAY") ? $home_FG : $away_FG;

                                                                                                    if(strpos($display_reverse, '%2B') !== FALSE):
                                                                                                        $display_reverse = substr($display_reverse, 3);
                                                                                                    endif;

                                                                                                    if(strpos($display_reverse, '-') !== FALSE AND $display_reverse != "" AND abs($display_reverse) > 0):
                                                                                                        $display_reverse = '-'.abs($display_reverse);
                                                                                                        if(abs($away_FG) > abs($home_FG)):
                                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                                $display_reverse.= ' No';
                                                                                                            else:
                                                                                                                $display_reverse.= ' Yes';
                                                                                                            endif;
                                                                                                        elseif(abs($away_FG) < abs($home_FG)):
                                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                                $display_reverse.= ' Yes';
                                                                                                            else:
                                                                                                                $display_reverse.= ' No';
                                                                                                            endif;
                                                                                                        else:
                                                                                                            $display_reverse.= ' Even';
                                                                                                        endif;
                                                                                                    elseif(strpos($display_reverse, '-') === FALSE AND $display_reverse != "" AND abs($display_reverse) > 0):
                                                                                                        $display_reverse = '+'.abs($display_reverse);
                                                                                                        if(abs($away_FG) > abs($home_FG)):
                                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                                $display_reverse.= ' No';
                                                                                                            else:
                                                                                                                $display_reverse.= ' Yes';
                                                                                                            endif;
                                                                                                        elseif(abs($away_FG) < abs($home_FG)):
                                                                                                            if((strtoupper($participant['side'])) == "AWAY"):
                                                                                                                $display_reverse.= ' Yes';
                                                                                                            else:
                                                                                                                $display_reverse.= ' No';
                                                                                                            endif;
                                                                                                        else:
                                                                                                            $display_reverse.= ' Even';
                                                                                                        endif;
                                                                                                    else:
                                                                                                        $display_reverse = "";
                                                                                                    endif;

                                                                                                    $data .= '<tr class="game-info">';
                                                                                                    $data .= '<td class="game-team"><span class="p-2">'.$participant['rot'].' - '.$participant['team_name'].'</span></td>';
                                                                                                    if(in_array((int)$league_id, $game_ou_league)):
                                                                                                        if((int)$league_id == 9 OR (int)$league_id == 7 OR (int)$league_id == 5):
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="A'.$event['event_id'].'" data-head="Game" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Game" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Game" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                                        else:
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="A'.$event['event_id'].'" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.'</span><span class="display-block fs-11 selected-details" data-head="Game" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game_price.'</span></div>' : "").'</td>';
                                                                                                        endif;
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="B'.$event['event_id'].'" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.(($ov_un != "") ? '<div class="display-block odds-hover selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.$ov_un.'</span><span class="display-block fs-11 selected-details" data-head="Over/Under" data-juice="'.$ov_un_price.'" data-value="'.$ov_un.'">'.$ov_un_price.'</span></div>' : "").'</td>';
                                                                                                    endif;
                                                                                                    if(in_array((int)$league_id, $firsthalf_league) OR in_array((int)$league_id, $first_inn_league) OR in_array((int)$league_id, $first_per_league)):
                                                                                                        if((int)$league_id == 5 OR (int)$league_id == 7):
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="C'.$event['event_id'].'" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'">'.(($money_line_1H != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$half_header.'" data-juice="" data-value="'.$money_line_1H.'">'.$money_line_1H.'</span></div>' : "" ).'</td>';
                                                                                                        else:
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="C'.$event['event_id'].'" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.(($first_half_game != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.$first_half_game.'</span><span class="display-block fs-11 selected-details" data-head="'.$half_header.'" data-juice="'.$first_half_game_price.'" data-value="'.$first_half_game.'">'.$first_half_game_price.'</span></div>' : "").'</td>';
                                                                                                        endif;
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="D'.$event['event_id'].'" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.(($first_half_ov_un != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.$first_half_ov_un.'</span><span class="display-block fs-11 selected-details" data-head="'.$ou_header.'" data-juice="'.$first_half_ov_un_price.'" data-value="'.$first_half_ov_un.'">'.$first_half_ov_un_price.'</span></div>': "").'</td>';
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $draw_league)):
                                                                                                        if((int)$league_id == 9):
                                                                                                            if(((strtoupper($participant['side'])) == "AWAY")):
                                                                                                                $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes">'.(($draw_money_FG != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes">'.$draw_money_FG.' Yes</span></div>' : "" ).'</td>';
                                                                                                            else:
                                                                                                                $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' Yes"></td>';
                                                                                                            endif;
                                                                                                        else:
                                                                                                            $draw_value = ((strtoupper($participant['side'])) == "AWAY") ? 'Yes' : 'No';
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'">'.(($draw_money_FG != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$draw_money_FG.' '.$draw_value.'">'.$draw_money_FG.' '.$draw_value.'</span></div>' : "" ).'</td>';
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $moneyline_league) OR in_array((int)$league_id, $runline_league) OR in_array((int)$league_id, $puckline_league) OR in_array((int)$league_id, $goalline_league)):
                                                                                                        if((int)$league_id == 9 OR (int)$league_id == 7 OR (int)$league_id == 5):
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="E'.$event['event_id'].'" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.'</span><span class="display-block fs-11 selected-details" data-head="'.$line_header.'" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game_price.'</span></div>' : "").'</td>';
                                                                                                        else:
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="E'.$event['event_id'].'" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="'.$line_header.'" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $golf_league)):
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="F'.$event['event_id'].'" data-head="Match" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Match" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Match" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="G'.$event['event_id'].'" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'">'.(($game != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Strokes" data-juice="'.$game_price.'" data-value="'.$game.'">'.$game.' ('.$game_price.')</span></div>' : "").'</td>';
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="H'.$event['event_id'].'" data-head="Draw" data-juice="" data-value="'.$display_reverse.'">'.(($display_reverse != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Draw" data-juice="" data-value="'.$display_reverse.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Draw" data-juice="" data-value="'.$display_reverse.'">'.$display_reverse.'</span></div>' : "" ).'</td>';
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $towin_league)):
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="I'.$event['event_id'].'" data-head="ToWin" data-juice="" data-value="'.$money_line.'">'.(($money_line != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="ToWin" data-juice="" data-value="'.$money_line.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="ToWin" data-juice="" data-value="'.$money_line.'">'.$money_line.'</span></div>' : "" ).'</td>';
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $matchup_league)):
                                                                                                        if($league_id == '14'):
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="J'.$event['event_id'].'" data-head="Matchup" data-juice="" data-value="'.$game_price.'">'.(($game_price != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Matchup" data-juice="" data-value="'.$game_price.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Matchup" data-juice="" data-value="'.$game_price.'">'.$game_price.'</span></div>' : "" ).'</td>';
                                                                                                        else:
                                                                                                            $data .= '<td class="game-odds text-center" data-integrityid="J'.$event['event_id'].'" data-head="Matchup" data-juice="" data-value="'.$display.'">'.(($display != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Matchup" data-juice="" data-value="'.$display.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Matchup" data-juice="" data-value="'.$display.'">'.$display.'</span></div>' : "" ).'</td>';
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(in_array((int)$league_id, $rounds_league)):
                                                                                                        if(strtoupper($participant['side'] ?? '') == "AWAY"):
                                                                                                            $total_rounds = "o".$total_FG;
                                                                                                        else:
                                                                                                            $total_rounds = "u".$total_FG;
                                                                                                        endif;
                                                                                                        $data .= '<td class="game-odds text-center" data-integrityid="K'.$event['event_id'].'" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'">'.(($ov_un_price != "") ? '<div class="display-block odds-hover selected-details p-t-12 p-b-12" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'"><span class="font-bold text-dark display-block fs-14 selected-details" data-head="Rounds" data-juice="'.$ov_un_price.'" data-value="'.$total_rounds.'">'.$total_rounds.' '.$ov_un_price.'</span></div>' : "" ).'</td>';

                                                                                                    endif;
                                                                                                    if(in_array((int)$league_id, $series_playoffs_league) AND $get_sports_details->row()->playoffs_series == 1):
                                                                                                        $data .= '<td></td>';
                                                                                                    endif;

                                                                                                    $data .= '</tr>';

                                                                                                    $data .= '<tr class="display-none pick-details">';
                                                                                                    $data .= '<td colspan="7">';
                                                                                                    $data .= '<div class="row m-0">';
                                                                                                    $data .= '<div class="col-md-12 m-b-10">';
                                                                                                    $data .= '<button type="button" id="btn_reset_selected_pick_'.$event['event_id'].'" class="btn btn-sm btn-danger pull-right btn_reset_selected_pick"><i class="fas fa-times"></i></button>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-12" style="border-top: 1px solid #aaa;">';
                                                                                                    $data .= '<div class="row">';

                                                                                                    $data .= '<div class="col-md-2 p-l-5 p-r-5">';
                                                                                                    $data .= '<input type="hidden" value="'.$participant['rot'].'" class="rot-input" />';
                                                                                                    $data .= '<input type="hidden" value="'.date('Y-m-d g:i:s', strtotime($event['event_date'])).'" class="event-datetime-input" />';
                                                                                                    $data .= '<input type="hidden" value="'.$participant['team_name'].'" class="team-name-input" />';
                                                                                                    $data .= '<input type="hidden" value="'.(isset($participant['side'])) ? $participant['side'] : ''.'" class="side-input" />';
                                                                                                    $data .= '<span class="font-bold display-block p-2">'.date('g:i A T', strtotime($event['event_date'])).'</span>';
                                                                                                    $data .= '<span class="display-block p-2">'.$participant['rot'].' - '.$participant['team_name'].'</span>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-1 text-center p-l-5 p-r-5">';
                                                                                                    $data .= '<input type="hidden" class="selected-header-input"/>';
                                                                                                    $data .= '<input type="hidden" class="selected-juice-input"/>';
                                                                                                    $data .= '<span class="font-bold display-block p-2 selected-header"></span>';
                                                                                                    $data .= '<input type="hidden" class="selected-value-input"/>';
                                                                                                    $data .= '<span class="display-block selected-value"></span>';
                                                                                                    $data .= '<input type="hidden" class="selected-integrity-id"/>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-1 text-center single-price p-l-5 p-r-5">';
                                                                                                    $data .= '<span class="font-bold display-block p-2">Price</span>';
                                                                                                    $data .= '<input type="text" id="single_price_input_'.$event['event_id'].'" class="form-control picks-input-text text-dark font-bold display-block single-price-input" value="05" style="width:100% !important;" name="price"/>';
                                                                                                    $data .= '</div>';

                                                                                                    if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                        $data .= '<div class="col-md-1 text-center pitcher-details p-l-5 p-r-5">';
                                                                                                        $data .= '<span class="font-bold display-block p-2">Pitcher</span>';
                                                                                                        $data .= '<select class="picks-select pitcher-select form-control" id="pitcher_select_'.$event['event_id'].'">';
                                                                                                        $data .= '<option value="" selected disabled>Select</option>';
                                                                                                        $data .= '<option value="ACTION">Action</option>';
                                                                                                        $data .= '<option value="BOX">Box</option>';
                                                                                                        $data .= '<option value="'.$participant['pitcher_full_name'].'" data-pitcherid="'.$participant['pitcher_id'].'" data-pitcherhand="'.$participant['pitcher_hand'].'">'.$participant['pitcher_name'].'</option>';
                                                                                                        $data .= '</select>';
                                                                                                        $data .= '</div>';
                                                                                                    endif;

                                                                                                    $data .= '<div class="col-md-1 text-center rating-type p-l-5 p-r-5">';
                                                                                                    $data .= '<span class="font-bold display-block p-2">Rating Type</span>';
                                                                                                    $data .= '<select class="form-control picks-select rating-type-select form-control" id="rating_type_select_'.$event['event_id'].'">';
                                                                                                    $data .= '<option value="" selected disabled>Select Type</option>';
                                                                                                    // $data .= '<option value="FREE">FREE</option>';
                                                                                                    // $data .= '<option value="LEAN">LEAN</option>';
                                                                                                    // $data .= '<option value="REG">REGULAR</option>';
                                                                                                    // $data .= '<option value="STRONG">STRONG</option>';
                                                                                                    // $data .= '<option value="TOPPLAY">TPLAY</option>';
                                                                                                    $data .= $rating_type;
                                                                                                    $data .= '</select>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-1 text-center rating-number p-l-5 p-r-5">';
                                                                                                    $data .= '<span class="font-bold display-block p-2">Rating #</span>';
                                                                                                    $data .= '<select class="picks-select rating-number-select form-control" id="rating_number_select_'.$event['event_id'].'" disabled>';
                                                                                                    $data .= '</select>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-1 text-center tplay p-l-5 p-r-5 display-none">';
                                                                                                    $data .= '<span class="font-bold display-block p-2">T-Play</span>';
                                                                                                    $data .= '<select class="picks-select tplay-designation-select form-control" id="tplay_select_'.$event['event_id'].'" disabled>';
                                                                                                    $data .= '<option value="" selected disabled>Select</option>';
                                                                                                    $data .= '<option value="GOW">GOW</option>';
                                                                                                    $data .= '<option value="GOM">GOM</option>';
                                                                                                    $data .= '<option value="GOY">GOY</option>';
                                                                                                    $data .= '</select>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-2 text-center p-l-5 p-r-5 tplay-title display-none">';
                                                                                                    $data .= '<span class="font-bold display-block p-2">T-Play Title</span>';
                                                                                                    $data .= '<select class="picks-select tplay-title-select form-control" id="tplay_title_select_'.$event['event_id'].'" disabled>';
                                                                                                    $data .= '<option value="" selected disabled>Select</option>';
                                                                                                    $data .= '<option value="Sport">Sport</option>';
                                                                                                    $data .= '<option value="Division">Division</option>';
                                                                                                    $data .= '<option value="Non-Division">Non-Division</option>';
                                                                                                    $data .= '<option value="Conference">Conference</option>';
                                                                                                    $data .= '<option value="Non-Conference">Non-Conference</option>';
                                                                                                    $data .= '<option value="Revenge">Revenge</option>';
                                                                                                    $data .= '<option value="Underdog">Underdog</option>';
                                                                                                    $data .= '<option value="False Favorite">False Favorite</option>';
                                                                                                    $data .= '</select>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '<div class="col-md-2 text-center p-t-10 p-l-5 p-r-5">';
                                                                                                    $data .= '<button type="button" id="btn_save_'.$event['event_id'].'" class="btn btn-sm btn-info btn-block m-b-10 display-none btn_save" style="height: fit-content;"><i class="fas fa-save"></i> Save</button>';
                                                                                                    $data .= '<button type="button" id="btn_continue_'.$event['event_id'].'" class="btn btn-sm btn-primary btn-block display-none btn_continue" style="height: fit-content;"><i class="fas fa-play"></i> Continue</button>';
                                                                                                    $data .= '</div>';

                                                                                                    $data .= '</div>';
                                                                                                    $data .= '</div>';
                                                                                                    $data .= '</div>';
                                                                                                    $data .= '</td>';
                                                                                                    $data .= '</tr>';

                                                                                                    ob_flush();
                                                                                                    flush();
                                                                                                    usleep(5);
                                                                                                endforeach;
                                                                                            endif;
                                                                                            $data .= '</tbody>';
                                                                                            $data .= '</table>';
                                                                                            $data .= '</div>';

                                                                                            // $last_date_value = date('Y-m-d', strtotime($event['event_date']));
                                                                                        endif;
                                                                                    endif;
                                                                                else:
                                                                                    break;
                                                                                    $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                                                                endif;
                                                                            endforeach;
                                                                            // $data .= '</div>';
                                                                        endif;
                                                                    endforeach;
                                                                else:
                                                                    break;
                                                                    $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                                                endif;
                                                            else:
                                                                continue;
                                                            endif;

                                                        endforeach;
                                                    else:
                                                        break;
                                                        $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                                    endif;
                                                else:
                                                    continue;
                                                endif;
                                            endforeach;
                                        else:
                                            $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                        endif;
                                    endif;

                                    $data .= '</div>';

                                    if(count($has_event_arr) == 0):
                                        $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                                    endif;
                                endif;
                            endforeach;
                        endforeach;
                    else:
                        $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                    endif;
                else:
                    $data .= '<div class="col-md-12 text-center"><h3>No Sport Data Found!</h3></div>';
                endif;
            endif;

        else:
            abort(404);
        endif;
    }

    public function getRatingNumber(Request $request)
    {
        if($request->ajax()):
            $rating_type = strtolower($request->rating_type ?? "free");
            // $query = $this->mdl_admin->get_data($rating_type, 'ecapper_rating', array('ecapper_id' => $this->session->userdata('SESS_LOGGED_USERID')))->row()->$rating_type;
            $user = Auth::user();
            $query = EcapperRating::where([
                ['ecapper_id', $user->id],
            ])->first()->{$rating_type};
            if($query != 'N/A'):
                $rating_number = [];
                $exploded_rating = explode('-', $query);
                for($i = $exploded_rating[0]; $i <= $exploded_rating[count($exploded_rating) - 1]; $i++):
                    $rating_number[] = (int)$i;
                endfor;
                echo json_encode(array('status_code' => 200, 'status_message' => 'Ok', 'result' => $rating_number));
            else:
                echo json_encode(array('status_code' => 500, 'status_message' => 'Rating not available!'));
            endif;
        else:
            abort(404);
        endif;
    }

    public function saveNewPick(Request $request)
    {
        if($request->ajax()):
            $picks_data = $request->picks_data;
            $data = [];
            $user = Auth::user();
            foreach($picks_data as $pick):
                $pick_title 		= $pick['pick_title'];
                $pick_teaser 		= $pick['pick_teaser'];
                $pick_anaylysis 	= $pick['pick_anaylysis'];
                $sport_id 			= $pick['sport_id'];
                $league_id 			= $pick['league_id'];
                $price 				= $pick['price'];
                $event_id 			= $pick['event_id'];
                $rating_type 		= $pick['rating_type'];
                $rating_number 		= $pick['rating_number'];
                $pitcher 			= ($pick['pitcher'] == '') ? NULL : $pick['pitcher'];
                $tplay_designation 	= ($pick['tplay_designation'] == '') ? NULL : $pick['tplay_designation'];
                $tplay_title 		= ($pick['tplay_title'] == '') ? NULL : $pick['tplay_title'];
                $selected_element 	= $pick['selected_element'];
                $element_value 		= $pick['element_value'];
                $rot_id 			= $pick['rot_id'];
                $side 				= $pick['side'];
                $team_name 			= $pick['team_name'];
                $event_datetime 	= $pick['event_datetime'];
                $ticket_type 		= $pick['ticket_type'];
                $juice 				= $pick['selected_juice'];

                $data[] = [
                    'ecapper_id' 		=> $user->id,
                    'title' 			=> $pick_title,
                    'teaser' 			=> $pick_teaser,
                    'body' 				=> $pick_anaylysis,
                    'created_date' 		=> now(),
                    'price' 			=> $price,
                    'sport' 			=> $sport_id,
                    'league_id' 		=> $league_id,
                    'event_id' 			=> $event_id,
                    'rating_type' 		=> $rating_type,
                    'rating_number' 	=> $rating_number,
                    'pitcher' 			=> $pitcher,
                    'tplay_designation' => $tplay_designation,
                    'tplay_title' 		=> $tplay_title,
                    'selected_element' 	=> $selected_element,
                    'element_value' 	=> $element_value,
                    'rot_id' 			=> $rot_id,
                    'side' 				=> $side,
                    'team_name' 		=> $team_name,
                    'event_datetime' 	=> $event_datetime,
                    'ticket_type' 		=> $ticket_type,
                    'outcome_wl' 		=> 'PENDING',
                    'juice' 			=> $juice,
                    'group_key' 		=> $request->group_key
                ];
            endforeach;

            $inserted = Pick::insert($data);
            if ($inserted):
                echo json_encode(array('status_code' => 200, 'status_message' => 'Pick has been successfully added!.', 'data' => $data));
            else:
                echo json_encode(array('status_code' => 500, 'status_message' => 'Internal Server Error.'));
            endif;
        else:
            abort(404);
        endif;
    }

    public function getRatingType(Request $request)
    {
        if($request->ajax()):
            $user = Auth::user();
            $query_get_rating_types = EcapperRating::where([
                ['ecapper_id', $user->id]
            ])->get();

            $rating_type 			= '<option value="" disabled selected>Select Type</option>';
            if(count($query_get_rating_types) > 0):
                foreach($query_get_rating_types as $rating):
                    if($rating->lean != 'N/A'):
                        $rating_type .= '<option value="LEAN">LEAN</option>';
                    endif;
                    if($rating->reg != 'N/A'):
                        $rating_type .= '<option value="REG">REGULAR</option>';
                    endif;
                    if($rating->strong != 'N/A'):
                        $rating_type .= '<option value="STRONG">STRONG</option>';
                    endif;
                    if($rating->topplay != 'N/A'):
                        $rating_type .= '<option value="TOPPLAY">T-PLAY</option>';
                    endif;
                endforeach;
            endif;

            echo $rating_type;
        else:
            abort(404);
        endif;
    }

}
