<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductApiTest extends WebTestCase
{
    public function testGetProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
        $this->assertJson('[]');
    }

    public function testCreateAndGetProduct(): void
    {
        $client = static::createClient();

        // Создаём продукт
        $productData = [
            'name' => 'Test Product',
            'price' => 29.99,
            'status' => 'active'
        ];

        $client->request(
            'POST',
            '/api/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($productData)
        );

        $this->assertResponseStatusCodeSame(201);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $productId = $responseData['id'];

        // Получаем созданный продукт
        $client->request('GET', "/api/products/{$productId}");

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($productId, $responseData['id']);
        $this->assertSame('Test Product', $responseData['name']);
        $this->assertSame('29.99', $responseData['price']);
        $this->assertSame('active', $responseData['status']);
    }

    public function testCreateProductWithInvalidData(): void
    {
        $client = static::createClient();

        $invalidProductData = [
            'name' => '',
            'price' => -10,
            'status' => 'invalid_status'
        ];

        $client->request(
            'POST',
            '/api/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($invalidProductData)
        );

        $this->assertResponseStatusCodeSame(422);
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('violations', $responseData);
    }
}