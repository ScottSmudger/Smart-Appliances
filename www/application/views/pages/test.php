<?php


$time = time();
echo "for the date: ".date("d-m-Y H:i:s", $time)."<br/>";


echo "for the day:<br/>";
$start_day = strtotime("midnight", $time);
$end_day = strtotime("tomorrow", $start_day) - 1;

var_dump(
	array(
		"beginning" => $start_day,
		"end" => $end_day
	)
);



echo "<br/><br/>for the hour:<br/>";
$start_hr = strtotime(date("H:00:00"));
$end_hr = strtotime(date("H:59:59"));

var_dump(
	array(
		"beginning" => $start_hr,
		"end" => $end_hr
	)
);

/*function average_hour() {
	H = Hour;
	SELECT * FROM TABLE WHERE HOUR = HOUR_NEEDED
	save into array for hour
	
	$count = 0;
	$total = 0;
	$average = 0;
	foreach ($time in array) {
		$total = $total + $time;
		$count++;
	}
	$average = $total / $count;
	
}

to work out the whole day we want:

function average_day(){

	for (H = 0; H = 17; H++){
		average_hour(H);
		save into array for day
	}

}

function saving_week(){
	
	for(d=0; d=6; d++)
		average_day();
		save into array week array
}


}
	*/