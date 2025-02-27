<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

use GuzzleHttp\Client as Guzzle;

class ProductTest extends TestCase
{
    public function testExemple()
        {
            $response = new Response(200, [], 'Success');
            $strTest = '';

            $client = $this->createMock(Guzzle::class);
            $client->method('get')->willReturn($response);

            $response = $client->get('https://example.com');
            $this->assertEquals(200, $response->getStatusCode());
            $this->assertEquals('Success', (string) $response->getBody());
        }



    #[DataProvider('priceTests')]
    public function testComputeTVA(string $pType, int $pPrice, float $result): void
    {
        $product = new Product();
        $product->setName('osef');
        $product->setType($pType);
        $product->setPrice($pPrice);

        if ($pPrice < 0) {
            $this->expectException(\Exception::class);
            $product->computeTVA();
        } else {
            $this->assertSame($result, $product->computeTVA());
        }
    }

    public static function priceTests(){
        return [
            ['other food', 100, Product::TVA_NORMAL*100],
            ['other food2', -222, Product::TVA_NORMAL*222],
            [Product::TYPE_SPECIAL, 20000, Product::TVA_SPECIAL*20000],
            [Product::TYPE_SPECIAL, -2345, Product::TVA_SPECIAL*2345]
        ];
    }
}
