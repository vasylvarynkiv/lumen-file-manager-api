<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FileResource
 *
 * @property integer $bytes
 *
 * @package App\Http\Resources
 */
class FileTotalResource extends JsonResource
{
    private static $divisor = 1024;

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
            'b' => $this->bytes,
            'kb' => $this->kb(),
            'mb' => $this->mb(),
            'gb' => $this->gb(),
        ];
    }

    /**
     * KiloBytes
     */
    private function kb()
    {
        return number_format($this->bytes / static::$divisor, 2, '.', '');
    }

    /**
     * MegaBytes
     */
    private function mb()
    {
        return number_format($this->kb() / static::$divisor, 2, '.', '');
    }

    /**
     * GigaBytes
     */
    private function gb()
    {
        return number_format($this->mb() / static::$divisor, 2, '.', '');
    }
}
