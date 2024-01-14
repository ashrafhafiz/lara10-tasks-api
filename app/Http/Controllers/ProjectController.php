<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = QueryBuilder::for(Project::class)
            ->allowedIncludes(['tasks', 'members'])
            ->allowedFilters([
                AllowedFilter::exact('owner_id'),
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts(['title', 'created_at', 'due_at', 'scheduled_at', 'owner_id', 'id'])
            ->paginate();
        return new ProjectCollection($projects);
    }

    public function show(Project $project)
    {
        return (new ProjectResource($project))
            ->load('tasks')
            ->load('members');
    }

    public function store(ProjectStoreRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project = Auth::user()->projects()->create($validated);

        return new ProjectResource($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->update($validated);

        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['status' => 'Success', 'message' => 'Project deleted successfully']);
    }
}
