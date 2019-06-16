<?php
 
class GetDatesinRange {
	var $date_1;
	var $date_2;
	public function __construct($a,$b)
	{
		$this->date_1 = $a;
		$this->date_2 = $b;
	}

	function get_date_in_range() {
		$date_1 = $this->date_1;
		$date_2 = $this->date_2;
		$start 	= date("m-d-Y", strtotime($date_1));
		$end 	= date("m-d-Y", strtotime($date_2));
		$diff 	= $this->get_date_diff($date_1, $date_2);
		if( $diff < 16 ) { 
				return get_dates($date_1, $date_2, $diff);
		} 	elseif($diff == 16) { 
				return get_dates($date_1, $date_2, $diff);
		}	elseif($diff % 16 == 0) { 
				return get_dates($date_1, $date_2, $diff);
		} else { 
				$dates = get_dates($date_1, $date_2, $diff);
				return set_dates($dates, $diff);
		}
	}

	//generates date array in range
	function get_dates($date_1, $date_2, $diff) {
		echo $date_1; echo $date_2; echo $diff;
		$dates 		= array();
		$begin 		= new DateTime($date_1);
		$end 		= new DateTime($date_2);
		$mod 		= ( $diff % 16 == 0 && $diff > 16)? $diff/16: 1; 
		$interval 	= DateInterval::createFromDateString($mod.' day');
		$period 	= new DatePeriod($begin, $interval, $end);

		foreach ($period as $dt) {
		    $dates[] = $dt->format("Y-m-d");
		}
		if( $diff<16)
			$dates = merge_array($dates,$diff);
		return $dates;
	}

	//set all dates more than 16
	function set_dates($all_dates, $diff) {
		$dates 		= array();
		$top_dates	= array_slice($all_dates, 0, 5); // too 5 days
		$mid_dates	= array_slice($all_dates, round(($diff/2)), 5 ); //middle 5 dates
		$las_dates	= array_slice($all_dates, -6, 6); //last 6 dates
		$dates 		= array_merge($top_dates,$mid_dates,$las_dates);
		return $dates;
	}

	//return difference in two dates
	public function get_date_diff() {	
		$diff = (strtotime($this->date_2) - strtotime($this->date_1) )/60/60/24;
		return $diff;
	}

}

// $dates = new GetDatesinRange('2019-06-01','2019-06-10');
// $dates = new GetDatesinRange('2019-06-01','2019-06-17');
// $dates = new GetDatesinRange('2019-06-01','2019-07-03');
// $dates = new GetDatesinRange('2019-06-01','2019-08-04');
// $dates = new GetDatesinRange('2019-06-01','2019-08-20');
$dates = new GetDatesinRange('2019-06-01','2019-06-24');
print_r($dates->get_date_in_range());

?>