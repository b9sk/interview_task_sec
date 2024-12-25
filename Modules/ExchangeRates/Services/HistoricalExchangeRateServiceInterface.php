<?php

namespace Modules\ExchangeRates\Services;

interface HistoricalExchangeRateServiceInterface
{
    /**
     * Fetch exchange rates from the remote API.
     * Example: curl -s https://api.frankfurter.app/1999-01-04?base=USD
     *
     * @param string $date The date for which to fetch the exchange rates, in "YYYY-MM-DD" format.
     * @param string $base The base currency for the exchange rates, default is "USD".
     *
     * @return array The exchange rates data.
     */
    public function fetchRates($date, $base = 'USD'): array;

    /**
     * Retrieve exchange rates from the cache.
     *
     * @return array|null The cached exchange rates, or null if not found.
     */
    public function getCachedRates($date, $base = 'USD'): ?array;
}