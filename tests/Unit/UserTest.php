<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['type' => 'admin']);
        $this->user = User::factory()->create(['type' => 'discente']);
    }

    /** @test it_can_create_a_user */
    public function it_can_create_a_user()
    {
        $this->actingAs($this->admin);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'ie' => 'IFAL',
            'type' => 'discente',
            'password' => 'password', // Plain password (not hashed)
        ];

        $response = $this->post('/users', $userData);

        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }

    /** @test it_cannot_create_user_as_non_admin */
    public function it_cannot_create_user_as_non_admin()
    {
        $this->actingAs($this->user);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'ie' => 'IFAL',
            'type' => 'discente',
            'password' => 'password', // Plain password (not hashed)
        ];

        $this->post('/users', $userData);

        $this->assertDatabaseMissing('users', ['email' => 'jane.doe@example.com']);
    }

    /** @test it_can_update_a_user */
    public function it_can_update_a_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $newUserData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'ie' => '54321',
            'type' => 'docente',
        ];

        $this->put("/users/{$user->id}", $newUserData);

        $this->assertDatabaseHas('users', ['email' => 'jane.doe@example.com']);
    }

    /** @test it_cannot_update_user_as_non_admin */
    public function it_cannot_update_user_as_non_admin()
    {
        $this->actingAs($this->user);

        $user = User::factory()->create();

        $newUserData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'ie' => '54321',
            'type' => 'docente',
        ];

        $response = $this->put("/users/{$user->id}", $newUserData);

        $response->assertStatus(403);
    }

    /** @test it_can_delete_a_user */
    public function it_can_delete_a_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $this->delete("/users/{$user->id}");

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test it_cannot_delete_user_as_non_admin */
    public function it_cannot_delete_user_as_non_admin()
    {
        $this->actingAs($this->user);

        $user = User::factory()->create();

        $response = $this->delete("/users/{$user->id}");

        $response->assertStatus(403);
    }

    /** @test it_can_find_a_user */
    public function it_can_find_a_user()
    {
        $this->actingAs($this->admin);

        $user = User::factory()->create();

        $foundUser = User::findOrFail($user->id);

        $this->assertEquals($user->name, $foundUser->name);
    }
}
