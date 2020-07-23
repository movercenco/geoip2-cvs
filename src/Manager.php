<?php

namespace App;

use Exception;
use GeoIp2\Database\Reader;

class Manager
{
  /**
   * @var Reader
   */
  private $reader;

  /**
   * Manager constructor.
   *
   * @param Reader $reader
   */
  public function __construct(Reader $reader)
  {
    $this->reader = $reader;
  }

  /**
   * @param string $input_file
   * @param string $output_file
   */
  public function process($input_file, $output_file): void
  {
    $output_file_open = fopen($output_file, 'wb+');

    foreach ($this->readFromCsv($input_file) as $row) {
      $ip = $row[0];
      if (filter_var($ip, FILTER_VALIDATE_IP)) {
        try {
          $record = $this->reader->country($ip);
          $country_name = $record->country->name;
        } catch (Exception $e) {
          $country_name = 'Private IP address.';
        }
        $row[] = $country_name;
      }

      fputcsv($output_file_open, $row);
    }

    fclose($output_file_open);
  }

  /**
   * @param string $input_file
   *
   * @return \Generator
   */
  protected function readFromCsv($input_file): ?\Generator
  {
    $input_file_open = fopen($input_file, 'rb');
    while (!feof($input_file_open)) {
      yield array_map('trim', (array)fgetcsv($input_file_open, 8192));
    }

    fclose($input_file_open);
  }
}
