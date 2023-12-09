<?php
declare(strict_types = 1);

namespace ws\loewe\polyphase_meter;

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

$logger_raw = new Logger('polyphase_meter');
$logger_raw->pushHandler(new StreamHandler(__DIR__.'/../log_raw.log', Logger::INFO));

$logger_csv = new Logger('polyphase_meter');
$stream = new StreamHandler(__DIR__.'/../data.csv', Logger::INFO);

$dateFormat = "Y-m-d\TH:i:s";
$output = "%datetime%;%message%\n";

// finally, create a formatter
$formatter = new LineFormatter($output, $dateFormat);
$stream->setFormatter($formatter);
$logger_csv->pushHandler($stream);


$connector = new PolyphaseMeterConnector('/dev/ttyUSB0');

$reading = $connector->read();
#echo 'raw data: ' . $reading . PHP_EOL;
$logger_raw->info('raw data: ' . $reading . PHP_EOL);


$currentWatts = (double) $reading->extract('1-0:16.7.0*255')[1];
$totalEnergy = (double) $reading->extract('1-0:1.8.0*255')[1];

#echo 'raw current watts: ' . $currentWatts . PHP_EOL;
$logger_csv->info($currentWatts . ";" . $totalEnergy );

