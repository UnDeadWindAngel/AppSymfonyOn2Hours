<?php

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;

class ProductApiCurlTest extends TestCase
{
    private string $baseUrl = 'http://localhost/api';

    public function testApiIsAccessible(): void
    {
        $ch = curl_init($this->baseUrl . '/products');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(200, $httpCode, 'API should return 200 status code');
    }

    public function testCreateProduct(): void
    {
        $productData = json_encode([
            'name' => 'Test Product via API',
            'price' => 99.99,
            'status' => 'active'
        ]);

        $ch = curl_init($this->baseUrl . '/products');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $productData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($productData)
        ]);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(201, $httpCode, 'Creating product should return 201 status code');
    }
}