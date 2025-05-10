<?php

namespace Modules\ExchangeRates\Services;

use Modules\ExchangeRates\Services\HistoricalExchangeRateServiceInterface;
use Illuminate\Support\Facades\Cache;
use \GuzzleHttp\Client as HTTPClient;

class HistoricalExchangeRateService implements HistoricalExchangeRateServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new HTTPClient;
    }

    /**
     * Fetch exchange rates from the remote API.
     * Example: curl -s https://api.frankfurter.app/1999-01-04?base=USD
     *
     * @param string $date The date for which to fetch the exchange rates, in "YYYY-MM-DD" format.
     * @param string $base The base currency for the exchange rates, default is "USD".
     *
     * @return array The exchange rates data.
     */
    public function fetchRates($date, $base = 'USD'): array
    {
        $url = "https://api.frankfurter.app/$date?base=$base";
        $response = $this->client->get($url);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Retrieve exchange rates from the cache.
     *
     * @return array|null The cached exchange rates, or null if not found.
     */
    public function getCachedRates($date, $base = 'USD'): ?array
    {
        $cacheKey = "exchange_rates_$date";
        return Cache::get($cacheKey);
    }
}