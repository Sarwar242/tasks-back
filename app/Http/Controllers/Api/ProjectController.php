<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'success' => true,
            'projects' => $projects,
        ]);
    }

    public function store(ProjectStoreUpdateRequest $request)
    {
        $user = auth('sanctum')->user();

        $request->merge(['created_by' => $user->id]);
        $request->merge(['updated_by' => $user->id]);

        Project::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
        ]);
    }

    public function update(ProjectStoreUpdateRequest $request, Project $project)
    {
        $user = auth('sanctum')->user();

        $request->merge(['updated_by' => $user->id]);
        $project->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
        ]);
    }

    public function show(Project $project)
    {
        return response()->json([
            'success' => true,
            'project' => $project,
        ]);
    }

    public function updateStatus(Request $request, Project $project)
    {
        $user = auth('sanctum')->user();
        $request->validate([
            'status' => 'required',
        ]);

        $request->merge(['updated_by' => $user->id]);
        $project->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
        ]);
    }
}
