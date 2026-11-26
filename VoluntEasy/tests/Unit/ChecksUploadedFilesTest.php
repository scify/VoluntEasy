<?php

namespace Tests\Unit;

use App\Http\Controllers\Concerns\ChecksUploadedFiles;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ChecksUploadedFilesTest extends TestCase
{
    private function checker(): object
    {
        return new class
        {
            use ChecksUploadedFiles {
                rejectUploads as public;
            }
        };
    }

    public function test_acceptable_files_pass(): void
    {
        $file = UploadedFile::fake()->create('cv-'.uniqid().'.pdf', 100);

        $this->assertNull($this->checker()->rejectUploads([$file], 'volunteers', 'entities/volunteers'));
    }

    public function test_a_file_larger_than_10_mb_is_rejected_with_a_message(): void
    {
        $file = UploadedFile::fake()->create('big-'.uniqid().'.pdf', 11_000);

        $response = $this->checker()->rejectUploads([$file], 'volunteers', 'entities/volunteers');

        $this->assertNotNull($response);
        $this->assertSame(
            trans('entities/volunteers.moreThan10mb', ['filename' => $file->getClientOriginalName()]),
            session('flash_message'),
        );
    }
}
