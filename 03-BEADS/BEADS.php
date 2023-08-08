<?php

$stream = STDIN;

$testCases = intval(fgets($stream));

while($testCases--) {
    $necklace = trim(fgets($stream));
    $size = strlen($necklace);

    $smallestLexicographic = $necklace;
    $bestIndex = 0;

    for ($i = 1; $i < $size; $i++) {
        $currentString = $necklace[$i] . substr($necklace, $i + 1) . substr($necklace, 0, $i);

        if (strcmp($currentString, $smallestLexicographic) < 0) {
            $smallestLexicographic = $currentString;
            $bestIndex = $i;
        }
    }

    echo $bestIndex + 1 . PHP_EOL;
}
