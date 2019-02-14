<?php

use App\Manager;
use App\ReaderFactory;

require 'vendor/autoload.php';

const PR_ROOT = __DIR__;
const OUTPUT_DIR = PR_ROOT . '/output/';

if (!isset($argv[1])) {
  exit('No input file');
}

$input_file = $argv[1];
if (!file_exists($input_file)) {
  exit("Input file doen't exist ($input_file)");
}

$output_file = $argv[2] ?? OUTPUT_DIR . 'output_' . (new DateTime())->format('_d_m_Y_H_i_s') . '.csv';

$reader = ReaderFactory::getCountryReader();
$manager = new Manager($reader);
$manager->process($input_file, $output_file);
