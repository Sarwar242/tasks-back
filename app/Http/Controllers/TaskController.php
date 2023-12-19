<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('users')->get();

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request) : JsonResponse
    {
        $user = auth('sanctum')->user();
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);

        $request->merge(['created_by'=>$user->id]);
        $request->merge(['updated_by'=>$user->id]);
        Task::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully'
        ]);
    }

    public function show(Task $task)
    {
        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }


    public function update(Request $request, Task $task)
    {
        $user = auth('sanctum')->user();
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);
        $request->merge(['updated_by'=>$user->id]);
        $task->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully'
        ]);
    }


    public function updateStatus(Request $request, Task $task)
    {
        $user = auth('sanctum')->user();
        $request->validate([
            'status' => 'required'
        ]);
        $request->merge(['updated_by'=>$user->id]);
        $task->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function assignProject(Request $request, Task $task)
    {
        $user = auth('sanctum')->user();
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);
        $request->merge(['updated_by'=>$user->id]);
        $task->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function assignUser(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $task->users()->attach($request->user_id);

        return response()->json([
            'success' => true,
            'message' => 'User assigned successfully'
        ]);
    }

    public function removeUser(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $task->users()->detach($request->user_id);

        return response()->json([
            'success' => true,
            'message' => 'User removed successfully'
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
}
