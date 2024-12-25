<?php

namespace Modules\ExchangeRates\Tests\Unit;

use Modules\ExchangeRates\Services\HistoricalExchangeRateService;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class HistoricalExchangeRateServiceTest extends TestCase
{
    public function testFetchRates()
    {
        $date = '1999-01-04';
        $base = 'USD';
        $expectedResponse = [
            'base' => 'USD',
            'date' => '1999-01-04',
            'rates' => [
                'EUR' => 0.85,
                'GBP' => 0.65,
            ],
        ];

        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
                   ->with("https://api.frankfurter.app/$date?base=$base")
                   ->willReturn(new Response(200, [], json_encode($expectedResponse)));

        $service = new HistoricalExchangeRateService($mockClient);
        $result = $service->fetchRates($date, $base);

        $this->assertArrayHasKey('base', $result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('rates', $result);
        $this->assertArrayHasKey('EUR', $result['rates']);
        $this->assertArrayHasKey('GBP', $result['rates']);

        $this->assertIsArray($result['rates']);
    }


    public function testGetCachedRates()
    {
        $date = '1999-01-04';
        $base = 'USD';
        $cacheKey = "exchange_rates_$date";
        $expectedCachedRates = [
            'base' => 'USD',
            'date' => '1999-01-04',
            'rates' => [
                'EUR' => 0.85,
                'GBP' => 0.65,
            ],
        ];

        // Mock the Cache facade
        Cache::shouldReceive('get')
            ->with($cacheKey)
            ->andReturn($expectedCachedRates);

        $service = new HistoricalExchangeRateService();
        $result = $service->getCachedRates($date, $base);

        $this->assertArrayHasKey('base', $result);
        $this->assertArrayHasKey('date', $result);
        $this->assertArrayHasKey('rates', $result);
        $this->assertArrayHasKey('EUR', $result['rates']);
        $this->assertArrayHasKey('GBP', $result['rates']);
        $this->assertIsArray($result['rates']);
    }
}