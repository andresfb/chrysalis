<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function newly_registered_user_has_guest_access()
    {
        $this->withoutExceptionHandling();

        $password = $this->faker->password(10);

        $expected = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->safeEmail,
            'password' => $password,
            'password_confirmation' => $password
        ];

        $response = $this->post('/register', $expected);

        $response->assertStatus(302);

        unset($expected['password']);

        unset($expected['password_confirmation']);

        $this->assertDatabaseHas('users', $expected);

        $actual = User::find(2);

        $this->assertNotNull($actual);

        $this->assertEquals($actual->name, $expected['name']);

        $this->assertTrue($actual->hasRole('guest'));
    }
}
