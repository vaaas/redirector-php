<?php

use DataAccess\IFileSystem;
use DataAccess\Links;
use DataAccess\ScopedFileSystem;
use DependencyInjection\Container;
use Http\IRequest;
use Http\MockRequest;
use Http\Response;
use PHPUnit\Framework\TestCase;
use Providers\ConfigurationProvider;
use Providers\LinksProvider;
use Providers\RouterProvider;

final class IntegrationTest extends TestCase
{
    private Container $container;
    private IFileSystem $fs;
    private const DIR = '/tmp/redirector-php-test';

    public function setUp(): void
    {
        $this->getContainer();
        $this->initializeState();
    }

    private function getContainer(): Container
    {
        $this->container = new Container();
        $this->fs = new ScopedFileSystem(self::DIR);
        $this->container
            ->set(Container::class, $this->container)
            ->set(IFileSystem::class, $this->fs)
            ->register(new ConfigurationProvider())
            ->register(new LinksProvider())
            ->register(new RouterProvider());
        return $this->container;
    }

    private function initializeState(): void
    {
        @mkdir(self::DIR);
        @unlink(self::DIR . '/configuration.php');
        $this->fs->set('configuration.php', '
            <?php
            return [
                "authUsername" => "admin",
                "authPassword" => "password",
            ];
        ');

        @unlink(self::DIR . '/links');
        $this->fs->set('links', '');
    }

    private function getResponse(IRequest $request): Response
    {
        return $this->getContainer()->get(App::class)->getResponse($request);
    }

    private function assertRedirectTo(Response $response, string $to): void
    {
        $this->assertSame(302, $response->status);
        $this->assertSame($to, $response->headers['Location']);
    }

    private function assertNotFound(Response $response): void
    {
        $this->assertSame(404, $response->status);
        $this->assertStringContainsString('Not found', $response->body);
    }

    private function assertDemandsAuth(Response $response): void
    {
        $this->assertSame(401, $response->status);
        $this->assertSame('Basic', $response->headers['WWW-Authenticate']);
    }

    private function assertBadRequest(Response $response): void
    {
        $this->assertSame(400, $response->status);
    }

    public function testRedirect(): void
    {
        $this->container->get(Links::class)->set('test', 'best');
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/test'
        ));
        $this->assertRedirectTo($response, 'best');
    }

    public function testRedirectQuery(): void
    {
        $this->container->get(Links::class)->set('test', 'best');
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/test?key=value'
        ));
        $this->assertRedirectTo($response, 'best');
    }

    public function testRedirectMissing(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/missing'
        ));
        $this->assertNotFound($response);
    }

    public function testRejectsUnauthorized(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/'
        ));
        $this->assertDemandsAuth($response);
    }

    public function testAcceptsAuthorized(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
        ));
        $this->assertSame(200, $response->status);
    }

    public function testCreatingLinks(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'POST',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
            query: [
                'add' => '',
            ],
            post: [
                'from' => 'contrived',
                'to' => 'https://example.com',
            ]
        ));
        $this->assertRedirectTo($response, '/');

        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
        ));
        $this->assertStringContainsString('https://example.com', $response->body);

        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/contrived'
        ));
        $this->assertRedirectTo($response, 'https://example.com');
    }

    public function testDeletingLinks(): void
    {
        $this->container->get(Links::class)->set('test', 'best');
        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/test'
        ));
        $this->assertRedirectTo($response, 'best');

        $response = $this->getResponse(new MockRequest(
            method: 'POST',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
            query: [
                'delete' => '',
            ],
            post: [
                'entry' => 'test'
            ]
        ));
        $this->assertRedirectTo($response, '/');

        $response = $this->getResponse(new MockRequest(
            method: 'GET',
            uri: '/test'
        ));
        $this->assertNotFound($response);
    }

    public function testRejectsInvalidCreation(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'POST',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
            query: [
                'add' => '',
            ],
            post: [
                'from' => 'contrived',
            ]
        ));
        $this->assertBadRequest($response);
    }

    public function testRejectsBadDeletion(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'POST',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
            query: [
                'delete' => '',
            ],
            post: [
                'contrived' => 'contrived'
            ]
        ));
        $this->assertBadRequest($response);
    }

    public function testRejectsMissingMethod(): void
    {
        $response = $this->getResponse(new MockRequest(
            method: 'POST',
            uri: '/',
            headers: [
                'Authorization' => 'Basic ' . base64_encode('admin:password'),
            ],
            query: [],
            post: [
                'entry' => 'test'
            ]
        ));
        $this->assertBadRequest($response);
    }
}
