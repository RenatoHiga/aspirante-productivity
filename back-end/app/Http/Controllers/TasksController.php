<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use Throwable;

class TasksController extends Controller
{
    public function get(Request $request) {
        $user_id = $request->get('user_id', NULL);
        $task_id = $request->get('task_id', NULL);

        if ($user_id == NULL) {
            return response()->json([
                'status' => 'error',
                'message' => "The field 'user_id' is required."
            ], 400);
        }

        $tasksModel = new Tasks();
        $tasksModel->user_id = $user_id;
        $tasksModel->task_id = $task_id;
        $tasks = $tasksModel->get()->all();

        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ]);
    }

    public function create(Request $request) {
        $user_id = $request->get('user_id');
        $title = $request->get('title');
        $description = $request->get('description');
        $creation_date = $request->get('creation_date');

        $has_missing_fields = (
            $user_id == NULL
            || $title == NULL
            || $description == NULL
            || $creation_date == NULL
        );

        if ($has_missing_fields) {
            return response()->json([
                'status' => 'error',
                'message' => 'There is one or more required fields missing. Please verify the fields and try again.'
            ]);
        }

        $result = Tasks::create([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'creation_date' => $creation_date,
        ]);

        if ($result) {
            return response()->json([
                'status' => 'success',
                'task' => $result
            ], 200);
        }
    }

    public function update(Request $request) {
        try {
            $id = $request->get('id');
            $title = $request->get('title');
            $description = $request->get('description');
            $creation_date = $request->get('creation_date');

            if ($id == NULL) {
                return response()->json([
                    'status' => 'error',
                    'message' => "The 'id' field is required."
                ], 400);
            }

            $tasks = new Tasks();
            $task = $tasks->find($id);
            $task->title = $title;
            $task->description = $description;
            $task->creation_date = $creation_date;
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
        
    }
}
