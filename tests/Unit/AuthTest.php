<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get('/auth/login');

        $response->assertStatus(200);
    }
    public function test_register_form()
    {
        $response = $this->get('/auth/register');

        $response->assertStatus(200);
    }
    public function test_otp_form()
    {
        $response = $this->get('/auth/otp');

        $response->assertStatus(200);
    }
    public function test_forgetPassword_form()
    {
        $response = $this->get('/auth/forget-password');

        $response->assertStatus(200);
    }
}