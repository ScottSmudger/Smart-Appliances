<?php


$time = time();
echo "for the date: ".date("d-m-Y H:i:s", $time)."<br/>";


echo "for the week:<br/>";
$start_week = strtotime("last sunday");
$end_week = strtotime("next saturday") + 86399;

var_dump(
	array(
		"beginning" => $start_week,
		"end" => $end_week
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


echo "<br/><br/>for the day:<br/>";
$min_value = strtotime("midnight");
$max_value = strtotime("tomorrow", time()) - 1;
var_dump(
	array(
		"beginning" => $min_value,
		"end" => $max_value
	)
);

echo "<br/><br/>for the week:<br/>";
$min_value = strtotime("-1 week");
$max_value = strtotime("tomorrow", time()) - 1;
var_dump(
	array(
		"beginning" => $min_value,
		"end" => $max_value
	)
);

echo "<br/><br/>for the month:<br/>";
$min_value = strtotime("-1 month");
$max_value = strtotime("tomorrow", time()) - 1;
var_dump(
	array(
		"beginning" => $min_value,
		"end" => $max_value
	)
);

echo "<br/><br/>for the year:<br/>";
$min_value = strtotime("-1 year");
$max_value = strtotime("tomorrow", time()) - 1;
var_dump(
	array(
		"beginning" => $min_value,
		"end" => $max_value
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