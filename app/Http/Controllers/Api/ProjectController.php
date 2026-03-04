<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProjectRequest;
use App\Http\Resources\Flowgate\ProjectResource;
use App\Models\Flowgate\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::query()->latest()->paginate(20));
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::query()->create($request->validated());

        return ProjectResource::make($project)
            ->response()
            ->setStatusCode(201);
    }
}
