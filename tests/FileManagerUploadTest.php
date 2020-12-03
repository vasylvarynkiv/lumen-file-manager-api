<?php

use Illuminate\Http\UploadedFile;
use App\Models\FileManager;

class FileManagerUploadTest extends TestCase
{
    /**
     * /api/files [POST]
     */
    public function testFileManagerStore()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->call('POST', '/api/files', [], [], [
            'file' => $file
        ]);

        $this->assertEquals($file->hashName(), FileManager::latest()->first()->name);

        $this->assertResponseStatus(201);
    }

    /**
     * /api/files [GET]
     */
    public function testFileManagerList()
    {
        $this->call('GET', '/api/files');

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'size',
                    'extension',
                    'url',
                ],
            ],
        ]);
    }

    /**
     * /api/files/{id} [GET]
     */
    public function testFileManagerShow()
    {
        $id = FileManager::latest()->first()->id;

        $this->call('GET', '/api/files/' . $id);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'name',
                'size',
                'extension',
                'url',
            ],
        ]);
    }

    /**
     * /api/files/{id} [DELETE]
     */
    public function testFileManagerDelete()
    {
        $id = FileManager::latest()->first()->id;

        $this->call('DELETE', '/api/files/' . $id);

        $this->seeStatusCode(204);
    }
}
