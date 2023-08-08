<?php

$stream = STDIN;

$testCases = intval(trim(fgets($stream)));

while ($testCases--) {
    fgets($stream);

    fscanf($stream, "%d %d", $m, $n);

    $x = [];
    $y = [];

    for ($i = 0; $i < $m - 1; $i++) {
        $cost = intval(trim(fgets($stream)));
        $x[] = $cost;
    }

    for ($i = 0; $i < $n - 1; $i++) {
        $cost = intval(trim(fgets($stream)));
        $y[] = $cost;
    }

    sort($x); // Sort the x and y arrays in ascending order
    sort($y);

    $totalCost = 0;

    $horizontalCuts = 1;
    $verticalCuts = 1;

    while (!empty($x) && !empty($y)) {
        if ($x[count($x) - 1] > $y[count($y) - 1]) {
            $totalCost += $x[count($x) - 1] * $verticalCuts;
            array_pop($x);
            $horizontalCuts++;
        } else {
            $totalCost += $y[count($y) - 1] * $horizontalCuts;
            array_pop($y);
            $verticalCuts++;
        }
    }

    while (!empty($x)) {
        $totalCost += $x[count($x) - 1] * $verticalCuts;
        array_pop($x);
        $horizontalCuts++;
    }

    while (!empty($y)) {
        $totalCost += $y[count($y) - 1] * $horizontalCuts;
        array_pop($y);
        $verticalCuts++;
    }

    echo $totalCost . PHP_EOL;
}
