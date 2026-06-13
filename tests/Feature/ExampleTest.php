<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\ContactMessage;
use App\Models\Review;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Automatically seed the database before each test.
     */
    protected $seed = true;

    /**
     * Test that all public pages load successfully.
     */
    public function test_public_pages_load_successfully(): void
    {
        // Test Home Page (English and Arabic)
        $this->get('/en')->assertStatus(200);
        $this->get('/ar')->assertStatus(200);

        // Test About Page
        $this->get('/en/about')->assertStatus(200);
        $this->get('/ar/about')->assertStatus(200);

        // Test Contact Page
        $this->get('/en/contact')->assertStatus(200);
        $this->get('/ar/contact')->assertStatus(200);

        // Test Admin Login Page (Unauthorized without Basic Auth)
        $this->get('/en/secure-admin-portal')->assertStatus(401);
        $this->get('/ar/secure-admin-portal')->assertStatus(401);

        // Test Admin Login Page (Authorized with Basic Auth)
        $this->withBasicAuth('admin', 'visionadmin123')->get('/en/secure-admin-portal')->assertStatus(200);
        $this->withBasicAuth('admin', 'visionadmin123')->get('/ar/secure-admin-portal')->assertStatus(200);
    }

    /**
     * Test that product detail pages load successfully.
     */
    public function test_product_detail_page_loads_successfully(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $this->get("/en/product/{$product->slug}")->assertStatus(200);
        $this->get("/ar/product/{$product->slug}")->assertStatus(200);
    }

    /**
     * Test that contact form submission saves message to database and redirects back.
     */
    public function test_contact_form_submission(): void
    {
        $response = $this->post('/en/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about medical gloves',
            'message' => 'Hello, I want to ask about the wholesale price of medical face masks. Thank you!',
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about medical gloves',
        ]);
    }

    /**
     * Test that product review submission saves the review and redirects back.
     */
    public function test_product_review_submission(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->post("/en/product/{$product->id}/review", [
            'reviewer_name' => 'Jane Doe',
            'rating' => 5,
            'comment' => 'This product is outstanding, very high quality!',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('reviews', [
            'product_id' => $product->id,
            'reviewer_name' => 'Jane Doe',
            'rating' => 5,
            'comment' => 'This product is outstanding, very high quality!',
            'is_approved' => false, // Review should be pending moderation by default
        ]);
    }

    /**
     * Test that unauthenticated access to admin routes redirects to login.
     */
    public function test_unauthenticated_admin_access_redirects(): void
    {
        $this->get('/en/admin')->assertStatus(404);
        $this->get('/ar/admin')->assertStatus(404);
    }

    /**
     * Test that an authenticated admin user can access all admin panel pages.
     */
    public function test_authenticated_admin_can_access_all_dashboard_pages(): void
    {
        $admin = User::where('email', 'admin@vision-medical.com')->first();
        $this->assertNotNull($admin);

        $this->actingAs($admin);

        $adminPages = [
            '/en/admin',
            '/en/admin/categories',
            '/en/admin/brands',
            '/en/admin/products',
            '/en/admin/reviews',
            '/en/admin/contacts',
            '/en/admin/settings',
            '/ar/admin',
            '/ar/admin/categories',
            '/ar/admin/brands',
            '/ar/admin/products',
            '/ar/admin/reviews',
            '/ar/admin/contacts',
            '/ar/admin/settings',
        ];

        foreach ($adminPages as $page) {
            $this->get($page)->assertStatus(200);
        }
    }

    /**
     * Test that admin login and dashboard links are hidden from guests and shown only to authenticated admin.
     */
    public function test_login_links_are_hidden_from_guests_and_shown_to_admins(): void
    {
        // 1. Visit as a guest
        $guestResponse = $this->get('/en');
        // The secure login portal URL and admin dashboard URL should NOT be visible in the HTML for guests
        $guestResponse->assertDontSee('/en/secure-admin-portal');
        $guestResponse->assertDontSee('/en/admin');

        // 2. Visit as an authenticated admin
        $admin = User::where('email', 'admin@vision-medical.com')->first();
        $this->assertNotNull($admin);
        
        $adminResponse = $this->actingAs($admin)->get('/en');
        // The admin dashboard URL SHOULD be visible in the HTML for logged-in admin
        $adminResponse->assertSee('/en/admin');
    }

    /**
     * Test that the IP restriction middleware blocks unauthorized IPs and allows whitelisted IPs.
     */
    public function test_ip_address_restriction_middleware(): void
    {
        // Save original allowed IPs env variable
        $originalIpEnv = \Illuminate\Support\Env::getRepository()->get('ADMIN_ALLOWED_IPS');

        try {
            // 1. Block access by setting an allowed IP that does not match the test request IP (default 127.0.0.1)
            \Illuminate\Support\Env::getRepository()->set('ADMIN_ALLOWED_IPS', '192.168.1.50');
            putenv('ADMIN_ALLOWED_IPS=192.168.1.50');
            
            $this->withBasicAuth('admin', 'visionadmin123')
                 ->get('/en/secure-admin-portal')
                 ->assertStatus(404);

            // 2. Allow access by adding 127.0.0.1 to the allowed IPs list
            \Illuminate\Support\Env::getRepository()->set('ADMIN_ALLOWED_IPS', '127.0.0.1, ::1');
            putenv('ADMIN_ALLOWED_IPS=127.0.0.1, ::1');
            
            $this->withBasicAuth('admin', 'visionadmin123')
                 ->get('/en/secure-admin-portal')
                 ->assertStatus(200);

        } finally {
            // Restore original environment state
            if ($originalIpEnv === null) {
                \Illuminate\Support\Env::getRepository()->clear('ADMIN_ALLOWED_IPS');
                putenv('ADMIN_ALLOWED_IPS');
            } else {
                \Illuminate\Support\Env::getRepository()->set('ADMIN_ALLOWED_IPS', $originalIpEnv);
                putenv("ADMIN_ALLOWED_IPS={$originalIpEnv}");
            }
        }
    }
}
