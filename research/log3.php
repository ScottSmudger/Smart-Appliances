<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
More on Functions: http://php.net/manual/en/functions.arguments.php and http://php.net/manual/en/functions.returning-values.php and http://php.net/manual/en/functions.variable-functions.php<br/>
Which lead to references: http://php.net/manual/en/language.references.php<br/>
Started classes and Objects: http://php.net/manual/en/language.oop5.php and http://php.net/manual/en/language.oop5.basic.php<br/>
Class properties: http://php.net/manual/en/language.oop5.properties.php<br/>
Class constants: http://php.net/manual/en/language.oop5.constants.php<br/>
Autoloading Classes: http://php.net/manual/en/language.oop5.autoload.php<br/>
Constructors and Destructors: http://php.net/manual/en/language.oop5.decon.php<br/>
Object Inheritance: http://php.net/manual/en/language.oop5.inheritance.php

<br/><br/>

<?php
echo "-----------------------------------<br/>";
echo "Start of Tests<br/>";
echo "-----------------------------------<br/>";
// More on functions
echo "More on functions:<br/>";
function square($number)
{
	echo $number ** 2;
}
square(4);
function sandwich($filling = "ham")
{
	echo "<br/>I will have $filling on my sandwich.";
}
sandwich();
sandwich("chicken");
echo "<br/>";
function cube($number)
{
	return $number ** 3;
}
echo cube(4);
function foo()
{
	echo "<br/>foo()<br/>";
}
$var = "foo";
$var();
// Classes
echo "Classes and Objects:<br/>";
echo "Properties:<br/>";
class foo {public $bar = "This is a property<br/>";}
$obj = new foo();
echo $obj->bar;
echo "Constants:<br/>";
class bar {const BAZ = "This is a constant<br/>";}
$obj = new bar();
echo $obj::BAZ;
// Autoloading Classes
echo "Autoloading Classes:<br/>";
spl_autoload_register(function ($class) {
    echo "Want to load $class.\n";
    throw new Exception("Unable to load: $class.");
});
try {
    $obj = new ANewClass();
} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}
// Constructors and Destructors
echo "<br/>Constructors and Destructors:<br/>";
class classExg
{
	private $variable;
	
	function __construct()
	{
		echo "setting variable to test";
		$this->variable = "testclass";
	}
	
	function __destruct()
	{
		echo "<br/>destroying ".$this->variable;
		$this->variable = null;
	}
}
$obj = new classExg();
// Object Inheritance
echo "<br/>Object Inheritance:<br/>";
class Father {
	public function son()
	{
		echo "son";
	}
}
class Son extends Father {
	public function father()
	{
		echo "My father is: ".get_parent_class();
	}
}
$bar = new Son();
$bar->father();

?>
