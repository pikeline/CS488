<?
// Notice: nothing above the opening PHP tag just above. Even a blank line above that would count as HTML output.

// Some PHP basics

$x = 'Hello';

// Variables are evaluated inside double quoted strings, but NOT in single quoted strings.
echo "$x, how are you today?" . "<br>";
echo '$x, how are you today?' . "<br>";

// contatenation is .    (objects use obj->property)

// PHP is loosely typed
$y = 1;
$z = true;

// Variables put into "Boolean Context" are evaluated within that context
//    0 and "" (empty string) evaluate to false
//    non-zero numbers and non-empty strings evaluate to true
if ($x) {
  echo "'Hello' is true in Boolean Context.<br>";
}

if ($y) {
  echo "1 is true in Boolean Context.<br>";
}

// Standard Array
$array = ['cat','dog'];

foreach ($array as $value) {
  echo "$value<br>";
}

// Associative Array
$assoc_array = [  'cat' => 'meow',
                  'dog' => 'bark',
                  'worm' => '??'
];

foreach ($assoc_array as $key => $value) {
  echo "Key: $key => Value: $value.<br>";
}

/*
Any code outside the php tags (<? ... ?>) is raw html returned to the browser.
See comment at very top too.

Technically, full PHP tags are <?php ... ?>.  But our server is configured to allow "Short PHP tags".
*/

?>

<br>
<b>Raw HTML</b>



