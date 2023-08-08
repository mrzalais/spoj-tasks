<?php

$stream = STDIN;

$testCount = intval(trim(fgets($stream)));

$winningCombos = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];

$answer = [];

while ($testCount--) {
    $counts = [
        'X' => 0,
        'O' => 0,
    ];

    $line = '';
    for ($i = 0; $i < 3; $i++) {
        $line .= trim(fgets($stream));
    }

    fgets($stream);

    $values = str_split($line);
    $counts = array_merge($counts, array_count_values($values));

    if ($counts['X'] < $counts['O'] || $counts['X'] > $counts['O'] + 1) {
        $answer[] = 'no';
        continue;
    }

    $xWins = false;
    $oWins = false;
    foreach ($winningCombos as $combo) {
        list($a, $b, $c) = $combo;
        if ($values[$a] === 'X' && $values[$b] === 'X' && $values[$c] === 'X') {
            $xWins = true;
        } elseif ($values[$a] === 'O' && $values[$b] === 'O' && $values[$c] === 'O') {
            $oWins = true;
        }
    }

    if ($xWins && $oWins) {
        $answer[] = 'no';
        continue;
    }

    if ($xWins && $counts['X'] !== $counts['O'] + 1) {
        $answer[] = 'no';
        continue;
    }

    if ($oWins && $counts['X'] !== $counts['O']) {
        $answer[] = 'no';
        continue;
    }

    $answer[] = 'yes';
}

echo implode("\n", $answer);
