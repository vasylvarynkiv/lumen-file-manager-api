<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Http\Resources\FileTotalResource;
use Illuminate\Http\Request;
use App\Models\FileManager;
use App\Services\FileService;

/**
 * Class FileManagerController
 *
 * @package App\Http\Controllers
 */
class FileManagerController extends Controller
{
    public $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @OA\Get(path="/files",
     *   tags={"File Manager"},
     *   summary="File lists",
     *   operationId="file.index",
     *   @OA\Response(response="200", description="successful operation")
     * )
     */
    public function index()
    {
        $files = FileManager::all();

        return FileResource::collection($files);
    }

    /**
     * @OA\Post(path="/files",
     *   tags={"File Manager"},
     *   summary="File Store",
     *   operationId="file.store",
     *   @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="file",
     *                     format="file",
     *                 ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
     *   @OA\Response(response="201", description="successful operation")
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, FileManager::rules());

        $file = $this->fileService->save($request->file('file'));

        return response()->json($file, 201);
    }

    /**
     * @OA\Get(path="/files/{id}",
     *   tags={"File Manager"},
     *   summary="File Info",
     *   operationId="file.show",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="File ID",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response="200", description="successful operation"),
     *   @OA\Response(response=404, description="File not found")
     * )
     */
    public function show($id)
    {
        $file = FileManager::findOrFail($id);

        return new FileResource($file);
    }

    /**
     * @OA\Delete(path="/files/{id}",
     *   tags={"File Manager"},
     *   summary="File Delete",
     *   operationId="file.destroy",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="File ID",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response="204", description="successful operation"),
     *   @OA\Response(response=404, description="File not found")
     * )
     */
    public function destroy($id)
    {
        $this->fileService->delete($id);

        return response()->json(null, 204);
    }

    /**
     * @OA\Get(path="/files/download/{id}",
     *   tags={"File Manager"},
     *   summary="File Download",
     *   operationId="file.download",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="File ID",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response="200", description="successful operation"),
     *   @OA\Response(response=404, description="File not found")
     * )
     */
    public function download($id)
    {
        return $this->fileService->downloadFile($id);
    }

    /**
     * @OA\Get(path="/files/total",
     *   tags={"File Manager"},
     *   summary="File Total Used Space",
     *   operationId="file.total",
     *   @OA\Response(response="200", description="successful operation")
     * )
     */
    public function total()
    {
        $total = FileManager::totalUsedSpace();

        return new FileTotalResource($total);
    }
}
