<?php

function solution($numbers) {
    $n = count($numbers);
    // Check array length
    if ($n < 1 || $n > 100000) {
        throw new Exception("Array length from 1 to 100000");
    }

    // Check min, max item
    if (min($numbers) < -1000000 || max($numbers) > 1000000) {
        throw new Exception("Items in array from -1000000 to 1000000");
    }

    if (count(array_unique($numbers)) !== count($numbers)) {
        throw new Exception("Has duplicate item in array");
    }
    
    // Get power of 2 less
    // Because max item is 1000000, so max power is 2^20
    $powerOfTwo = [];
    for ($i = 0; $i <= 20; $i++) {
        $powerOfTwo[] = pow(2, $i);
    }
    $count = 0;
    
    // Use hash table
    $numSet = array_flip($numbers);

    foreach ($numbers as $i => $num) {
        foreach ($powerOfTwo as $target) {
            $complement = $target - $num;

            if (isset($numSet[$complement])) {
                if ($complement == $num) {
                    $count++;
                } elseif ($numSet[$complement] > $i) {
                    $count++;
                }
            }
        }
    }
    
    return $count;
}

function createUniqueArray($length, $min, $max) {
    if ($length > ($max - $min + 1)) {
        throw new Exception("Length exceeds the range of unique values possible.");
    }

    $result = [];
    while (count($result) < $length) {
        $randomNumber = rand($min, $max);
        if (!in_array($randomNumber, $result)) {
            $result[] = $randomNumber;
        }
    }

    return $result;
}

// Test cases
$testCases = [
    createUniqueArray(10, -200, 200),
    createUniqueArray(500, -10000, 10000),
    createUniqueArray(1000, -20000, 20000),
    createUniqueArray(10000, -20000, 20000),
    createUniqueArray(10000, -1000000, 1000000),
];

foreach ($testCases as $index => $test) {
    try {
        $result = solution($test);
        echo "Test case " . ($index + 1) . ": ";
        echo "has " . $result . " pair of numbers";
        echo "<br>";
    } catch (Exception $e) {
        echo "Test case " . ($index + 1) . ": Error - " . $e->getMessage() . "\n";
    }
}
