<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;


class UserControllerTest extends TestCase
{

    public function test_index()
    {
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'email', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    public function test_show()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'name' => $user->name,
                     'email' => $user->email,
                 ]);
    }

    public function test_store()
    {
        $email = \Faker\Factory::create()->unique()->safeEmail;
        $userData = [
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test User',
                     'email' => $email,
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated User',
            // 'email' => 'updated@example.com',
            'password' => 'newpassword'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'name' => 'Updated User',
                    //  'email' => 'updated@example.com',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'updated@example.com'
        ]);
    }

    public function test_delete()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}