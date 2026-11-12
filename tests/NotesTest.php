<?php

declare(strict_types=1);

namespace Tests;

use Crab\App;
use Crab\Testing\Api;
use PHPUnit\Framework\TestCase;

final class NotesTest extends TestCase
{
    private string $directory;
    private Api $api;
    private ?string $cookie = null;

    protected function setUp(): void
    {
        // A database and compiled templates of the test's own, never the development ones.
        $this->directory = sys_get_temp_dir() . '/crab-web-test-' . bin2hex(random_bytes(6));
        mkdir($this->directory);
        putenv('CRAB_STORAGE=' . $this->directory);
        putenv('DB_DATABASE=' . $this->directory . '/database.sqlite');
        putenv('APP_KEY=' . str_repeat('test-key-', 4));
        $app = require dirname(__DIR__) . '/app.php';
        self::assertInstanceOf(App::class, $app);
        self::assertSame(0, $app->console->run(['migrate'], new \Crab\Console\Output(fopen('php://memory', 'w+b'))));
        $this->api = new Api($app);
    }

    protected function tearDown(): void
    {
        putenv('CRAB_STORAGE');
        putenv('DB_DATABASE');
        putenv('APP_KEY');
        exec('rm -rf ' . escapeshellarg($this->directory));
    }

    public function testThePageListsNotesAndTheFormAddsOne(): void
    {
        $page = $this->get('/');
        $page->assertStatus(200);
        self::assertStringContainsString('No notes yet', $page->body());

        $saved = $this->post('/notes', ['text' => 'Buy <milk>']);
        $saved->assertStatus(303)->assertHeader('Location', '/');

        $page = $this->get('/')->body();
        self::assertStringContainsString('Buy &lt;milk&gt;', $page, 'A note is escaped.');
        self::assertStringContainsString('Note saved.', $page);
        self::assertStringNotContainsString('Note saved.', $this->get('/')->body(), 'The message shows once.');
    }

    public function testANoteMustHaveText(): void
    {
        $this->post('/notes', ['text' => ''])->assertStatus(422);
        self::assertStringContainsString('No notes yet', $this->get('/')->body());
    }

    private function get(string $path): \Crab\Testing\ApiResponse
    {
        return $this->remember($this->api->get($path, headers: $this->headers()));
    }

    /**
     * @param array<string, string> $form
     */
    private function post(string $path, array $form): \Crab\Testing\ApiResponse
    {
        return $this->remember($this->api->post($path, form: $form, headers: $this->headers()));
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return ['Accept' => 'text/html'] + ($this->cookie === null ? [] : ['Cookie' => $this->cookie]);
    }

    /**
     * Keeps the session cookie the answer set, as a browser would.
     */
    private function remember(\Crab\Testing\ApiResponse $response): \Crab\Testing\ApiResponse
    {
        $set = $response->header('Set-Cookie');
        if ($set !== '') {
            $this->cookie = explode(';', $set, 2)[0];
        }
        return $response;
    }
}
