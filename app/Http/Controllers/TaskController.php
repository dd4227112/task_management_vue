<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\Task_progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderBy('id')->paginate(10);

        $code = 200;
        $data = [];
        if (!$tasks->isEmpty()) {
            $message = 'Task List';
            $data = $tasks;
        } else {
            $message = 'Task Not Found';
        }
        return response()->json(['message' => $message, 'data' => $data], $code);
    }
    public function create(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $message = [
                'members.*.integer' => " Invalid value for members"
            ];
            $validatedData = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'min:3'],
                    'status' => ['required', 'integer', 'in:1,0'],
                    'project_id' => ['required', 'integer'],
                    'members' => ['required', 'array'],
                    'members.*' => ['integer'],

                ],
                $message
            );
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors()->all(), 422);
            }
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'project_id' => $request->project_id,
            ];
            if (Project::where('id', $request->project_id)->exists()) {
                if ($task = Task::create($data)) {
                    $data = [
                        'task_id' => $task->id,
                        'pinned_on_dashboard' => 0,
                        'progress' => 'Pending'
                    ];
                    Task_progress::create($data);
                    $members = $request->members;
                    if (!empty($members) && is_array($members)) {
                        $message = '';
                        foreach ($members as $key => $member) {
                            if (Member::where('id', $member)->exists()) {
                                $data = [
                                    'member_id' => $member,
                                    'task_id' => $task->id,
                                    'project_id' => $request->project_id
                                ];
                                MemberTask::create($data);
                            } else {

                                $code = 404;
                                $message .= 'Member Not found, member id:' . $member . '\n';
                                unset($member);
                            }
                        }
                        $code = 200;
                        $message .= 'Task created successfully';
                    } else {
                        $code = 400;
                        $message = 'Invalid data';
                    }
                } else {
                    $code = 500;
                    $message = 'Failed to create new Task';
                }
            } else {
                $code = 404;
                $message = 'Project Not exist';
            }
            return response()->json(['message' => $message], $code);
        });
    }
    public function update(Request $request, $id)
    {

        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3'],
                'status' => ['required', 'integer', 'in:0,1'],
                'project_id' => ['required', 'integer'],

            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'project_id' => $request->project_id
        ];
        $task  = Task::find($id);
        if (!empty($task) && Project::where('id', $request->project_id)->exists()) {
            $task->update($data);
            $code = 200;
            $message = 'Task updated successfully';
        } else {
            $code = 404;
            $message = 'Can\'t update. Task or Project not found';
        }
        return response()->json(['message' => $message], $code);
    }
    public function changeTaskStatus(Request $request)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'task_id' => ['required', 'integer'],
                'action' => ['required', 'string', 'in:not_started_to_pending,not_started_to_completed,pending_to_completed,pending_to_not_started,completed_to_pending,completed_to_not_started']
            ]
        );
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
        $task = Task::find($request->task_id);
        if (!empty($task)) {

            switch ($request->action) {
                case 'not_started_to_pending':
                    $status = Task::PENDING;
                    $message = 'Task moved to pending';
                    break;

                case 'not_started_to_completed':
                    $status = Task::COMPLETED;
                    $message = 'Task moved to completed';
                    break;

                case 'pending_to_completed':
                    $status = Task::COMPLETED;
                    $message = 'Task moved to completed';
                    break;

                case 'pending_to_not_started':
                    $status = Task::NOT_STATED;
                    $message = 'Task moved to not started';
                    break;

                case 'completed_to_pending':
                    $status = Task::PENDING;
                    $message = 'Task moved to pending';
                    break;

                case 'completed_to_not_started':
                    $status = Task::NOT_STATED;
                    $message = 'Task moved to not started';
                    break;

                default:
                    $status = Task::PENDING;
                    $message = 'Task moved to pending';
                    break;
            }
            $task->update(['status' => $status]);
            $code = 200;
        } else {
            $code = 404;
            $message = 'Can\'t update. Task not found';
        }
        return response()->json(['message' => $message], $code);
    }
}
