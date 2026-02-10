<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class ProductTest extends TestCase
{
    public function testProductCreation(): void
    {
        $product = new Product();
        $product->setName('Test Product');
        $product->setPrice('19.99');
        $product->setStatus('active');

        $this->assertSame('Test Product', $product->getName());
        $this->assertSame('19.99', $product->getPrice());
        $this->assertSame('active', $product->getStatus());
        $this->assertNotNull($product->getCreatedAt());
    }

    public function testDefaultStatusIsActive(): void
    {
        $product = new Product();
        $product->setName('Product');
        $product->setPrice('10.00');

        $this->assertSame('active', $product->getStatus());
    }

    public function testCanChangeStatusToInactive(): void
    {
        $product = new Product();
        $product->setStatus('inactive');

        $this->assertSame('inactive', $product->getStatus());
    }
}