<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_users()
    {
        // Arrange: Buat beberapa user
        User::factory()->count(3)->create();

        // Act: Panggil API endpoint
        $response = $this->getJson('/api/users');

        // Assert: Pastikan response sukses dan datanya sesuai
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         '*' => ['id', 'name', 'email', 'username']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_create_a_new_user()
    {
        // Arrange: Data user baru
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'password' => 'password'
        ];

        // Act: Panggil API endpoint untuk membuat user
        $response = $this->postJson('/api/users', $data);

        // Assert: Pastikan response sukses dan user tersimpan di database
        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User created successfully',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com'
        ]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        // Arrange: Buat user
        $user = User::factory()->create();

        // Act: Panggil API endpoint untuk menampilkan user
        $response = $this->getJson("/api/users/{$user->id}");

        // Assert: Pastikan response sukses dan data user sesuai
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User is found',
                     'data' => [
                         'id' => $user->id,
                         'name' => $user->name,
                         'email' => $user->email
                     ]
                 ]);
    }
}
