<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Categories (e.g. Residential, Commercial, Renovation, Turnkey)
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Services
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('short_description')->nullable();
            $table->text('short_description_bn')->nullable();
            $table->longText('full_description')->nullable();
            $table->json('features')->nullable(); // list of bullet points / USPs
            $table->decimal('starting_price_bdt', 12, 2)->nullable();
            $table->json('process_steps')->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Projects (Portfolio)
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('room_type')->default('living'); // living, bedroom, kitchen, dining, office, bathroom, full_house
            $table->string('style')->default('Modern'); // Modern, Minimal, Classic, Scandinavian, Contemporary, Japandi
            $table->integer('area_sqft')->nullable();
            $table->string('location')->nullable();
            $table->string('duration')->nullable();
            $table->year('completion_year')->nullable();
            $table->string('client_name')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('model_3d_path')->nullable(); // GLB / GLTF path for 3D viewer
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 4. Inquiries & Consultation Bookings
        Schema::create('inquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('booking_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('property_type')->default('Apartment'); // Apartment, Duplex, Penthouse, Office, Showroom, Restaurant
            $table->string('budget_range')->nullable(); // e.g. 5-10 Lac BDT, 10-25 Lac BDT, 25+ Lac BDT
            $table->integer('area_sqft')->nullable();
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time')->nullable();
            $table->string('floor_plan_path')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('New'); // New, Contacted, Quoted, Won, Lost
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 5. Testimonials
        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();
            $table->string('client_name');
            $table->string('client_designation')->nullable();
            $table->string('client_avatar')->nullable();
            $table->string('project_name')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('quote');
            $table->text('quote_bn')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 6. Team Members
        Schema::create('team_members', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('role_bn')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. FAQs
        Schema::create('faqs', function (Blueprint $table): void {
            $table->id();
            $table->string('category')->default('general'); // general, pricing, process, turnkey
            $table->text('question');
            $table->text('question_bn')->nullable();
            $table->longText('answer');
            $table->longText('answer_bn')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Blog Posts
        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->string('category')->default('Design Trends');
            $table->json('tags')->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 9. Site Settings (Key-Value & structured)
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, contact, social, seo, pricing
            $table->timestamps();
        });

        // 10. Newsletter Subscribers
        Schema::create('newsletter_subscribers', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('services');
        Schema::dropIfExists('categories');
    }
};

