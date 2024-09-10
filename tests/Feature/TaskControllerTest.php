<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_can_list_all_tasks()
    {
        // Arrange: Create some tasks
        $tasks = Task::factory()->count(3)->create();

        // Act: Call the index method
        $response = $this->getJson('/api/task'); // Adjust URL if needed

        // Assert: Check response status and content
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'task retrieved successfully',
                     'data' => $tasks->toArray()
                 ]);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    // public function test_can_store_task_with_user()
    // {
    //     $data = [
    //     'name' => 'John Doe',
    //     'email' => 'john@example.com',
    //     'username' => 'johndoe',
    //     'password' => 'password',
    //     'tasks' => [
    //         [
    //             'description' => 'Task 1',
    //             'category_id' => 9
    //         ],
    //         [
    //             'description' => 'Task 2',
    //             'category_id' => 9
    //         ]
    //     ]
    // ];

    // $response = $this->postJson('/api/task', $data);

    // $response->assertStatus(Response::HTTP_CREATED)
    //          ->assertJson([
    //              'status' => 'success',
    //              'message' => 'User created successfully',
    //              'data' => [
    //                  'user' => [
    //                      'name' => 'John Doe',
    //                      'email' => 'john@example.com',
    //                      'username' => 'johndoe',
    //                      // Tidak memeriksa password dan timestamps
    //                  ],
    //                  'tasks' => [
    //                      [
    //                          'description' => 'Task 1',
    //                          'category_id' => 9
    //                          // Periksa ID jika perlu
    //                      ],
    //                      [
    //                          'description' => 'Task 2',
    //                          'category_id' => 9
    //                          // Periksa ID jika perlu
    //                      ]
    //                  ]
    //              ]
    //          ]);
    // }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_can_show_task()
    {
        // Arrange: Create a task
        $task = Task::factory()->create();

        // Act: Call the show method
        $response = $this->getJson("/api/task/{$task->id}");

        // Assert: Check response status and content
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'task is found',
                     'data' => $task->toArray()
                 ]);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    // public function test_can_destroy_task()
    // {
    //     // Arrange: Create a task
    //     $task = Task::factory()->create();

    //     // Act: Call the destroy method
    //     $response = $this->deleteJson("/api/task/{$task->id}");

    //     // Assert: Check response status and content
    //     $response->assertStatus(Response::HTTP_OK)
    //              ->assertJson([
    //                  'status' => 'success',
    //                  'message' => 'task deleted successfully'
    //              ]);

    //     // Verify the task was actually deleted
    //     $this->assertDatabaseMissing('task', ['id' => $task->id]);
    // }

    /**
     * Test the store method validation error.
     *
     * @return void
     */
    // public function test_store_task_validation_error()
    // {
    //     // Arrange: Prepare invalid data
    //     $data = [
    //         'name' => 'John Doe',
    //         'email' => 'john@example.com',
    //         'username' => 'johndoe',
    //         'tasks' => [
    //             ['description' => 'Task 1', 'category_id' => 999], // Invalid category_id
    //         ],
    //     ];

    //     // Act: Call the store method with invalid data
    //     $response = $this->postJson('/api/task', $data);

    //     // Assert: Check response status and content
    //     $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    //              ->assertJson([
    //                  'status' => 'error',
    //                  'message' => 'Validation error',
    //              ]);
    // }
}
