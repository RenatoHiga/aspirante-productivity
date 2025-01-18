<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;

class TasksApiTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_tasks(): void
    {
        parent::setUp();

        $user_id = 1;
        $request = new Request([
            'user_id' => 1
        ]);
        $tasksController = new TasksController();

        $result = $tasksController->get($request)->getData();
        $this->assertIsArray($result->tasks);
    }

    public function test_create_task(): void
    {
        $task = new Request([
            'user_id' => 1,
            'title' => 'Testing',
            'description' => 'Testing',
            'creation_date' => date('Y-m-d', strtotime('now')),
        ]);

        $tasksController = new TasksController();
        $result = $tasksController->create($task)->getData();

        $this->assertIsObject($result->task);
    }

    public function test_update_task(): void
    {
        $task = new Request([
            'user_id' => 1,
            'title' => 'Testing 2',
            'description' => 'Testing 2',
            'creation_date' => date('Y-m-d', strtotime('now')),
        ]);

        $tasksController = new TasksController();
        $result = $tasksController->create($task)->getData();

        $updated_task = new Request([
            'id' => $result->task->id,
            'title' => 'Updated title',
            'description' => 'Updated description',
            'creation_date' => date('Y-m-d', strtotime('now'))
        ]);

        $result = $tasksController->update($updated_task)->getData();

        $this->assertEquals('Updated title', $result->task->title);
        $this->assertEquals('Updated description', $result->task->description);
    }

    public function test_delete_task(): void 
    {
        $task = [
            'user_id' => 1,
            'title' => 'Testing 3',
            'description' => 'Testing 3',
            'creation_date' => date('Y-m-d', strtotime('now')),
        ];

        $tasksController = new TasksController();
        $result = json_decode($tasksController->create($task));

        $task_id = $result->id;
        $result = $tasksController->delete($task_id);
        
        $this->assertEquals('success', $result->status);
    }
}
