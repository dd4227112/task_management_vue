<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Task_progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        // $projects = Project::with('tasks')->paginate(10);
        $projects = Project::paginate(10);

        $code = 200;
        $data = [];
        if (!$projects->isEmpty()) {
            $message = 'Project List';
            $data = $projects;
        } else {
            $message = 'project Not Found';
        }
        return response()->json(['message' => $message, 'data' => $data], $code);
    }

    public function project_details($slug)
    {
        $project = Project::with([
            'tasks.task_progress',
            'tasks.member_task.member'
        ])->where('slug', 'attendance-device_95fpk7kp6P1724181549')->first();


        $code = 200;
        $data = [];
        if (!empty($project)) {
            $message = 'Project Details';
            $data = $project;
        } else {
            $message = 'project Not Found';
        }
        return response()->json(['message' => $message, 'data' => $data], $code);
    }
    public function create(Request $request)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:5'],
                'startDate' => ['required', 'date'],
                'endDate' => ['required', 'date']
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data = array_merge($request->all(), ['slug' => Project::createSlug($request->name)]);
        if (Project::create($data)) {
            $code = 200;
            $message = 'project created successfully';
        } else {
            $code = 500;
            $message = 'Failed to create new project';
        }
        return response()->json(['message' => $message], $code);
    }
    public function update(Request $request, $id)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:5'],
                'startDate' => ['required', 'date'],
                'endDate' => ['required', 'date']
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data =  [
            'name' => $request->name,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'slug' => Project::createSlug($request->name)
        ];
        $project  = Project::find($id);
        if (!empty($project)) {
            $project->update($data);
            $code = 200;
            $message = 'project updated successfully';
        } else {
            $code = 404;
            $message = 'Can\'t update. Project not found';
        }
        return response()->json(['message' => $message], $code);
    }
    public function task(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $validatedData = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'min:5'],
                    'project_id' => ['required', 'integer'],
                ]
            );
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }
            if (Project::where('id', $request->project_id)->exists()) {
                $data = [
                    'name' => $request->name,
                    'project_id' => $request->project_id,
                ];
                if ($task = Task::create($data)) {
                    $data = [
                        'task_id' => $task->id,
                        'pinned_on_dashboard' => 0,
                        'progress' => 'Pending'
                    ];
                    Task_progress::create($data);
                    $code = 200;
                    $message = 'Project Task created successfully';
                } else {
                    $code = 500;
                    $message = 'Failed to create new task';
                }
            } else {
                $code = 404;
                $message = 'Failed!! Project Not Found';
            }

            return response()->json(['message' => $message], $code);
        });
    }
    public function pinToDashboard(Request $request)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'task_id' => ['required', 'integer'],
                'pinned_on_dashboard' => ['required', 'integer', 'in:0,1']
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data =  [
            'pinned_on_dashboard' => $request->pinned_on_dashboard,
        ];
        $task  =  Task_progress::find($request->task_id);
        if (!empty($task)) {
            $task->update($data);
            $code = 200;
            $message = 'Task Progress updated successfully';
        } else {
            $code = 404;
            $message = 'Can\'t update. Task not found';
        }
        return response()->json(['message' => $message], $code);
    }
    public function countProject()
    {
        $count   = Project::count();
        $code = 404;
        $message = 'Number of Projects';

        return response()->json(['message' => $message, 'data' => $count], $code);
    }
   
}
