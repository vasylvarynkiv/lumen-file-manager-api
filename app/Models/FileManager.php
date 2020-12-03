<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class FileManager
 *
 * @property integer $id
 * @property string $name
 * @property integer $size
 * @property string $extension
 *
 * @package App\Models
 */
class FileManager extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'extension'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'file' => 'required|file'
        ];
    }

    /**
     * Return the storage file path.
     *
     * @return string
     */
    public function getFilePath()
    {
        return 'media/' . $this->name;
    }

    /**
     * Return total used storage space.
     *
     * @return string
     */
    public static function totalUsedSpace()
    {
        return (object) ['bytes' => (int) DB::table('file_managers')->sum('size')];
    }
}
