<?php

//$stream = fopen('input', 'r');
$stream = STDIN;

//replace echo statements to fwrite($output, ...) to see results
$output = fopen('output', 'w');

$testCount = intval(trim(fgets($stream)));

function sum(string $num1, string $num2, int $length1, int $length2): string
{
    $maxLength = max($length1, $length2);
    $num1 = str_pad($num1, $maxLength, '0', STR_PAD_LEFT);
    $num2 = str_pad($num2, $maxLength, '0', STR_PAD_LEFT);

    $carry = 0;
    $result = '';

    for ($i = $maxLength - 1; $i >= 0; $i--) {
        $digitSum = (int)$num1[$i] + (int)$num2[$i] + $carry;
        $carry = floor($digitSum / 10);
        $digit = $digitSum % 10;

        $result = $digit . $result;
    }

    if ($carry > 0) {
        $result = $carry . $result;
    }

    return $result;
}

function printSum(string $num1, string $num2, string $sum, int $length1, int $length2, $output): void
{
    $whitespaceWidth = max(strlen($sum), $length1, $length2 + 1);
    $dashCount = max($length2 + 1, strlen($sum));
    echo(str_repeat(' ', $whitespaceWidth - $length1) . $num1 . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - $length2 - 1) . '+' . $num2 . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - $dashCount) . str_repeat('-', $dashCount) . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - strlen($sum)) . $sum);
}

function subtract(string $num1, string $num2, int $length1, int $length2): string
{
    $maxLength = max($length1, $length2);
    $num1 = str_pad($num1, $maxLength, '0', STR_PAD_LEFT);
    $num2 = str_pad($num2, $maxLength, '0', STR_PAD_LEFT);

    $borrow = 0;
    $result = '';

    for ($i = $maxLength - 1; $i >= 0; $i--) {
        $digitDiff = (int)$num1[$i] - (int)$num2[$i] - $borrow;

        if ($digitDiff < 0) {
            $borrow = 1;
            $digitDiff += 10;
        } else {
            $borrow = 0;
        }

        $result = $digitDiff . $result;
    }

    $result = ltrim($result, '0');

    if (empty($result)) {
        $result = '0';
    }

    return $result;
}

function printSubtraction(string $num1, string $num2, string $subtraction, int $length1, int $length2, $output): void
{
    $whitespaceWidth = max($length1, $length2 + 1);
    $dashCount = max($length2 + 1, strlen($subtraction));
    echo(str_repeat(' ', $whitespaceWidth - $length1) . $num1 . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - $length2 - 1) . '-' . $num2 . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - $dashCount) . str_repeat('-', $dashCount) . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - strlen($subtraction)) . $subtraction);
}

function multiply(string $num1, string $num2, int $length1, int $length2): string
{
    $result = array_fill(0, $length1 + $length2, 0);

    for ($i = $length1 - 1; $i >= 0; $i--) {
        $carry = 0;
        for ($j = $length2 - 1; $j >= 0; $j--) {
            $product = (int)$num1[$i] * (int)$num2[$j] + $carry + $result[$i + $j + 1];
            $carry = floor($product / 10);
            $result[$i + $j + 1] = $product % 10;
        }
        $result[$i + $j + 1] = $carry;
    }

    $resultStr = implode('', $result);

    $resultStr = ltrim($resultStr, '0');

    if (empty($resultStr)) {
        $resultStr = '0';
    }

    return $resultStr;
}

function printMultiplication(string $num1, string $num2, string $multiplication, int $length1, int $length2, $output): void
{
    $multiplicationLength = strlen($multiplication);
    $whitespaceWidth = max($multiplicationLength, $length1, $length2 + 1);
    $firstMulti = multiply($num1, $num2[$length2 - 1], $length1, strlen($num2[0]));

    $dashCount = max($length2+1, strlen($firstMulti));

    echo(str_repeat(' ', $whitespaceWidth - $length1) . $num1 . PHP_EOL);
    echo(str_repeat(' ', $whitespaceWidth - $length2 - 1) . '*' . $num2 . PHP_EOL);

    if ($length2 > 1) {
        echo(str_repeat(' ', $whitespaceWidth - $dashCount) . str_repeat('-', $dashCount) . PHP_EOL);

        $offset = 0;
        for ($i = $length2 - 1; $i >= 0; $i--) {
            $multi = multiply($num1, $num2[$i], $length1, strlen($num2[$i]));
            echo(str_repeat(' ', $multiplicationLength - strlen($multi) - $offset) . $multi . PHP_EOL);
            $offset++;
        }
    }


    echo(str_repeat("-", $multiplicationLength) . PHP_EOL);
    echo($multiplication);
}

while ($testCount--) {
    $operation = trim(fgets($stream));

    $pattern = '/^(-?\d+)([+\-*\/])(\d+)$/';
    preg_match($pattern, $operation, $matches);
    $num1 = $matches[1];
    $sign = $matches[2];
    $num2 = $matches[3];

    $length1 = strlen($num1);
    $length2 = strlen($num2);

    switch ($sign) {
        case '+':
            $sum = sum($num1, $num2, $length1, $length2);
            printSum($num1, $num2, $sum, $length1, $length2, $output);
            break;
        case '-':
            $subtraction = subtract($num1, $num2, $length1, $length2);
            printSubtraction($num1, $num2, $subtraction, $length1, $length2, $output);
            break;
        case '*':
            $multiplication = multiply($num1, $num2, $length1, $length2);
            printMultiplication($num1, $num2, $multiplication, $length1, $length2, $output);
            break;
    }
    if ($testCount !== 0) {
        echo(PHP_EOL . PHP_EOL);
    }
}
