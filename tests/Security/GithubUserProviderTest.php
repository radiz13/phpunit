<?php
namespace App\Tests\Security;

use App\Security\GithubUserProvider;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GithubUserProviderTest extends TestCase
{
    private Client | MockObject | null $client;
    private SerializerInterface | MockObject | null $serializer;
    private ResponseInterface | MockObject | null $response;
    private StreamInterface |MockObject | null $stream;

    // libérer la mémoire
    public function tearDown() : void
    {
        $this->client = null;
        $this->serializer = null;
        $this->response = null;
        $this->stream = null;
    }

    public function setUp(): void{
        $this->client = $this->createMock(Client::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);

        $this->client->method('get')->willReturn($this->response);
        $this->response->method('getBody')->willReturn($this->stream);
    }

    public function testLoadUserByUsername()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar_url' => 'https://example.com/avatar.jpg',
            'login' => 'testuser',
            'html_url' => 'https://github.com/testuser'
        ];

//        $client = $this->createMock(Client::class);
//        $response = $this->createMock(ResponseInterface::class);
//        $client->method('get')->willReturn($response);

//        $stream = $this->createMock(StreamInterface::class);
//        $response->method('getBody')->willReturn($stream);
//        $stream->method('getContents')->willReturn(json_encode($userData));
        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode($userData))
        ;

//        $serializer = $this->createMock(SerializerInterface::class);
        $this->serializer->method('deserialize')->willReturn($userData);

        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $user = $githubUserProvider->loadUserByUsername('test_token');
        $this->assertEquals('Test User', $user->getName());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('https://example.com/avatar.jpg', $user->getAvatarUrl());
        $this->assertEquals('testuser', $user->getLogin());
        $this->assertEquals('https://github.com/testuser', $user->getHtmlUrl());
    }

    public function testLoadUserByUsernameNotFound()
    {
//        $client = $this->createMock(Client::class);
//        $response = $this->createMock(ResponseInterface::class);
//        $client->method('get')->willReturn($response);

//        $stream = $this->createMock(StreamInterface::class);
//        $response->method('getBody')->willReturn($stream);
        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('')
        ;

//        $serializer = $this->createMock(SerializerInterface::class);
        $this->serializer->method('deserialize')->willReturn([]);

        $this->expectException(\LogicException::class);
        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $githubUserProvider->loadUserByUsername('test_token');
    }
}