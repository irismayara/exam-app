<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test it_can_create_a_user*/
    public function it_can_create_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'ie' => 'IFAL',
            'type' => 'discente',
            'password' => 'password', // Plain password (not hashed)
        ];

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'ie' => $userData['ie'],
            'type' => $userData['type'],
            'password' => Hash::make($userData['password']), // Hashing password
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['ie'], $user->ie);
        $this->assertEquals($userData['type'], $user->type);
    }

    /** @test it_can_update_a_user*/
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $newUserData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'ie' => '54321',
            'type' => 'admin',
        ];

        $user->update($newUserData);

        $this->assertEquals($newUserData['name'], $user->fresh()->name);
        $this->assertEquals($newUserData['email'], $user->fresh()->email);
        $this->assertEquals($newUserData['ie'], $user->fresh()->ie);
        $this->assertEquals($newUserData['type'], $user->fresh()->type);
    }

    /** @test it_can_delete_a_user*/
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertNull(User::find($user->id));
    }


    /** @test it_can_find_a_user*/
    public function it_can_find_a_user()
    {
        $user = User::factory()->create();

        $foundUser = User::findOrFail($user->id);

        $this->assertEquals($user->name, $foundUser->name);
        $this->assertEquals($user->email, $foundUser->email);
    }
}
