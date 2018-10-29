<?php 


	function format_date($date) {

		
		$date = new DateTime($date);

		return $date->format("jS M Y");



	}



	function number_of_days($start, $end) {


				$start_date = new DateTime($start);

				$end_date = new DateTime($end);


				$difference = $start_date->diff($end_date);

				return $difference->d;




	}

	function format_time_stamp($timestamp) {

			$timestamp = (int) $timestamp;

			$date = new DateTime;


			$date->setTimestamp($timestamp);

			return $date->format("jS M Y");

				



	}