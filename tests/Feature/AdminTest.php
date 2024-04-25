<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Specification;
use App\Models\Order;
use App\Models\Shipping_Address;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    // Users
    public function test_manage_users_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/users");
        $response->assertStatus(200);
    }

    public function test_create_user_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/users/create");
        $response->assertStatus(200);
    }

    public function test_create_user_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->post("/admin/users/create", [
            "name" => "Test",
            "email" => "test@gmail.com",
            "phone" => "0912345678",
            "gender" => config("constants.genders.male.value"),
            "status" => config("constants.user_status.inactive.value"),
            "address" => null
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }


    public function test_edit_user_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->get("/admin/users/edit/" . $user->id);

        $response->assertStatus(200);
    }

    public function test_edit_user_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->patch("/admin/users/edit/" . $user->id, [
            "name" => "Test 1",
            "status" => 1,
            "phone" => "0912345678",
            "email" => $user->email,
            "id" => $user->id,
            "_method" => 'patch'
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    public function test_delete_user_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->delete("/admin/users", [
            "id" => [$user->id],
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    public function test_details_user_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $response = $this->get("/admin/users/details/" . $user->id);
        $response->assertStatus(200);
    }

    // Category
    public function test_manage_categories_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/categories");
        $response->assertStatus(200);
    }

    public function test_create_category_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/categories/create");
        $response->assertStatus(200);
    }


    public function test_create_category_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->post("/admin/categories/create", [
            "name" => "Category",
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    public function test_edit_category_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/edit/" . $category->id);

        $response->assertStatus(200);
    }


    public function test_edit_category_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->patch("/admin/categories/edit/" . $category->id, [
            "name" => "Category123",
            "_method" => 'patch',
            "id" => $category->id,
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    public function test_delete_category_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->delete("/admin/categories", [
            "id" => [$category->id],
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }

    public function test_details_category_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/details/" . $category->id);
        $response->assertStatus(200);
    }


    // Specifications
    public function test_add_specification_page_in_categoryDetailsPage_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->get("/admin/categories/details/" . $category->id . "/specifications/add");
        $response->assertStatus(200);
    }
    public function test_add_specification_into_category_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $response = $this->post("/admin/categories/details/" . $category->id . "/specifications/add", [
            "name" => "Specification",
            "attributes" => ["Attr 1", "Attr 2"],
            "category_id" => $category->id,
        ]);

        $response->assertSessionHas("success");
        $response->assertStatus(302);
    }
    public function test_edit_specification_page_in_categoryDetailsPage_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create(["category_id" => $category->id]);
        $response = $this->get("/admin/categories/details/" . $category->id . "/specifications/edit/" . $specification->id);

        $response->assertStatus(200);
    }
    public function test_edit_specification_into_category_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create(["category_id" => $category->id]);
        $response = $this->patch("/admin/categories/details/" . $category->id . "/specifications/edit/" . $specification->id, [
            "name" => "Specification123",
            "category_id" => $category->id,
            "specification_id" => $specification->id,
        ]);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_delete_specification_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $specification = Specification::factory()->create();
        $response = $this->delete("/admin/categories/details/" . $category->id . "/specifications", [
            "id" => [$specification->id],
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }





    // Brand
    public function test_manage_brands_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/brands");
        $response->assertStatus(200);
    }

    public function test_create_brand_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/brands/create");
        $response->assertStatus(200);
    }


    public function test_create_brand_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->post("/admin/brands/create", [
            "name" => "Brand123",
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_edit_brand_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->get("/admin/brands/edit/" . $brand->id);

        $response->assertStatus(200);
    }

    public function test_edit_brand_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->patch("/admin/brands/edit/" . $brand->id, [
            "name" => "Brand123",
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_delete_brand_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->delete("/admin/brands", [
            "id" => [$brand->id],
            "status" => 1
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_details_brand_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $brand = Brand::factory()->create();
        $response = $this->get("/admin/brands/details/" . $brand->id);
        $response->assertStatus(200);
    }



    // Customer
    public function test_manage_customers_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/customers");
        $response->assertStatus(200);
    }

    public function test_create_customer_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/customers/create");
        $response->assertStatus(200);
    }

    public function test_create_customer_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->post("/admin/customers/create", [
            "name" => "Customer1",
            "email" => "customer123@gmail.com",
            "phone" => "0912345678",
            "status" => config("constants.user_status.inactive.value"),
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_edit_customer_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->get("/admin/customers/edit/" . $customer->id);

        $response->assertStatus(200);
    }

    public function test_edit_customer_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->patch("/admin/customers/edit/" . $customer->id, [
            "name" => "Customer",
            "email" => "customer123@gmail.com",
            "phone" =>  "0912345678",
            "id" => $customer->id,
            "status" => config("constants.user_status.inactive.value")
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_delete_customer_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->delete("/admin/customers", [
            "id" => [$customer->id],
            "status" => 1
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    public function test_details_customer_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $roleCustomer = Role::factory()->create(["name" => "customer"]);
        $customer = User::factory()->create(["role_id" => $roleCustomer->id]);
        $response = $this->get("/admin/customers/details/" . $customer->id);
        $response->assertStatus(200);
    }




    // Products
    public function test_manage_products_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/products");
        $response->assertStatus(200);
    }

    public function test_create_product_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/products/create");
        $response->assertStatus(200);
    }


    public function test_create_product_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.png');

        $response = $this->post("/api/products", [
            "name" => "Product",
            "market_price" => 1000,
            "price" => 1000,
            "quantity" => 1,
            "brand" => $brand->id,
            "category" => $category->id,
            "promotion_image" => $file,
        ]);

        $response->assertStatus(200);
    }


    public function test_edit_product_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->get("/admin/products/edit/" . $product->id);

        $response->assertStatus(200);
    }



    public function test_edit_product_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.png');

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->patch("/api/products/" . $product->id, [
            "name" => "Product",
            "market_price" => 1000,
            "price" => 100,
            "quantity" => 1,
            "brand" => $product->brand_id,
            "category" => $product->category_id,
            "promotion_image" => $file,
        ]);

        $response->assertStatus(200);
    }


    public function test_delete_product_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->delete("/admin/products", [
            "id" => [$product->id],
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }


    public function test_details_product_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $product = Product::factory()->create(["code" => time() + rand()]);
        $response = $this->get("/admin/products/details/" . $product->id);
        $response->assertStatus(200);
    }









    // Orders
    public function test_manage_orders_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/orders");
        $response->assertStatus(200);
    }

    public function test_create_order_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/orders/create");
        $response->assertStatus(200);
    }

    public function test_create_order_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
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
            "payment_method" => config("constants.payment_method.cod.value"),
            "payment_status" => config("constants.payment_status.canceled.value"),
            "order_status" => config("constants.order_status.canceled.value"),
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }


    public function test_edit_order_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $order = Order::factory()->create();
        Shipping_Address::factory()->create(["order_id" => $order->id]);
        $response = $this->get("/admin/orders/edit/" . $order->id);

        $response->assertStatus(200);
    }



    public function test_edit_order_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 14]);
        Shipping_Address::factory()->create(["order_id" => $order->id]);
        $product = Product::factory()->create(["code" => time() + 14]);

        $response = $this->patch("/admin/orders/edit/" . $order->id, [
            "customer_id" => $order->customer_id,
            "product_id" => [$product->id],
            "quantity" => [5],
            "district" => 1,
            "province" => 56,
            "ward" => 356,
            "address" => "something",
            "payment_method" => config("constants.payment_method.cod.value"),
            "payment_status" => config("constants.payment_status.pending.value"),
            "order_status" => config("constants.order_status.canceled.value")
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }



    public function test_delete_order_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 13]);
        $response = $this->delete("/admin/orders", [
            "id" => [$order->id],
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }


    public function test_details_order_page_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $order = Order::factory()->create(["code" => time() + 10]);
        Shipping_Address::factory()->create(["order_id" => $order->id]);
        $response = $this->get("/admin/orders/details/" . $order->id);
        $response->assertStatus(200);
    }


    // Setting
    public function test_change_password_page_in_admin_rendered()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value")]);
        $this->actingAs($user);

        $response = $this->get("/admin/settings/password");
        $response->assertStatus(200);
    }

    public function test_change_password_in_admin_case_success()
    {
        $role = Role::factory()->create(["name" => "admin"]);
        $user = User::factory()->create(["role_id" => $role->id, "status" => config("constants.user_status.active.value"), "password" => bcrypt("password")]);
        $this->actingAs($user);

        $response = $this->patch("/admin/settings/password", [
            "current_password" => "password",
            "new_password" => "password123",
            "new_password_confirmation" => "password123"
        ]);

        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }
}
