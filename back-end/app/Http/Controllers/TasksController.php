<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Throwable;

class TasksController extends Controller
{
    public function get(Request $request) {
        try {
            $user_id = $request->get('user_id', NULL);
            $task_id = $request->get('task_id', NULL);
    
            if ($user_id == NULL) {
                return response()->json([
                    'status' => 'error',
                    'message' => "The field 'user_id' is required."
                ], 400);
            }
    
            $tasksModel = new Task();
            $tasksModel->user_id = $user_id;
            $tasksModel->task_id = $task_id;
            $tasks = $tasksModel->get()->all();
    
            return response()->json([
                'status' => 'success',
                'tasks' => $tasks
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ], 500);
        }
    }

    public function create(Request $request) {
        try {
            $user_id = $request->get('user_id');
            $title = $request->get('title');
            $description = $request->get('description');
            $target_date = $request->get('target_date');
    
            $has_missing_fields = (
                $user_id == NULL
                || $title == NULL
                || $description == NULL
                || $target_date == NULL
            );
    
            if ($has_missing_fields) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'There is one or more required fields missing. Please verify the fields and try again.'
                ]);
            }
    
            $result = Task::create([
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'target_date' => $target_date,
            ]);
    
            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'task' => $result
                ], 200);
            }
        } catch (Throwable $error) {
            dd($error);
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            $id = $request->get('id');
            $title = $request->get('title');
            $description = $request->get('description');
            $target_date = $request->get('target_date');

            if ($id == NULL) {
                return response()->json([
                    'status' => 'error',
                    'message' => "The 'id' field is required."
                ], 400);
            }

            $tasks = new Task();
            $task = $tasks->find($id);
            $task->title = $title;
            $task->description = $description;
            $task->target_date = $target_date;
            $result = $task->save();

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'task' => $task,
                ]);
            }
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error ocurred.'
            ], 500);
        }
    }

    public function delete(Request $request) {
        try {
            $id = $request->get('id');
            $result = Task::destroy($id);

            if ($result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The task has been deleted with success.',
                ]);
            }
        } catch (Throwable $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'An internal error has ocurred.'
            ], 500);
        }
    }
}
