<?php
/**
 * Modified script found at - https://github.com/OrimFoundation/PhpObjectifyTests
 *
 */

// start script time
$timeExecutionStart = microtime(true);
// start memory usage
$memoryExecutionStart = memory_get_usage(true);
// start memory peak usage
$peakMemoryExecutionStart = memory_get_peak_usage(true);

// default test to run
$client = 'phpredis';
// number of iterations to do
$iterations = 100000;

// fetch params from CLI
$options = getopt("c:i:m:");

if (array_key_exists('c', $options)) 
{
    $client = $options['c'];
}

if (array_key_exists('i', $options)) 
{
    $iterations = $options['i'];
}

if (array_key_exists('m', $options)) 
{
    $method = $options['m'];
}

include $client.'.php';
$testredis = new Testredis();

$testredis->$method($iterations);

// end script time
$timeExecutionEnd = microtime(true);
// end memory usage
$memoryExecutionEnd = memory_get_usage(true);
// end memory peak usage
$peakMemoryExecutionEnd = memory_get_peak_usage(true);

$timeSpent                    = 1000 * ($timeExecutionEnd - $timeExecutionStart);
$paddedMemoryExecutionStart   = str_pad(number_format($memoryExecutionStart, 0, '.', ','), 10, ' ', STR_PAD_LEFT);
$paddedMemoryExecutionEnd     = str_pad(number_format($memoryExecutionEnd, 0, '.', ','), 10, ' ', STR_PAD_LEFT);
$paddedPeakMemoryExecutionEnd = str_pad(number_format($peakMemoryExecutionEnd, 0, '.', ','), 10, ' ', STR_PAD_LEFT);

/*
echo 'Time spent:        ' . $timeSpent . ' ms' . PHP_EOL;
echo 'Memory start:      ' . $paddedMemoryExecutionStart . ' B' . PHP_EOL;
echo 'Memory end:        ' . $paddedMemoryExecutionEnd . ' B' . PHP_EOL;
echo 'Memory peak:       ' . $paddedPeakMemoryExecutionEnd . ' B' . PHP_EOL;
*/
echo $timeSpent.PHP_EOL;
echo $paddedMemoryExecutionStart.PHP_EOL;
echo $paddedMemoryExecutionEnd.PHP_EOL;
echo $paddedPeakMemoryExecutionEnd.PHP_EOL;


?>
