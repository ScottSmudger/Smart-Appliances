<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
Variable Basics: http://php.net/manual/en/language.variables.basics.php<br/>
Predefined Variables: http://php.net/manual/en/language.variables.predefined.php<br/>
Variable Scopes: http://php.net/manual/en/language.variables.scope.php<br/><br/>
Arrays: http://php.net/manual/en/language.types.array.php

<?php
echo "-----------------------------------<br/>";
echo "Start of Tests<br/>";
echo "-----------------------------------<br/>";
//Variables
echo "Variables:<br/>";
$var1 = 5;
$var2 = 10;
echo $var1 + $var2;

echo "<br/>";

$str1 = "Group 11";
$str1 .= " is awesome";
echo $str1;

// Indexed Arrays
echo "<br/><br/>Indexed Arrays:<br/>";
$array = array(0 => "index1", 1 => "index2");
var_dump($array);

// Associative Arrays
echo "<br/><br/>Associative Arrays:<br/>";
$assoc = array("g11" => "Group 11");
$assoc["test"] = "a test";
var_dump($assoc);

// Predefined Variables
echo "<br/><br/>Predefined Variables:<br/>";
echo "GLOBALS :$GLOBALS<br/>";
echo "_GET :$_GET<br/>";
echo "_POST :$_POST<br/>";
echo "_SERVER :$_SERVER<br/>";

// Scopes
function test()
{
	global $assoc;
	
	echo "test() = ";
	var_dump($assoc);
}
test();

?>
