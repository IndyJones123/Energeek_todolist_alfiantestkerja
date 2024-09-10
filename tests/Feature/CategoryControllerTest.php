<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_can_list_all_categories()
    {
        // Arrange: Create some categories
        $categories = Category::factory()->count(3)->create();

        // Act: Call the index method
        $response = $this->getJson('/api/category'); // Adjust URL if needed

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         '*' => ['id', 'name']
                     ]
                 ]);
    }

    // /**
    //  * Test the store method.
    //  *
    //  * @return void
    //  */
    // public function test_can_store_category()
    // {
    //     // Arrange: Prepare data
    //     $data = [
    //         'name' => 'New Category',
    //     ];

    //     // Act: Call the store method
    //     $response = $this->postJson('/api/category', $data);

    //     // Assert: Check response status and content
    //     $response->assertStatus(Response::HTTP_CREATED)
    //              ->assertJson([
    //                  'status' => 'success',
    //                  'message' => 'category created successfully',
    //                  'data' => $data
    //              ]);
    // }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_can_show_category()
    {
        // Arrange: Create a category
        $category = Category::factory()->create();

        // Act: Call the show method
        $response = $this->getJson("/api/category/{$category->id}");

        // Assert: Check response status and content
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'task is found',
                     'data' => $category->toArray()
                 ]);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_can_update_category()
    {
        // Arrange: Create a category
        $category = Category::factory()->create();

        // Prepare data
        $data = [
            'name' => 'Updated Category',
        ];

        // Act: Call the update method
        $response = $this->putJson("/api/category/{$category->id}", $data);

        // Assert: Check response status and content
        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User updated successfully',
                     'data' => array_merge($category->toArray(), $data)
                 ]);
    }

    /**
     * Test the destroy method.
     *
     * @return void
      */
    // public function test_can_destroy_category()
    // {
    //     // Arrange: Create a category
    //     $category = Category::factory()->create();

    //     // Act: Call the destroy method
    //     $response = $this->deleteJson("/api/category/{$category->id}");

    //     // Assert: Check response status and content
    //     $response->assertStatus(Response::HTTP_OK)
    //              ->assertJson([
    //                  'status' => 'success',
    //                  'message' => 'category deleted successfully'
    //              ]);

    //     // Verify the category was actually deleted
    //     $this->assertDatabaseMissing('category', ['id' => $category->id]);
    // }
}
