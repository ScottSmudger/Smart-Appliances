<?php


$time = time();
echo "for the date: ".date("d-m-Y H:i:s", $time)."<br/>";


echo "<br/><br/>for the hour:<br/>";
$start_hr = strtotime(date("H:00:00", 1489686777));
$end_hr = strtotime(date("H:59:59", 1489686777));

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

