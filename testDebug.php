
<?php
// Create an array with 5 random values of 0 and 1
$a = array_map(fn() => rand(0, 1), range(1, 5));

// Create another array with 5 random values under 100
$b = array_map(fn() => rand(0, 99), range(1, 5));

echo "Array A: " . implode(", ", $a) . PHP_EOL;
echo "Array B: " . implode(", ", $b) . PHP_EOL;

// Iterate over the length of the first array
for ($i = 0; $i < count($a); $i++) {
    if ($a[$i] == 1) {
        echo "b[$i] * 2 = " . ($b[$i] * 2) . PHP_EOL;
    } else {
        echo "b[$i] * 4 = " . ($b[$i] * 4) . PHP_EOL;
    }
}
?>
