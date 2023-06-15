<?php

namespace App\Services;

use App\Clients\CompanySymbolClient;
use App\Clients\RapidApiClient;
use Illuminate\Support\Facades\Cache;

class CompanySymbolService {

    private RapidApiClient $rapidApiClient;
    private CompanySymbolClient $companySymbolClient;

    public function __construct(RapidApiClient $rapidApiClient, CompanySymbolClient $companySymbolClient) {
        $this->rapidApiClient = $rapidApiClient;
        $this->companySymbolClient = $companySymbolClient;
    }

    public function getHistoricalData(string $companySymbol): ?array {
        return $this->transformHistoricalData($this->rapidApiClient->getHistoricalData($companySymbol));
    }


    public function getCompanySymbols() {

        return Cache::remember('company_symbol', 60 * 24, function () {

            // Fetch the data from client for the symbol class and put in cache
            $companySymbols = $this->companySymbolClient->get();
            return array_column($companySymbols, 'Symbol');
        });

    }

    public function getCompanyName(string $companySymbol) {

        $companyListings = Cache::remember('company_listings', 60 * 24, function () {
            // Fetch the data from client for the symbol class
            return $this->companySymbolClient->get();
        });

        // get company name by searching into company listings
        $arrayKey = array_search($companySymbol, array_column($companyListings, 'Symbol'));
        return $companyListings[$arrayKey]['Company Name'];

    }


    private function transformHistoricalData(\StdClass $historicalDataRecords): ?array {

        // Prepare separate arrays for labels, open prices, and close prices
        // we will use this for charts
        $labels = [];
        $openPrices = [];
        $closePrices = [];

        foreach ($historicalDataRecords->prices as $historicalDataRecord) {

            $dateTransformation = date('Y-m-d', $historicalDataRecord->date);
            $historicalDataRecord->date = $dateTransformation;

            $labels[] = $historicalDataRecord->date;
            $openPrices[] = $historicalDataRecord->open ?? 0;
            $closePrices[] = $historicalDataRecord->close ?? 0;

        }

        return [
            'transformedHistoricalData' => $historicalDataRecords,
            'labels' => $labels,
            'open_prices' => $openPrices,
            'close_prices' => $closePrices
        ];

    }
}
