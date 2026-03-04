<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProjectRequest;
use App\Http\Resources\Flowgate\ProjectResource;
use App\Models\Flowgate\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Handles Flowgate project management endpoints.
 */
class ProjectController extends Controller
{
    /**
     * List projects for the admin dashboard.
     *
     * @group Projects
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     *
     * @queryParam page integer Page number. Example: 1
     * @queryParam per_page integer Number of records per page (max 100). Example: 20
     */
    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::query()->latest()->paginate(20));
    }

    /**
     * Create a new upstream project.
     *
     * @group Projects
     *
     * @header X-Admin-Token string required Admin token for Flowgate management endpoints.
     *
     * @bodyParam name string required Human-readable project name. Example: Primary API
     * @bodyParam slug string required URL-safe project identifier. Example: primary-api
     * @bodyParam upstream_base_url string required Base URL of the upstream API. Example: https://api.example.com
     * @bodyParam is_active boolean Whether this project accepts gateway traffic. Example: true
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::query()->create($request->validated());

        return ProjectResource::make($project)
            ->response()
            ->setStatusCode(201);
    }
}
