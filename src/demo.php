<?php
declare(strict_types = 1);

namespace ws\loewe\polyphase_meter;

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('polyphase_meter');
$logger->pushHandler(new StreamHandler(__DIR__.'/../log.log', Logger::INFO));

$connector = new PolyphaseMeterConnector('/dev/ttyUSB0');

$reading = $connector->read();
echo 'raw data: ' . $reading . PHP_EOL;
$logger->info('raw data: ' . $reading . PHP_EOL);

$currentWatts = (double) $reading->extract('1-0:16.7.0*255')[1];
echo 'raw current watts: ' . $currentWatts . PHP_EOL;
$logger->info('raw data: ' . $currentWatts . PHP_EOL);

