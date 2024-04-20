<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Role;
use App\Models\User_Otp;
use App\Models\Password_Reset;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // Login
    public function test_login_page_rendered()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }

    public function test_inactive_admin_login_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.inactive.value")]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(302);
    }

    public function test_inactive_customer_login_case_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.inactive.value")]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(302);
    }

    public function test_active_admin_login_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(302);
    }
    public function test_active_customer_login_case_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertStatus(302);
    }



    // Otp
    public function test_otp_page_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/auth/otp");
        $response->assertStatus(200);
    }

    public function test_verify_otp_for_customer_case_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user_otp = User_Otp::factory()->create(["user_id" => $user->id]);

        $response = $this->post("/auth/otp", [
            "otp" => $user_otp->otp
        ]);

        $response->assertStatus(302);
    }

    public function test_verify_otp_for_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user_otp = User_Otp::factory()->create(["user_id" => $user->id]);

        $response = $this->post("/auth/otp", [
            "otp" => $user_otp->otp
        ]);

        $response->assertStatus(302);
    }

    public function test_resend_otp_case_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        $response = $this->get("/auth/otp/resend");
        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    // Register
    public function test_register_page_rendered()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
    }

    public function test_register_case_success()
    {
        $response = $this->post("/auth/register", [
            'name' => "Test User",
            'email' => "test@gmail.com",
            "phone" => "0912345678",
            "password" => "password",
            "password_confirmation" => "password",
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);
    }

    // Forget Password
    public function test_forget_password_page_rendered()
    {
        $response = $this->get('/auth/forget-password');
        $response->assertStatus(200);
    }

    public function test_forget_password_send_link_reset_password_case_success()
    {
        $user = User::factory()->create();
        $response = $this->post('/auth/forget-password', [
            "email" => $user->email
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    // Reset Password
    public function test_change_password_page_rendered()
    {
        $user = User::factory()->create();
        $password_reset = Password_Reset::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->get('/auth/reset-password/' . $password_reset->token);
        $response->assertStatus(200);
    }

    public function test_change_password_case_success()
    {
        $user = User::factory()->create();
        $password_reset = Password_Reset::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->post('/auth/reset-password/' . $password_reset->token, [
            "password" => "password",
            "password_confirmation" => "password",
        ]);

        $response->assertStatus(302);
    }

    // Log out
    public function test_logout_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/auth/logout");
        $response->assertStatus(302);
    }
}
