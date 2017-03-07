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
