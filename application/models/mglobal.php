<?php
class Mglobal extends CI_Model {

	function Mglobal(){
		parent::__construct();
	}
	
	function showData( $data, $tbl, $where, $db, $like = "" )
        {    
                $dblokal  = $this->load->database("default", TRUE);
                
                ${$db}->where($where);
                if($like <> "") ${$db}->like($like);
		$query = ${$db}->get($tbl);
                $val=1;
                if($val == 0){
                        return "";
                }else{
                        if($query->num_rows() > 0) {
                                $r = $query->row();
                                return $r->{$data};
                        } else {
                                return "";
                        }       
                }
	}
	
	function week_start_date($wk_num, $yr, $first = 0, $format = 'F d, Y') 
	{ 
		$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101')); 
		$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts); 
		return date($format, $mon_ts);
	}
	
	function getDays($week,$year){
		$sStartDate = $this->week_start_date($week-1, $year); 
		$sEndDate   = date('F d, Y', strtotime('+6 days', strtotime($sStartDate)));
		return $sStartDate . " - ". $sEndDate;
	}
	
}