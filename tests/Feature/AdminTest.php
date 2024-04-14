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
use App\Models\Specification;
use App\Models\Order;

class AdminTest extends TestCase {
    // Users
    public function test_manage_users_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/users");
        $response->assertStatus(302);
    }

    public function test_create_user_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/users/create");
        $response->assertStatus(302);
    }

    public function test_create_user_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->post("/admin/users/create", [
            "name" => "Test",
            "email" => "test@gmail.com",
            "phone" => "0912345678",
            "gender" => 0,
            "status" => 0,
            "address" => null
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    public function test_edit_user_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->get("/admin/users/edit/" . $user->id);

        $response->assertStatus(302);
    }

    public function test_edit_user_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->patch("/admin/users/edit/" . $user->id, [
            "name" => "Test 1",
            "status" => 1
        ]);

        $response->assertStatus(302);
    }

    public function test_delete_user_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->delete("/admin/users" ,[ 
            "id" => [$user->id],
            "status" => 1
        ]);

        $response->assertStatus(302);
    }

    public function test_details_user_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->get("/admin/users/details/" . $user->id);
        $response->assertStatus(302);
    }

    
    // Category
    public function test_manage_categories_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/categories");
        $response->assertStatus(302);
    }

    public function test_create_category_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/categories/create");
        $response->assertStatus(302);
    }

    public function test_create_category_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->post("/admin/categories/create", [
            "name" => "Category",
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    public function test_edit_category_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/edit/" . $category->id);

        $response->assertStatus(302);
    }

    public function test_edit_category_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->patch("/admin/categories/edit/" . $category->id, [
            "name" => "Category",
        ]);

        $response->assertStatus(302);
    }

    public function test_delete_category_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->delete("/admin/categories" ,[ 
            "id" => [$category->id],
            "status" => 1
        ]);

        $response->assertStatus(302);
    }

    public function test_details_category_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/details/" . $category->id);
        $response->assertStatus(302);
    }

    // Specifications
    public function test_add_specification_page_in_categoryDetailsPage_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/details/" . $category->id ."/specifications/add");
        $response->assertStatus(302);
    }
    public function test_add_specification_into_category_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->post("/admin/categories/details/" . $category->id ."/specifications/add", [
            "name" => "Specification",
            "attributes" => ["Attr 1", "Attr 2"],
            "category_id" => $category->id,
        ]);
        $response->assertStatus(302);
    }
    public function test_edit_specification_page_in_categoryDetailsPage_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create();
        $response = $this->get("/admin/categories/details/" . $category->id ."/specifications/edit/" . $specification->id);
        $response->assertStatus(302);
    }
    public function test_edit_specification_into_category_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create();
        $response = $this->patch("/admin/categories/details/" . $category->id ."/specifications/edit/" . $specification->id, [
            "name" => "Specification",
            "attributes" => ["Attr 1", "Attr 2"],
            "category_id" => $category->id,
        ]);
        $response->assertStatus(302);
    }
    public function test_delete_specification_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create();
        $response = $this->delete("/admin/categories/details/" . $category->id . "/specifications", [
            "id" => [$specification->id],
        ]);
        $response->assertStatus(302);
    }



    

    // Brand
    public function test_manage_brands_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/brands");
        $response->assertStatus(302);
    }

    public function test_create_brand_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/brands/create");
        $response->assertStatus(302);
    }

    public function test_create_brand_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->post("/admin/brands/create", [
            "name" => "Brand",
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    public function test_edit_brand_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->get("/admin/brands/edit/" . $brand->id);

        $response->assertStatus(302);
    }

    public function test_edit_brand_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->patch("/admin/brands/edit/" . $brand->id, [
            "name" => "Brand",
        ]);

        $response->assertStatus(302);
    }

    public function test_delete_brand_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->delete("/admin/brands" ,[ 
            "id" => [$brand->id],
            "status" => 1
        ]);

        $response->assertStatus(302);
    }

    public function test_details_brand_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->get("/admin/brands/details/" . $brand->id);
        $response->assertStatus(302);
    }


    
    // Customer
    public function test_manage_customers_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/customers");
        $response->assertStatus(302);
    }

    public function test_create_customer_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/customers/create");
        $response->assertStatus(302);
    }

    public function test_create_customer_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->post("/admin/customers/create", [
            "name" => "Customer",
            "email" => "customer@gmail.com",
            "phone" => "0912345678",
            "gender" => 0,
            "status" => 0,
            "address" => null
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }

    public function test_edit_customer_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->get("/admin/customers/edit/" . $customer->id);

        $response->assertStatus(302);
    }

    public function test_edit_customer_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->patch("/admin/customers/edit/" . $customer->id, [
            "name" => "Customer",
            "status" => 0,
        ]);

        $response->assertStatus(302);
    }

    public function test_delete_customer_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->delete("/admin/customers" ,[ 
            "id" => [$customer->id],
            "status" => 1
        ]);

        $response->assertStatus(302);
    }

    public function test_details_customer_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->get("/admin/customers/details/" . $customer->id);
        $response->assertStatus(302);
    }




    // Products
    public function test_manage_products_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/products");
        $response->assertStatus(302);
    }

    public function test_create_product_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/products/create");
        $response->assertStatus(302);
    }

  /**
      public function test_create_product_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        
        $imageData = base64_encode(file_get_contents(asset("images/Cps-Market.png")));
       
        $response = $this->post("/api/products", [
            "name" => "Product",
            "market_price" => 1000,
            "price" => 1000,
            "quantity" => 1,
            "brand" => $brand->id,
            "category" => $category->id,
            "promotion_image" => $imageData,
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }
  */

    public function test_edit_product_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->get("/admin/products/edit/" . $product->id);

        $response->assertStatus(302);
    }

    /**
    public function test_edit_product_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->patch("/api/products/" . $product->id, [
            "name" => "Product",
            "quantity" => 100,
        ]);

        $response->assertStatus(302);
    }
    */

    public function test_delete_product_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->delete("/admin/products" ,[ 
            "id" => [$product->id],
        ]);

        $response->assertStatus(302);
    }

    public function test_details_product_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->get("/admin/products/details/" . $product->id);
        $response->assertStatus(302);
    }









    // Orders
    public function test_manage_orders_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/orders");
        $response->assertStatus(302);
    }

    public function test_create_order_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/orders/create");
        $response->assertStatus(302);
    }

      public function test_create_order_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);

        $product = Product::factory()->create();

        $response = $this->post("/admin/orders/create", [
            "customer_id" => $customer->id,
            "product_id" => [$product->id],
            "quantity" => [1],
            "province" => 1,
            "district" => 3,
            "ward" => 5,
            "address" => "Viet nam",
            "payment_method" => 0,
            "payment_status" => 0,
            "order_status" => 0,
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
    }


    public function test_edit_order_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);
        
        $order = Order::factory()->create();
        $response = $this->get("/admin/orders/edit/" . $order->id);

        $response->assertStatus(302);
    }



    public function test_edit_order_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 14]);
        $product = Product::factory()->create(["code" => time() + 14]);
        
        $response = $this->patch("/admin/orders/edit/" . $order->id, [
            "product_id" => [$product->id],
            "quantity" => [5],
            "district" => 35,
        ]);

        $response->assertStatus(302);
    }



    public function test_delete_order_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 13]);
        $response = $this->delete("/admin/products" ,[ 
            "id" => [$order->id],
        ]);

        $response->assertStatus(302);
    }


    public function test_details_order_page_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 10]);
        $response = $this->get("/admin/orders/details/" . $order->id);
        $response->assertStatus(302);
    }


    // Setting
    public function test_changePassword_page_in_admin_rendered() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->get("/admin/settings/password");
        $response->assertStatus(302);
    }

    public function test_changePassword_in_admin_success() {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id]);
        $this->actingAs($user);

        $response = $this->patch("/admin/settings/password", [
            "current_password" => "password",
            "new_password" => "password123",
            "new_password_confirmation" => "password123"
        ]);
        $response->assertStatus(302);
    }

}