<?php

namespace Otomaties\CookieConsent\CookieDatabase;

class CookieList
{
    private array $list;

    public function __construct(string $csvLocation)
    {
        $this->list = $this->parseCsv($csvLocation);
    }

    private function parseCsv($csvLocation)
    {
        $file = fopen($csvLocation, 'r');
        if ($file === false) {
            throw new \Exception("Error opening file $csvLocation");
        }

        $header = fgetcsv($file);
        $data = [];
    
        while (($row = fgetcsv($file)) !== false) {
            $rowData = array_combine($header, $row);
            $data[] = $rowData;
        }
    
        fclose($file);
        return $data;
    }

    public function find($cookie) {
        foreach ($this->list as $item) {
            if ($item['Cookie / Data Key name'] === $cookie) {
                return new Cookie($item);
            }
        }
        return false;
    }
}
