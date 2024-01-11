<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TaskResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\TaskCollection;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json(Task::all());
        // return response()->json(Task::paginate());
        // return new TaskCollection(Task::all()));
        // return new TaskCollection(Task::paginate()));

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('owner_id'),
                AllowedFilter::exact('project_id'),
                'is_done',
            ])
            ->allowedSorts(['title', 'created_at', 'due_at', 'scheduled_at', 'owner_id', 'project_id'])
            ->paginate();
        return new TaskCollection($tasks);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function store(TaskStoreRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task = Task::create($validated);

        return new TaskResource($task);
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // return response()->noContent();
        return response()->json(['status' => 'Success', 'message' => 'Task deleted successfully']);
    }
}
