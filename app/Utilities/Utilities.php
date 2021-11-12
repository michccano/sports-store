<?php
namespace App\Utilities;

use DateTime;
use Exception;

Class Utilities
{
	/**
	 *==========================================================
	 * Convert XML To Array
	 *==========================================================
	 * This function served as the utility for converting xml to array
	 * @param $xml = xml string
	 * @return array
	 */
	public function xml_to_array($xml)
	{
		$json = json_encode($xml);
		return json_decode($json,TRUE);
	}

	/**
	 *==========================================================
	 * Check Array If Sequential
	 *==========================================================
	 * This function served as the utility for checking array if it
	 * is a sequential array
	 * @param $array = array
	 * @return boolean
	 */
	public function is_sequential_array($array)
	{
        $array = json_encode($array);
        $array = json_decode($array, true);
		// Checking for sequential keys of array arr
		if(array_keys($array) !== range(0, count($array) - 1)):
		    return FALSE;
		else:
		    return TRUE;
		endif;
	}

	/**
	 *==========================================================
	 * Arrange Sports Schedule
	 *==========================================================
	 * This function served as the utility for arranging sports schedule
	 * @param $schedule_xml_to_array = converted xml to array string
	 * @param @league_id = string league id
	 * @param @sport_id = string sport id
	 * @return array
	 */
	public function arrange_sports_schedule($schedule_xml_to_array, $league_id, $sport_id)
	{
        // try {
            $array_sched_info 		= array();
            $cnt  					= 0;
            // return [
            //     'set' =>isset($schedule_xml_to_array['schedule']),
            //     'schedule' =>$schedule_xml_to_array['schedule'],
            //     'count' => (count($schedule_xml_to_array['schedule']) > 0)
            // ];
            // dd($schedule_xml_to_array['schedule'][0]);

            if(isset($schedule_xml_to_array['schedule'])):
                if(count($schedule_xml_to_array['schedule']) > 0):
                    $array_sched_info['schedules']['last_update'] = $schedule_xml_to_array['updated'];
                    foreach($schedule_xml_to_array['schedule'] as $sport_key => $sport):
                        $sport = (array)$sport;
                        if(count($sport) > 0):
                            if(isset($sport['@attributes'])):
                                if(isset($sport['@attributes']['id'])):
                                    if((int)$sport['@attributes']['id'] == (int)$sport_id):
                                        $array_sched_info['schedules']['sports'][$sport_key]['sport_id'] = $sport['@attributes']['id'];
                                        $array_sched_info['schedules']['sports'][$sport_key]['sport_name'] = $sport['@attributes']['name'];
                                        if(isset($sport['league'])):
                                            if(count($sport['league']) > 0):
                                                if($this->is_sequential_array($sport['league'])):
                                                    foreach($sport['league'] as $league_key => $league):
                                                        $league = (array)$league;
                                                        if(count($league) > 0):
                                                            if(isset($league['@attributes'])):
                                                                if(isset($league['@attributes']['id'])):
                                                                    if((int)$league['@attributes']['id'] == (int)$league_id):
                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['league_id'] = $league['@attributes']['id'];
                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['league_name'] = $league['@attributes']['name'];
                                                                        if(isset($league['group'])):
                                                                            if($this->is_sequential_array($league['group'])):
                                                                                foreach($league['group'] as $group_key => $group):
                                                                                    $group = (array)$group;
                                                                                    if(count($group) > 0):
                                                                                        if(isset($group['@attributes'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['group_id'] 	= $group['@attributes']['id'];
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['group_name'] 	= $group['@attributes']['name'];
                                                                                            if(isset($group['event'])):
                                                                                                // Need to check on this
                                                                                                if($this->is_sequential_array($group['event'])):
                                                                                                    foreach($group['event'] as $event_key => $event):
                                                                                                        $event = (array)$event;
                                                                                                        if(isset($event['event_type']) AND strtoupper($event['event_type']) != 'PROPOSITION'):
                                                                                                            if(isset($event['@attributes'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_id'] 	= $event['@attributes']['id'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_season'] = $event['@attributes']['season'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_date'] 	= $event['@attributes']['date'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_name'] 	= $event['@attributes']['name'];
                                                                                                            endif;

                                                                                                            if(isset($event['event_type'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_type'] = $event['event_type'];
                                                                                                            endif;

                                                                                                            if(isset($event['event_state'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_state'] = $event['event_state'];
                                                                                                            endif;

                                                                                                            if(isset($event['event_state_id'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_state_id'] = $event['event_state_id'];
                                                                                                            endif;

                                                                                                            if(isset($event['time_changed'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_time_changed'] = $event['time_changed'];
                                                                                                            endif;

                                                                                                            if(isset($event['$event'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_neutral'] = $event['neutral'];
                                                                                                            endif;

                                                                                                            if(isset($event['game_number'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_game_number'] = $event['game_number'];
                                                                                                            endif;

                                                                                                            if(isset($event['location'])):
                                                                                                                if(isset($event['location']['@attributes'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_location_id'] = $event['location']['@attributes']['id'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_location_name'] = $event['location']['@attributes']['name'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_location_link'] = $event['location']['@attributes']['link'];
                                                                                                                endif;
                                                                                                            endif;

                                                                                                            if(isset($event['participant'])):
                                                                                                                foreach($event['participant'] as $participant_key => $participant):
                                                                                                                    $participant = (array)$participant;
                                                                                                                    if(isset($participant['@attributes'])):
                                                                                                                        if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                            if(isset($participant['@attributes']['name'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;

                                                                                                                    if(count($event['participant']) > 0):
                                                                                                                        if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                            if(isset($participant['team'])):

                                                                                                                                $participant_team = (array)$participant['team'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_id'] = $participant_team['@attributes']['id'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant_team['@attributes']['name'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_link'] = $participant_team['@attributes']['link'];
                                                                                                                            endif;

                                                                                                                            if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                                if(isset($participant['pitcherChanged'])):
                                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                                endif;
                                                                                                                                if(isset($participant['pitcher'])):
                                                                                                                                    if(isset($participant['pitcher']['@value'])):
                                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                                    endif;

                                                                                                                                    if(isset($participant['pitcher']['@attributes'])):
                                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                                    endif;

                                                                                                                                endif;

                                                                                                                            endif;

                                                                                                                        endif;

                                                                                                                    endif;

                                                                                                                endforeach;

                                                                                                            endif;

                                                                                                        endif;
                                                                                                    endforeach;
                                                                                                else:
                                                                                                    $group_event = (array)$group['event'];
                                                                                                    if(isset($group_event['event_type']) AND strtoupper($group_event['event_type']) != 'PROPOSITION'):
                                                                                                        if(isset($group_event['attributes'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_id'] 	= $group['event']['@attributes']['id'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_season'] = $group['event']['@attributes']['season'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_date'] 	= $group['event']['@attributes']['date'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_name'] 	= $group['event']['@attributes']['name'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['event_type'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_type'] = $group['event']['event_type'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['event_state'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_state'] = $group['event']['event_state'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['event_state_id'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_state_id'] = $group['event']['event_state_id'];
                                                                                                        endif;

                                                                                                        if($group_event['time_changed']):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_time_changed'] = $group['event']['time_changed'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['neutral'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_neutral'] = $group['event']['neutral'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['game_number'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_game_number'] = $group['event']['game_number'];
                                                                                                        endif;

                                                                                                        if(isset($group_event['location'])):
                                                                                                            if(isset($group_event['location']['@attributes'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_location_id'] = $group['event']['location']['@attributes']['id'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_location_name'] = $group['event']['location']['@attributes']['name'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_location_link'] = $group['event']['location']['@attributes']['link'];
                                                                                                            endif;
                                                                                                        endif;

                                                                                                        if(isset($group_event['participant'])):
                                                                                                            foreach($group_event['participant'] as $participant_key => $participant):
                                                                                                                $participant = (array)$participant;
                                                                                                                if(isset($participant['@attributes'])):
                                                                                                                    if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                        if(isset($participant['@attributes']['name'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;

                                                                                                                if(count($group_event['participant']) > 0):
                                                                                                                    if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                        if(isset($participant['team'])):
                                                                                                                            $participant_team = (array)$participant['team'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_id'] = $participant_team['@attributes']['id'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant_team['@attributes']['name'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_link'] = $participant_team['@attributes']['link'];
                                                                                                                        endif;

                                                                                                                        if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                            if(isset($participant['pitcherChanged'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                            endif;

                                                                                                                            if(isset($participant['pitcher'])):
                                                                                                                                if(isset($participant['pitcher']['@value'])):
                                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                                endif;

                                                                                                                                if(isset($participant['pitcher']['@attributes'])):
                                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                                endif;
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endforeach;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                endif;
                                                                                            endif;
                                                                                        endif;
                                                                                    endif;
                                                                                endforeach;
                                                                            else:
                                                                                if(isset($league['group']['@attributes'])):
                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['group_id'] 	= $league['group']['@attributes']['id'];
                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['group_name'] 	= $league['group']['@attributes']['name'];
                                                                                    if(isset($league['group']['event'])):
                                                                                        if($this->is_sequential_array($league['group']['event'])):
                                                                                            foreach($league['group']['event'] as $event_key => $event):
                                                                                                $event = (array)$event;
                                                                                                if(isset($event['event_type']) AND strtoupper($event['event_type']) != 'PROPOSITION'):
                                                                                                    if(isset($event['attributes'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_id'] 	= $event['@attributes']['id'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_season'] = $event['@attributes']['season'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_date'] 	= $event['@attributes']['date'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_name'] 	= $event['@attributes']['name'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_type'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_type'] = $event['event_type'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_state'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_state'] = $event['event_state'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_state_id'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_state_id'] = $event['event_state_id'];
                                                                                                    endif;
                                                                                                    if(isset($event['time_changed'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_time_changed'] = $event['time_changed'];
                                                                                                    endif;

                                                                                                    if(isset($event['neutral'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_neutral'] = $event['neutral'];
                                                                                                    endif;

                                                                                                    if(isset($event['game_number'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_game_number'] = $event['game_number'];
                                                                                                    endif;

                                                                                                    if(isset($event['location'])):
                                                                                                        if(isset($event['location']['@attributes'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_location_id'] = $event['location']['@attributes']['id'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_location_name'] = $event['location']['@attributes']['name'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_location_link'] = $event['location']['@attributes']['link'];
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(isset($event['participant'])):
                                                                                                        foreach($event['participant'] as $participant_key => $participant):
                                                                                                            $participant = (array)$participant;
                                                                                                            if(isset($participant['@attributes'])):
                                                                                                                if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                    if(isset($participant['@attributes']['name'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;

                                                                                                            if(count($event['participant']) > 0):
                                                                                                                if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                    if(isset($participant['team'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                                    endif;

                                                                                                                    if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                        if(isset($participant['pitcherChanged'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                        endif;
                                                                                                                        if(isset($participant['pitcher'])):
                                                                                                                            if(isset($participant['pitcher']['@value'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                            endif;
                                                                                                                            if(isset($participant['pitcher']['@attributes'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endforeach;
                                                                                                    endif;
                                                                                                endif;
                                                                                            endforeach;
                                                                                        else:
                                                                                            if(isset($league['group']['event']['event_type']) AND strtoupper($league['group']['event']['event_type']) != 'PROPOSITION'):
                                                                                                if(isset($league['group']['event']['@attributes'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_id'] 	= $league['group']['event']['@attributes']['id'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_season'] = $league['group']['event']['@attributes']['season'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_date'] 	= $league['group']['event']['@attributes']['date'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_name'] 	= $league['group']['event']['@attributes']['name'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['event_type'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_type'] = $league['group']['event']['event_type'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['event_state'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_state'] = $league['group']['event']['event_state'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['event_state_id'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_state_id'] = $league['group']['event']['event_state_id'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['time_changed'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_time_changed'] = $league['group']['event']['time_changed'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['neutral'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_neutral'] = $league['group']['event']['neutral'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['game_number'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_game_number'] = $league['group']['event']['game_number'];
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['location'])):
                                                                                                    if(isset($league['group']['event']['location']['@attributes'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_location_id'] = $league['group']['event']['location']['@attributes']['id'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_location_name'] = $league['group']['event']['location']['@attributes']['name'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_location_link'] = $league['group']['event']['location']['@attributes']['link'];
                                                                                                    endif;
                                                                                                endif;

                                                                                                if(isset($league['group']['event']['participant'])):
                                                                                                    foreach($league['group']['event']['participant'] as $participant_key => $participant):
                                                                                                        $participant = (array)$participant;
                                                                                                        if(isset($participant['@attributes'])):
                                                                                                            if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                if(isset($participant['@attributes']['name'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;

                                                                                                        if(count($league['group']['event']['participant']) > 0):
                                                                                                            if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                if(isset($participant['team'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                                endif;
                                                                                                                if((int)$sport_id == 3 AND (int)$league_id == 5):

                                                                                                                    if(isset($participant['pitcherChanged'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                    endif;

                                                                                                                    if(isset($participant['pitcher'])):
                                                                                                                        if(isset($participant['pitcher']['@value'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                        endif;

                                                                                                                        if(isset($participant['pitcher']['@attributes'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
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
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    if(isset($sport['league']['@attributes'])):
                                                        if(isset($sport['league']['@attributes']['id'])):
                                                            if((int)$sport['league']['@attributes']['id'] == (int)$league_id):
                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['league_id'] = $sport['league']['@attributes']['id'];
                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['league_name'] = $sport['league']['@attributes']['name'];
                                                                if(isset($sport['league']['group'])):
                                                                    if($this->is_sequential_array($sport['league']['group'])):
                                                                        foreach($sport['league']['group'] as $group_key => $group):
                                                                            $group = (array)$group;
                                                                            if(count($group) > 0):
                                                                                if(isset($group['@attributes'])):
                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['group_id'] 	= $group['@attributes']['id'];
                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['group_name'] 	= $group['@attributes']['name'];
                                                                                    if(isset($group['event'])):
                                                                                        if($this->is_sequential_array($group['event'])):
                                                                                            foreach($group['event'] as $event_key => $event):
                                                                                                if(isset($event['event_type']) AND strtoupper($event['event_type']) != 'PROPOSITION'):
                                                                                                    if(isset($event['@attributes'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_id'] 	= $event['@attributes']['id'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_season'] = $event['@attributes']['season'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_date'] 	= $event['@attributes']['date'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_name'] 	= $event['@attributes']['name'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_type'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_type'] = $event['event_type'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_state'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_state'] = $event['event_state'];
                                                                                                    endif;

                                                                                                    if(isset($event['event_state_id'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_state_id'] = $event['event_state_id'];
                                                                                                    endif;

                                                                                                    if(isset($event['time_changed'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_time_changed'] = $event['time_changed'];
                                                                                                    endif;

                                                                                                    if(isset($event['neutral'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_neutral'] = $event['neutral'];
                                                                                                    endif;

                                                                                                    if(isset($event['game_number'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_game_number'] = $event['game_number'];
                                                                                                    endif;

                                                                                                    if(isset($event['location'])):
                                                                                                        if(isset($event['location']['@attributes'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_location_id'] = $event['location']['@attributes']['id'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_location_name'] = $event['location']['@attributes']['name'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_location_link'] = $event['location']['@attributes']['link'];
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(isset($event['participant'])):
                                                                                                        foreach($event['participant'] as $participant_key => $participant):
                                                                                                            $participant = (array)$participant;
                                                                                                            if(isset($participant['@attributes'])):
                                                                                                                if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                    if(isset($participant['@attributes']['name'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;

                                                                                                            if(count($event['participant']) > 0):
                                                                                                                if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                    if(isset($participant['team'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                                    endif;

                                                                                                                    if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                        if(isset($participant['pitcherChanged'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                        endif;
                                                                                                                        if(isset($participant['pitcher'])):
                                                                                                                            if(isset($participant['pitcher']['@value'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                            endif;
                                                                                                                            if(isset($participant['pitcher']['@attributes'])):
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                            endif;
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endforeach;
                                                                                                    endif;
                                                                                                endif;
                                                                                            endforeach;
                                                                                        else:
                                                                                            if(isset($$group['event']['event_type']) AND strtoupper($group['event']['event_type']) != 'PROPOSITION'):
                                                                                                if(isset($group['event']['@attributes'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_id'] 	= $group['event']['@attributes']['id'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_season'] = $group['event']['@attributes']['season'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_date'] 	= $group['event']['@attributes']['date'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_name'] 	= $group['event']['@attributes']['name'];
                                                                                                endif;

                                                                                                if(isset($group['event']['event_type'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_type'] = $group['event']['event_type'];
                                                                                                endif;

                                                                                                if(isset($$group['event']['event_state'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_state'] = $group['event']['event_state'];
                                                                                                endif;

                                                                                                if(isset($group['event']['event_state_id'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_state_id'] = $group['event']['event_state_id'];
                                                                                                endif;

                                                                                                if(isset($group['event']['time_changed'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_time_changed'] = $group['event']['time_changed'];
                                                                                                endif;

                                                                                                if(isset($group['event']['neutral'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_neutral'] = $group['event']['neutral'];
                                                                                                endif;

                                                                                                if(isset($group['event']['game_number'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_game_number'] = $group['event']['game_number'];
                                                                                                endif;

                                                                                                if(isset($group['event']['location'])):
                                                                                                    if(isset($group['event']['location']['@attributes'])):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_location_id'] = $group['event']['location']['@attributes']['id'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_location_name'] = $group['event']['location']['@attributes']['name'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_location_link'] = $group['event']['location']['@attributes']['link'];
                                                                                                    endif;
                                                                                                endif;

                                                                                                if(isset($group['event']['participant'])):
                                                                                                    foreach($group['event']['participant'] as $participant_key => $participant):
                                                                                                        $participant = (array)$participant;
                                                                                                        if(isset($participant['@attributes'])):
                                                                                                            if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                                if(isset($participant['@attributes']['name'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                        if(count($group['event']['participant']) > 0):
                                                                                                            if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                                if(isset($participant['team'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                                endif;

                                                                                                                if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                    if(isset($participant['pitcherChanged'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                    endif;
                                                                                                                    if(isset($participant['pitcher'])):
                                                                                                                        if(isset($participant['pitcher']['@value'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                        endif;
                                                                                                                        if(isset($participant['pitcher']['@attributes'])):
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][$group_key]['events'][0]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                        endif;
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endforeach;
                                                                                                endif;
                                                                                            endif;
                                                                                        endif;
                                                                                    endif;
                                                                                endif;
                                                                            endif;
                                                                        endforeach;
                                                                    else:
                                                                        if(isset($sport['league']['group']['@attributes'])):
                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['group_id'] 	= $sport['league']['group']['@attributes']['id'];
                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['group_name'] 	= $sport['league']['group']['@attributes']['name'];
                                                                            if(isset($$sport['league']['group']['event'])):
                                                                                if($this->is_sequential_array($sport['league']['group']['event'])):
                                                                                    foreach($sport['league']['group']['event'] as $event_key => $event):
                                                                                        $event = (array)$event;
                                                                                        if(isset($event['event_type']) AND strtoupper($event['event_type']) != 'PROPOSITION'):
                                                                                            if(isset($event['@attributes'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_id'] 	= $event['@attributes']['id'];
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_season'] = $event['@attributes']['season'];
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_date'] 	= $event['@attributes']['date'];
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_name'] 	= $event['@attributes']['name'];
                                                                                            endif;

                                                                                            if(isset($event['event_type'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_type'] = $event['event_type'];
                                                                                            endif;

                                                                                            if(isset($event['event_state'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_state'] = $event['event_state'];
                                                                                            endif;

                                                                                            if(isset($event_state_id['event_state_id'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_state_id'] = $event['event_state_id'];
                                                                                            endif;

                                                                                            if(isset($event['time_changed'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_time_changed'] = $event['time_changed'];
                                                                                            endif;

                                                                                            if(isset($event['neutral'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_neutral'] = $event['neutral'];
                                                                                            endif;

                                                                                            if(isset($event['game_number'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_game_number'] = $event['game_number'];
                                                                                            endif;

                                                                                            if(isset($event['location'])):
                                                                                                if(isset($$event['location']['@attributes'])):
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_location_id'] = $event['location']['@attributes']['id'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_location_name'] = $event['location']['@attributes']['name'];
                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_location_link'] = $event['location']['@attributes']['link'];
                                                                                                endif;
                                                                                            endif;

                                                                                            if(isset($event['participant'])):
                                                                                                foreach($event['participant'] as $participant_key => $participant):
                                                                                                    $participant = (array)$participant;
                                                                                                    if(isset($participant['@attributes'])):
                                                                                                        if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                            if(isset($participant['@attributes']['name'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;

                                                                                                    if(count($event['participant']) > 0):
                                                                                                        if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                            if(isset($participant['team'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                            endif;

                                                                                                            if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                                if(isset($participant['pitcherChanged'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][$league_key]['groups'][$group_key]['events'][$event_key]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                                endif;

                                                                                                                if(isset($participant['pitcher'])):
                                                                                                                    if(isset($$participant['pitcher']['@value'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                    endif;
                                                                                                                    if(isset($participant['pitcher']['@attributes'])):
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][$event_key]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                    endif;
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
                                                                                                    endif;
                                                                                                endforeach;
                                                                                            endif;
                                                                                        endif;
                                                                                    endforeach;
                                                                                else:
                                                                                    if(isset($sport['league']['group']['event']['event_type']) AND strtoupper($sport['league']['group']['event']['event_type']) != 'PROPOSITION'):
                                                                                        if(isset($sport['league']['group']['event']['@attributes'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_id'] 	= $sport['league']['group']['event']['@attributes']['id'];
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_season'] = $sport['league']['group']['event']['@attributes']['season'];
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_date'] 	= $sport['league']['group']['event']['@attributes']['date'];
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_name'] 	= $sport['league']['group']['event']['@attributes']['name'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['event_type'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_type'] = $sport['league']['group']['event']['event_type'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['event_state'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_state'] = $sport['league']['group']['event']['event_state'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['event_state_id'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_state_id'] = $sport['league']['group']['event']['event_state_id'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['time_changed'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_time_changed'] = $sport['league']['group']['event']['time_changed'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['neutral'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_neutral'] = $sport['league']['group']['event']['neutral'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['game_number'])):
                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_game_number'] = $sport['league']['group']['event']['game_number'];
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['location'])):
                                                                                            if(isset($sport['league']['group']['event']['location']['@attributes'])):
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_location_id'] = $sport['league']['group']['event']['location']['@attributes']['id'];
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_location_name'] = $sport['league']['group']['event']['location']['@attributes']['name'];
                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_location_link'] = $sport['league']['group']['event']['location']['@attributes']['link'];
                                                                                            endif;
                                                                                        endif;

                                                                                        if(isset($sport['league']['group']['event']['participant'])):
                                                                                            foreach($sport['league']['group']['event']['participant'] as $participant_key => $participant):
                                                                                                $participant = (array)$participant;
                                                                                                if(isset($participant['@attributes'])):
                                                                                                    if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['rot'] = $participant['@attributes']['rot'];
                                                                                                        $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['side'] = $participant['@attributes']['side'];
                                                                                                        if(isset($participant['@attributes']['name'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['@attributes']['name'];
                                                                                                        endif;
                                                                                                    endif;
                                                                                                endif;

                                                                                                if(count($sport['league']['group']['event']['participant']) > 0):
                                                                                                    if(strtoupper($participant['@attributes']['side']) == 'HOME' OR strtoupper($participant['@attributes']['side']) == 'AWAY'):
                                                                                                        if(isset($participant['team'])):
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_id'] = $participant['team']['@attributes']['id'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_name'] = $participant['team']['@attributes']['name'];
                                                                                                            $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['team_link'] = $participant['team']['@attributes']['link'];
                                                                                                        endif;
                                                                                                        if((int)$sport_id == 3 AND (int)$league_id == 5):
                                                                                                            if(isset($participant['pitcherChanged'])):
                                                                                                                $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_changed'] = $participant['pitcherChanged'];
                                                                                                            endif;
                                                                                                            if(isset($participant['pitcher'])):
                                                                                                                if(isset($participant['pitcher']['@value'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_name'] = $participant['pitcher']['@value'];
                                                                                                                endif;
                                                                                                                if(isset($participant['pitcher']['@attributes'])):
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_hand'] = $participant['pitcher']['@attributes']['hand'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_id'] = $participant['pitcher']['@attributes']['id'];
                                                                                                                    $array_sched_info['schedules']['sports'][$sport_key]['leagues'][0]['groups'][0]['events'][0]['event_participant'][$participant_key]['pitcher_full_name'] = $participant['pitcher']['@attributes']['full_name'];
                                                                                                                endif;
                                                                                                            endif;
                                                                                                        endif;
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
                                                    endif;
                                                endif;
                                            endif;
                                        endif;
                                    endif;
                                endif;
                            endif;
                        endif;
                    endforeach;
                endif;
            endif;
        return $array_sched_info;
	}

	/**
	 *==========================================================
	 * Validate Date Function
	 *==========================================================
	 * This function served as the utility for validating given date if valid
	 * @param $date = date string
	 * @param @league_id = date format string
	 * @return bool
	 */
	function validateDate($date, $format)
	{
	    $d = DateTime::createFromFormat($format, $date);
	    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	    return $d && $d->format($format) === $date;
	}

	/**
	 *==========================================================
	 * Curl Get Request Function
	 *==========================================================
	 * This function served as the utility for get curl request from specific resource
	 * @param $url = string
	 * @param @headers = array
	 * @return request body if success else false
	 */
	public function curl_get_request($url, $headers = array())
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        // Then, after your curl_exec call:

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        if(!$response):
            return FALSE;
        else:
        	if($httpCode == 200):
                return $body;
            else:
                return FALSE;
            endif;
       	endif;

	}

	/**
	 *==========================================================
	 * API Request Function
	 *==========================================================
	 * This function served as the utility for getting data from the specific api
	 * @param $url = string
	 * @param @headers = array
	 * @param @request_method = string
	 * @return request body if success else false
	 */
	public function api_request($url, $headers = array(), $request_method = 'GET', $post_fields = array())
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if(strtoupper($request_method) == 'GET'):
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        elseif(strtoupper($request_method) == 'POST'):
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        elseif(strtoupper($request_method) == 'PUT'):
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        elseif(strtoupper($request_method) == 'DELETE'):
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        endif;
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        // Then, after your curl_exec call:

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        if(!$response):
            return FALSE;
        else:
        	if($httpCode == 200):
                return $body;
            else:
                return FALSE;
            endif;
       	endif;

	}
}
