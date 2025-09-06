<?php

namespace App\Services;

use Google_Client;
use Google\Service\Sheets;
use Google\Service\Drive;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSpreadSheetService
{
    // Init google service clients
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('google_credenticals.json'));
        $this->client->setScopes([
            Sheets::SPREADSHEETS,
            Drive::DRIVE_FILE
        ]);
        $this->service = new Sheets($this->client);
    }

    /**
     * Service method read a spreadsheets file
     *
     * @param string $range start recording area 'Sheet1!A1'
     * @return response data from spreadsheets
     */
    public function readSheet($range)
    {
        $response = $this->service->spreadsheets_values->get(config('services.google_spreadsheet_id'), $range);
        return $response->getValues();
    }

    /**
     * Service method write to Google SpreadSheets
     *
     * @param string $sheetName start recording area 'Sheet1'
     * @param array $value data get from DB.
     * @return boolean
     */
    public function writeSheet($sheetName, $values)
    {
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS' // Auto insert new row
        ];
        $range = $sheetName;
        try {
            // Insert new line into file google spreadsheets
            $this->service->spreadsheets_values->append(config('services.google_spreadsheet_id'), $range, $body, $params);
            // Update for all data in sheet
            // $this->service->spreadsheets_values->update(self::SPREADSHEET_ID, $range, $body, $params);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
