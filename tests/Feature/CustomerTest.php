<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Carbon;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Order;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    
    // Login
    public function test_home_page_rendered()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_search_page_rendered()
    {
        $response = $this->get('/catalogsearch/result');
        $response->assertStatus(200);
    }

    public function test_details_product_page_rendered()
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create();
        
        $response = $this->get('/'.$category->slug . "/" . $brand->slug . "/" . $product->slug . ".html");
        $response->assertStatus(200);
    }

    /**
    public function test_details_product_page_case_product_not_found()
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create();
        
        $response = $this->get('/'.$category->slug . "/" . $brand->slug . "/zzzzzz.html");
        $response->assertStatus(404);
    } 
    */


    // Cart
    public function test_cart_page_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/cart");
        $response->assertStatus(302);
    }

    public function test_add_product_to_cart_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $product = Product::factory()->create();
        $response = $this->post("/cart", [
            "product_id" => $product->id
        ]);
        
        $response->assertStatus(302);
    }

    /** 
    public function test_add_product_to_cart_in_home_page_case_error_product_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $response = $this->post("/cart", [
            "product_id" => "asd",
            "action" => "add"
        ]);

        $response->assertStatus(302);
    }

    public function test_update_quantity_in_cart_case_error_cart_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $response = $this->patch("/cart", [
            "cart_id" => 1,
            "quantity" => 3
        ]);
        
        $response->assertStatus(302);
    }
    */

    public function test_update_quantity_in_cart_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $cart = Cart::factory()->create();

        $response = $this->patch("/cart", [
            "cart_id" => $cart->id,
            "quantity" => 3
        ]);
        
        $response->assertStatus(302);
    }

    /** 
    public function test_delete_cart_case_error_cart_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->delete("/cart", [
            "cart_id" => 1,
        ]);
        
        $response->assertStatus(302);
    }
    */

    public function test_delete_cart_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $cart = Cart::factory()->create();

        $response = $this->delete("/cart", [
            "cart_id" => $cart->id,
        ]);
        
        $response->assertStatus(302);
    }

    // Wishlist
    public function test_wishlist_page_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/wishlist");
        $response->assertStatus(302);
    }

    public function test_add_product_to_wishlist_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $product = Product::factory()->create();
        $response = $this->post("/wishlist", [
            "product_id" => $product->id
        ]);
        
        $response->assertStatus(302);
    }
    
    /**
    public function test_add_product_to_wishlist_case_error_product_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $response = $this->post("/wishlist", [
            "product_id" => 1
        ]);
        
        $response->assertStatus(302);
    }
    */
    
    public function test_delete_wishlist_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $wishlist = WishList::factory()->create();

        $response = $this->delete("/wishlist", [
            "wishlist_id" => $wishlist->id,
        ]);
        
        $response->assertStatus(302);
    }

   /** 
    public function test_delete_wishlist_case_error_product_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $response = $this->delete("/wishlist", [
            "wishlist_id" => 1,
        ]);
        
        $response->assertStatus(302);
    }*/

    // Member
    public function test_member_page_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member");
        $response->assertStatus(302);
    }

    public function test_orders_page_in_member_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member/orders");
        $response->assertStatus(302);
    }

    public function test_orders_details_page_in_member_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $order = Order::factory()->create();
        $response = $this->get("/member/orders/" . $order->id);
        $response->assertStatus(302);
    }

    /**
    public function test_orders_details_page_in_member_case_error_order_not_found()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member/orders/" . 1);
        $response->assertStatus(404);
    }
    */

    public function test_changePassword_page_in_member_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member/change-password");
        $response->assertStatus(302);
    }

    public function test_changePassword_in_member_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "password" => bcrypt("password")]);
        $this->actingAs($user);

        $response = $this->patch("/member/change-password", [
            "current_password" => "password",
            "new_password" => "password123",
            "new_password_confirmation" => "password123"
        ]);

        $response->assertStatus(302);
    }
    
    /**
    public function test_changePassword_in_member_case_error_incorrect_password()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "password" => bcrypt("password")]);
        $this->actingAs($user);

        $response = $this->patch("/member/change-password", [
            "current_password" => "password123",
            "new_password" => "password123",
            "new_password_confirmation" => "password123"
        ]);

        $response->assertStatus(302);
    }
    */

    public function test_profile_page_in_member_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member/profile");
        $response->assertStatus(302);
    }

    public function test_editProfile_page_in_member_rendered()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/member/edit-profile");
        $response->assertStatus(302);
    }

    public function test_editProfile_in_member_success()
    {
        $role = Role::factory()->create(["name" => "customer"]);
        $user = User::factory()->create(["role_id" => $role->id, "password" => bcrypt("password")]);
        $this->actingAs($user);

        $response = $this->patch("/member/edit-profile", [
            "name" => "test",
            "phone" => "0912345678",
        ]);

        $response->assertStatus(302);
    }
}