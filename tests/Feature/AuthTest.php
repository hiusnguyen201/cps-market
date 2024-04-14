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

    /** 
        public function test_login_case_incorrect_password() {
        $user = User::factory()->create([
            "email" => "usertest@gmail.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->post("/auth/login", [
            'email' => "usertest@gmail.com",
            "password" => "password123345",
        ]);

        $response->assertRedirect("/auth/login");
        }

        public function test_login_case_format_error() {
            $response = $this->post("/auth/login", [
                'email' => "abcdef",
                "password" => "password",
            ]);

            $response->assertSessionHasErrors();
        }
    */

    public function test_active_customer_login_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => 1]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect("/member");
    }

    public function test_inactive_customer_login_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => 0]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect("/auth/otp");
    }

    public function test_active_admin_login_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => 1]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect("/admin");
    }

    public function test_inactive_admin_login_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => 0]);
        $response = $this->post("/auth/login", [
            'email' => $user->email,
            "password" => "password",
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect("/auth/otp");
    }

    // Otp
    public function test_otp_page_rendered() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/auth/otp");
        $response->assertStatus(200);
    }

    /**
     public function test_verify_otp_case_format_error() {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        User_Otp::factory()->create(["user_id" => $user->id, "otp" => "123456"]);

        $response = $this->post("/auth/otp", [
            "otp" => ''
        ]);
        
        $response->assertSessionHasErrors();
    }

    public function test_verify_otp_case_incorrect_otp() {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        User_Otp::factory()->create(["user_id" => $user->id, "otp" => "123456"]);

        $response = $this->post("/auth/otp", [
            "otp" => '000000'
        ]);
        
        $response->assertRedirect("/auth/otp");
    }

    public function test_verify_otp_case_otp_expired() {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $user_otp = User_Otp::factory()->create(["user_id" => $user->id, 'expire' => Carbon::now()->subMinutes(env('OTP_EXPIRE_MINUTES', 1))]);

        $response = $this->post("/auth/otp", [
            "otp" => $user_otp->otp,
        ]);
        
        $response->assertRedirect("/auth/otp");
    }

    */

    public function test_verify_otp_for_customer_success() {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $user_otp = User_Otp::factory()->create(["user_id" => $user->id]);

        $response = $this->post("/auth/otp", [
            "otp" => $user_otp->otp
        ]);
        
        $response->assertRedirect("/member");
    }
    
    public function test_verify_otp_for_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $user_otp = User_Otp::factory()->create(["user_id" => $user->id]);

        $response = $this->post("/auth/otp", [
            "otp" => $user_otp->otp
        ]);
        
        $response->assertRedirect("/admin");
    }

    public function test_resend_otp_success() {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        $response = $this->get("/auth/otp/resend");
        $response->assertRedirect("/auth/otp");
    }
    
    // Register
    public function test_register_page_rendered()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
    }

    /**
    public function test_register_case_format_error() {
        $response = $this->post("/auth/register", [
            'name' => "",
            'email' => "test@gmail.com",
            "phone" => "asdasdas",
            "password" => "",
            "password_confirmation" => "password",
        ]);
        
        $response->assertSessionHasErrors();
    }

    public function test_register_case_registered_email() {
        User::factory()->create([
            "email" => "test@gmail.com"
        ]);

        $response = $this->post("/auth/register", [
            'name' => "Test User",
            'email' => "test@gmail.com",
            "phone" => "0912345678",
            "password" => "password",
            "password_confirmation" => "password",
        ]);
        
        
        $response->assertSessionHasErrors();
    }
    */

    public function test_register_success()
    {
        $response = $this->post("/auth/register", [
            'name' => "Test User",
            'email' => "test@gmail.com",
            "phone" => "0912345678",
            "password" => "password",
            "password_confirmation" => "password",
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect("/auth/otp");
    }

    // Forget Password
    public function test_forget_password_page_rendered()
    {
        $response = $this->get('/auth/forget-password');
        $response->assertStatus(200);
    }

    /*
    public function test_forget_password_case_format_error() {
        $user = User::factory()->create();
        $response = $this->post('/auth/forget-password', [
            "email" => "ascacas"
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_forget_password_case_email_not_found() {
        $user = User::factory()->create();
        $response = $this->post('/auth/forget-password', [
            "email" => "usertest@gmail.com"
        ]);
        $response->assertSessionHasErrors();
    }
    */

    public function test_forget_password_send_link_reset_password_success()
    {
        $user = User::factory()->create();
        $response = $this->post('/auth/forget-password', [
            "email" => $user->email
        ]);
        $response->assertRedirect("/auth/forget-password");
    }

    // Reset Password
    /**
    public function test_change_password_page_case_invalid_token() 
    {
        $response = $this->get('/auth/reset-password/asasda');
        $response->assertSessionHas("error");
    }
    */

    public function test_change_password_page_rendered() 
    {
        $user = User::factory()->create();
        $password_reset = Password_Reset::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->get('/auth/reset-password/'.$password_reset->token);
        $response->assertStatus(200);
    }

    /**
    public function test_change_password_in_customer_case_format_error() 
    {
        $user = User::factory()->create();
        $password_reset = Password_Reset::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->post('/auth/reset-password/' . $password_reset->token, [
            "password" => "",
            "password_confirmation" => "",
        ]);
        
        $response->assertSessionHasErrors();
    }
    */

    public function test_change_password_in_customer_success() 
    {
        $user = User::factory()->create();
        $password_reset = Password_Reset::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->post('/auth/reset-password/'.$password_reset->token, [
            "password" => "password",
            "password_confirmation" => "password",
        ]);
        
        $response->assertRedirect("/auth/login");
    }

    // Log out
    public function test_logout_success() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/auth/logout");
        $response->assertRedirect("/auth/login");
    }
}