<?php

namespace App\Services;

use App\Models\FileManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class FileService
 * @package App\Services
 */
class FileService
{
    /**
     * @param $file
     * @return mixed
     */
    public function save($file)
    {
        if ($file->isValid()) {
            if ($file->store('media')) {
                return FileManager::create([
                    'name' => $file->hashName(),
                    'size' => $file->getSize(),
                    'extension' => $file->extension(),
                ]);
            }
        }
    }

    /**
     * Delete DB Item And Delete File
     *
     * @param Integer $id
     *
     * @throws FileNotFoundException
     */
    public function delete($id)
    {
        $file = FileManager::findOrFail($id);

        $filePath = $file->getFilePath();

        if (!Storage::exists($filePath)) {
            throw new FileNotFoundException();
        }

        if (Storage::delete($filePath)) {
            $file->delete();
        }
    }

    public function downloadFile($id)
    {
        $file = FileManager::findOrFail($id);

        $filePath = $file->getFilePath();

        if (!Storage::exists($filePath)) {
            throw new FileNotFoundException();
        }

        return Storage::download($filePath, $file->name);
    }
}
