<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $data = [
            'name' => 'test admin',
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user' => ['id', 'name', 'email'], 'token'])
                 ->assertJsonFragment(['email' => 'test@gmail.com']);

        $this->assertDatabaseHas('users', ['email' => 'test@gmail.com']);
    }

    public function test_registration_fails_with_existing_email()
    {
        User::create([
            'name' => 'test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422) 
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_user_can_login()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];
    
        $response = $this->postJson('/api/login', $data);
    
        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'email']) 
                 ->assertJsonFragment(['email' => 'test@example.com']);
    }


}
