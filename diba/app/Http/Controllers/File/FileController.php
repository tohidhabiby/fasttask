<?php

namespace App\Http\Controllers\File;

use App\Filters\File\FileFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Http\Resources\File\Base64FileResource;
use App\Http\Resources\File\FileResource;
use App\Models\File\File;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param FileFilter $filter  Filters.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function index(FileFilter $filter, Request $request): AnonymousResourceCollection
    {
        return FileResource::collection(File::filter($filter)->paginate($this->getPageSize($request)))
            ->additional($this->getAdditionals($filter, new File()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FileRequest $request Request.
     *
     * @return FileResource|JsonResponse
     */
    public function store(FileRequest $request): FileResource|JsonResponse
    {
        try {
            return new FileResource(File::createObject($request->file('file'), $request->user()));
        } catch (\Exception $exception) {
            Log::error('Create File Error  : ' . $exception->getMessage());

            return $this->getResponse([], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param File $file File.
     *
     * @return Base64FileResource
     * @throws AuthorizationException AuthorizationException.
     */
    public function show(File $file): Base64FileResource
    {
        $this->authorize('view', $file);

        return new Base64FileResource($file);
    }
}
