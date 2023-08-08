<?php

//$input = fopen('input', 'r');

$stream = STDIN;

$testCount = intval(trim(fgets($stream)));

while ($testCount--) {
    fscanf($stream, "%d %d", $n, $c);

    $stalls = [];
    for ($i = 0; $i < $n; $i++) {
        $stalls[] = trim(fgets($stream));
    }
    sort($stalls);

    $low = 0;
    $high = $stalls[$n - 1] - $stalls[0];
    $result = 0;

    while ($low <= $high) {
        $mid = $low + floor(($high - $low) / 2);

        $placedCows = 1;
        $lastPlacedStall = $stalls[0];

        for ($i = 1; $i < $n; $i++) {
            $sub = $stalls[$i] - $lastPlacedStall;

            if ($stalls[$i] - $lastPlacedStall >= $mid) {
                $placedCows++;
                $lastPlacedStall = $stalls[$i];
            }
        }

        if ($placedCows >= $c) {
            $result = $mid;
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }

    echo $result . PHP_EOL;
}
