<?php

namespace Tests\Unit;

use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    /** @return array<string, array{string}> */
    public static function blockedNames(): array
    {
        return [
            'php' => ['shell.php'],
            'php upper case' => ['shell.PHP'],
            'phtml' => ['shell.phtml'],
            'html' => ['page.html'],
            'svg' => ['image.svg'],
            'htaccess' => ['.htaccess'],
        ];
    }

    #[DataProvider('blockedNames')]
    public function test_it_refuses_files_that_can_run_on_the_server_or_in_the_browser(string $name): void
    {
        $this->expectException(ValidationException::class);

        (new FileService)->storeFile(UploadedFile::fake()->create($name, 1), $name, sys_get_temp_dir());
    }

    public function test_it_stores_a_document(): void
    {
        $dir = sys_get_temp_dir().'/volunteasy-test-'.uniqid();
        mkdir($dir);

        $name = (new FileService)->storeFile(UploadedFile::fake()->create('cv.pdf', 10), '../cv.pdf', $dir);

        $this->assertSame('cv.pdf', $name);
        $this->assertFileExists($dir.'/cv.pdf');
    }
}
