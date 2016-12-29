<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
Constants: http://php.net/manual/en/language.constants.syntax.php<br/>
Magic Constants: http://php.net/manual/en/language.constants.predefined.php<br/>
Expressions: http://php.net/manual/en/language.expressions.php<br/>
Operators: http://php.net/manual/en/language.operators.arithmetic.php and http://php.net/manual/en/language.operators.logical.php<br/>
Control Structures: http://php.net/manual/en/language.control-structures.php<br/>
Functions: http://php.net/manual/en/functions.user-defined.php<br/><br/>

<?php
echo "-----------------------------------<br/>";
echo "Start of Tests<br/>";
echo "-----------------------------------<br/>";
// Constants
echo "Constants:<br/>";
define("TEST", "This is a constant<br/>");
const ANOTHER_TEST = "This is another constant";
echo TEST;
echo ANOTHER_TEST;

// Magic Constants
echo "<br/><br/>Magic Constants:<br/>";
echo "This line is line #".__LINE__;
echo "<br/>This files path is: ".__FILE__;
echo "<br/>This files dir is: ".__DIR__;
echo "<br/>Can also use: __FUNCTION__, __CLASS__, __TRAIT__, __METHOD__ and __NAMESPACE__";

// Expressions
echo "<br/><br/>Expressions in PHP are described as anything that has a value. Many of PHP's builtin functions return values, thus being an expression.<br/>
It's also possible to create your own by declaring a function that returns a value. An expression needs to return a value.";

// Operators
echo "<br/><br/>Logical Operators:<br/>";
echo false and true; // False
echo true or false; // True
echo !false; // True
echo true xor false; // False
// Outputs: 111
echo "<br/><br/>Arithmetic Operators:<br/>";
$a = 12;
$b = 2;
echo "Addition: ".($a + $b)."<br/>";
echo "Subtratction: ".($a - $b)."<br/>";
echo "Multiplication: ".$a * $b."<br/>";
echo "Division: ".$a / $b."<br/>";
echo "Exponentiation: ".$a ** $b;

// Control Structures
echo "<br/><br/>Control Structures:<br/>";
if(true)
{
	echo "true";
}
else
{
	echo "false";
}
echo "<br/>";
$i = 1;
while($i <= 5)
{
	echo $i++;
}
echo "<br/>";
for ($i = 1; $i <= 5; $i++)
{
    echo $i;
}
echo "<br/>";
$arr = array(1, 2, 3, 4, 5);
foreach($arr as $number)
{
	echo $number;
}
echo "<br/>";
$rand = rand(1, 3);
switch($rand)
{
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
    case 3:
        echo "i equals 3";
        break;
}
echo "<br/>";
function func(){return 5;}
$retval = func();
echo $retval;

// Functions
echo "<br/><br/>Functions:<br/>";
function exg()
{
	echo "Example func<br/>";
}
exg();
function exg_arg($number)
{
	echo "$number squared = ".$number ** 2;
}
exg_arg($rand);


?>
