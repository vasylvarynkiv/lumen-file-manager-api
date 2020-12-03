<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Class FileResource
 *
 * @property integer $id
 * @property string $name
 * @property integer $size
 * @property string $extension
 *
 * @package App\Http\Resources
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'extension' => $this->extension,
            'url' => Storage::url($this->getFilePath()),
        ];
    }
}
