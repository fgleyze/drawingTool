<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use Drawing\Application\DrawingStepsExporter;
use Drawing\Infrastructure\FileManager;

$inputFileName = 'input.txt';
$outputFileName = 'output.txt';

if (array_key_exists(1, $argv)) {
    $inputFileName = $argv[1];
}

if (array_key_exists(2, $argv)) {
    $outputFileName = $argv[2];
}

$drawingStepsExporter = new DrawingStepsExporter(new FileManager());

echo $drawingStepsExporter->exportFromInputFile($inputFileName, $outputFileName);