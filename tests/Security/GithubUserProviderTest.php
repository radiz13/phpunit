<?php
namespace App\Tests\Security;

use App\Security\GithubUserProvider;
use App\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Serializer;
use PHPUnit\Framework\TestCase;

class GithubUserProviderTest extends TestCase
{
    public function testLoadUserByUsername()
    {

    }
}
