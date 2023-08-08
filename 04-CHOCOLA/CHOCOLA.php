<?php

$t = intval(trim(fgets(STDIN)));

while ($t--) {
//Get input from STDIN
    fscanf(STDIN, "%d %d", $m, $n);

    $sum = 0;
    $x = [];
    $y = [];
    $maxCost = 0;

    for ($i = 0; $i < $m - 1; $i++) {
        $cost = fgets(STDIN);
        $x[] = (int) $cost;
        if ($cost > $maxCost) {
            $maxCost = (int) $cost;
        }
    }

    for ($i = 0; $i < $n - 1; $i++) {
        $cost = fgets(STDIN);
        $y[] = (int) $cost;
        if ($cost > $maxCost) {
            $maxCost = (int) $cost;
        }
    }

    $maxCount = max($m, $n);

    $chocolatePieces = [
        [
            'x' => $x, 'y' => $y
        ]
    ];

    while (!empty($chocolatePieces)) {
        $newChocolatePieces = [];
        foreach ($chocolatePieces as $key => $chocolatePiece) {
            for ($i = 0; $i < $maxCount - 1; $i++) {
                if (isset($chocolatePiece['x'][$i]) && $chocolatePiece['x'][$i] === $maxCost) {
                    $sum += $chocolatePiece['x'][$i];

                    $xLeft = array_slice($chocolatePiece['x'], 0, $i);
                    $xRight = array_slice($chocolatePiece['x'], $i + 1, count($x));
                    if (count($xLeft) === 0) {
                        $sum += array_sum($chocolatePiece['y']);
                    } else {
                        $newChocolatePieces [] = [
                            'x' => $xLeft,
                            'y' => $chocolatePiece['y'],
                        ];
                    }

                    if (count($xRight) === 0) {
                        $sum += array_sum($chocolatePiece['y']);
                    } else {
                        $newChocolatePieces [] = [
                            'x' => $xRight,
                            'y' => $chocolatePiece['y'],
                        ];
                    }

                    unset($chocolatePiece[$key]['x'][$i]);
                    $i = -1;
                    break;
                } elseif (isset($chocolatePiece['y'][$i]) && $chocolatePiece['y'][$i] === $maxCost) {
                    $sum += $chocolatePiece['y'][$i];

                    $yTop = array_slice($chocolatePiece['y'], 0, $i);
                    $yBottom = array_slice($chocolatePiece['y'], $i + 1, count($chocolatePiece['y']));

                    if (count($yTop) === 0) {
                        $sum += array_sum($chocolatePiece['x']);
                    } else {
                        $newChocolatePieces [] = [
                            'x' => $chocolatePiece['x'],
                            'y' => $yTop,
                        ];
                    }

                    if (count($yBottom) === 0) {
                        $sum += array_sum($chocolatePiece['x']);
                    } else {
                        $newChocolatePieces [] = [
                            'x' => $chocolatePiece['x'],
                            'y' => $yBottom,
                        ];
                    }

                    unset($chocolatePiece[$key]['y'][$i]);
                    $i = -1;
                    break;
                }

                if ($i === $maxCount - 2 && $maxCost !== 0) {
                    $maxCost--;
                    $maxCount--;
                    $i = -1;
                }

            }

        }
        $chocolatePieces = $newChocolatePieces;
    }
    echo $sum;
}
