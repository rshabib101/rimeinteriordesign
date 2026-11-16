<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic interior design data.
     */
    public function run(): void
    {
        // 1. Admin & Editor Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@rimeinterior.com'],
            [
                'name' => 'Rime Admin',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'editor@rimeinterior.com'],
            [
                'name' => 'Senior Architect & Editor',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Site Settings (preserve admin changes if already present)
        $settings = [
            // General & Hero
            ['key' => 'site_name', 'value' => 'Asad Interior Design', 'group' => 'general'],
            ['key' => 'notice_bar_text', 'value' => 'Accepting Q1 & Q2 2027 Projects', 'group' => 'general'],
            ['key' => 'hero_badge', 'value' => 'Architecture & Interior Curation • Dhaka', 'group' => 'hero'],
            ['key' => 'hero_badge_bn', 'value' => 'স্থাপত্য ও প্রিমিয়াম ইন্টেরিয়র স্টুডিও • ঢাকা', 'group' => 'hero'],
            ['key' => 'tagline', 'value' => 'Designing Spaces That Feel Like You', 'group' => 'hero'],
            ['key' => 'tagline_bn', 'value' => 'আপনার ব্যক্তিত্বে সাজানো অনন্য স্পেস', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Award-winning architecture and interior design studio in Dhaka, blending spatial artistry, tactile luxury, and precision craftsmanship into enduring sanctuaries.', 'group' => 'hero'],
            ['key' => 'hero_subtitle_bn', 'value' => 'ঢাকায় আধুনিক স্থাপত্য ও প্রিমিয়াম ইন্টেরিয়র ডিজাইনে অনন্য সৃষ্টিশীলতা। আমরা আপনার বাসস্থান ও কর্মক্ষেত্রকে রূপান্তর করি বিলাসবহুল শান্তির আলয়ে।', 'group' => 'hero'],
            ['key' => 'hero_enable_3d', 'value' => '1', 'group' => 'hero'],
            ['key' => 'hero_image', 'value' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1800&q=85', 'group' => 'hero'],

            // Stats
            ['key' => 'stat_1_value', 'value' => '150+', 'group' => 'stats'],
            ['key' => 'stat_1_label', 'value' => 'Projects Handed Over', 'group' => 'stats'],
            ['key' => 'stat_2_value', 'value' => '14+', 'group' => 'stats'],
            ['key' => 'stat_2_label', 'value' => 'Years of Mastery', 'group' => 'stats'],
            ['key' => 'stat_3_value', 'value' => '100%', 'group' => 'stats'],
            ['key' => 'stat_3_label', 'value' => 'Turnkey Accountability', 'group' => 'stats'],
            ['key' => 'stat_4_value', 'value' => '5 Yrs', 'group' => 'stats'],
            ['key' => 'stat_4_label', 'value' => 'Craftsmanship Warranty', 'group' => 'stats'],

            // About & Story
            ['key' => 'about_title', 'value' => 'Where Spatial Poetry Meets Precision Craftsmanship', 'group' => 'about'],
            ['key' => 'about_story', 'value' => 'Founded in 2012 in the heart of Gulshan-2, Asad Interior Design was born from a simple conviction: great spaces should feel deeply personal while standing the test of time. Our multidisciplinary studio of architects, lighting designers, 3D visualization artists, and master artisans delivers bespoke environments across Dhaka and Chattogram.', 'group' => 'about'],
            ['key' => 'about_mission', 'value' => 'To elevate everyday living in Bangladesh through contextual luxury, honest natural materials, transparent BDT pricing, and photorealistic 3D clarity before a single nail is driven.', 'group' => 'about'],
            ['key' => 'about_vision', 'value' => 'Setting the benchmark for South Asian interior architecture through sustainable craft, millimeter-accurate joinery, and effortless turnkey execution.', 'group' => 'about'],
            ['key' => 'about_image', 'value' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1400&q=85', 'group' => 'about'],
            ['key' => 'awards_json', 'value' => json_encode([
                ['year' => '2025', 'title' => 'Asia Pacific Interior Design Distinction', 'org' => 'APIDA Honors', 'category' => 'Luxury Residential'],
                ['year' => '2024', 'title' => 'Best Turnkey Execution Studio — Bangladesh', 'org' => 'Dhaka Architecture Guild', 'category' => 'Residential & Office'],
                ['year' => '2023', 'title' => 'Excellence in 3D Spatial Visualization', 'org' => 'South Asia Design Forum', 'category' => 'Digital Craft'],
            ]), 'group' => 'about'],
            ['key' => 'process_steps_json', 'value' => json_encode([
                ['step' => '01', 'title' => 'Private Consultation', 'title_bn' => 'প্রাথমিক পরামর্শ', 'duration' => 'Week 1', 'description' => 'Site walkthrough, lifestyle discovery, structural assessment, and transparent BDT budget calibration.'],
                ['step' => '02', 'title' => 'Spatial Concept & Moodboard', 'title_bn' => 'স্পেশাল কনসেপ্ট', 'duration' => 'Weeks 2–3', 'description' => 'Zoning blueprints, ergonomic furniture plans, and physical tactile samples of stone, veneer, and brass.'],
                ['step' => '03', 'title' => '4K 3D & VR Twin', 'title_bn' => 'থ্রিডি ও ভিআর ডিজাইন', 'duration' => 'Weeks 4–5', 'description' => 'Photorealistic ray-traced renders and real-time 3D walkthroughs with circadian lighting previews.'],
                ['step' => '04', 'title' => 'Factory Craft & Execution', 'title_bn' => 'ফ্যাক্টরি ও সাইট কাজ', 'duration' => 'Weeks 6–14', 'description' => 'CNC modular joinery, German Blum hardware assembly, MEP engineering, and dedicated site supervision.'],
                ['step' => '05', 'title' => 'Styling & Key Handover', 'title_bn' => 'চূড়ান্ত হস্তান্তর', 'duration' => 'Week 15', 'description' => 'Curated art placement, 60-point quality audit, warranty certificate, and white-glove handover.'],
            ]), 'group' => 'process'],

            // Contact & Location
            ['key' => 'phone', 'value' => '+880 1711 000 000', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'concierge@asadinterior.com', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '+8801711000000', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Plot 42, Road 11, Block D, Gulshan-2, Dhaka 1212, Bangladesh', 'group' => 'contact'],
            ['key' => 'studio_hours', 'value' => 'Saturday – Thursday: 10:30 AM – 7:30 PM', 'group' => 'contact'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.706980268536!2d90.412518!3d23.793706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7a0f70deb73%3A0x30c36498f90fe23!2sGulshan%202%2C%20Dhaka%201212!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd', 'group' => 'contact'],

            // Pricing
            ['key' => 'bdt_rate_standard', 'value' => '1800', 'group' => 'pricing'],
            ['key' => 'bdt_rate_premium', 'value' => '2800', 'group' => 'pricing'],
            ['key' => 'bdt_rate_luxury', 'value' => '4200', 'group' => 'pricing'],

            // Social & SEO
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/asadinterior', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/asadinterior', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/asadinterior', 'group' => 'social'],
            ['key' => 'pinterest_url', 'value' => 'https://pinterest.com/asadinterior', 'group' => 'social'],
            ['key' => 'seo_meta_title', 'value' => 'Asad Interior Design | Luxury Architecture & Interior Studio in Dhaka', 'group' => 'seo'],
            ['key' => 'seo_meta_description', 'value' => 'Bespoke residential, corporate office, modular kitchen, and turnkey interior design studio in Gulshan-2, Dhaka with interactive 3D & VR visualization.', 'group' => 'seo'],
            ['key' => 'ga_measurement_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'fb_pixel_id', 'value' => '', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // 3. Categories
        $categoriesData = [
            [
                'name' => 'Residential Design',
                'name_bn' => 'আবাসিক ইন্টেরিয়র',
                'slug' => 'residential-design',
                'description' => 'Luxury duplexes, penthouses, and private family estates crafted for warmth and timeless grandeur.',
                'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Commercial & Retail',
                'name_bn' => 'বাণিজ্যিক ও রিটেইল',
                'slug' => 'commercial-retail',
                'description' => 'Experiential showrooms, flagship stores, and bespoke hospitality destinations.',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Corporate Offices',
                'name_bn' => 'কর্পোরেট অফিস',
                'slug' => 'corporate-offices',
                'description' => 'High-performance executive suites and creative agency workplaces that inspire leadership.',
                'image' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 3,
            ],
            [
                'name' => 'Modular Kitchens',
                'name_bn' => 'মডুলার কিচেন',
                'slug' => 'modular-kitchens',
                'description' => 'Precision German-engineered modular cabinetry fused with Italian quartz and brass hardware.',
                'image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 4,
            ],
            [
                'name' => 'Turnkey Projects',
                'name_bn' => 'টার্নকি প্রজেক্ট',
                'slug' => 'turnkey-projects',
                'description' => 'Complete single-point accountability from 3D design blueprint to final key handover.',
                'image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 5,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['slug']] = Category::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // 4. Services
        $servicesData = [
            [
                'title' => 'Residential Interior Architecture',
                'title_bn' => 'আবাসিক ইন্টেরিয়র স্থাপত্য',
                'slug' => 'residential-interior-architecture',
                'icon' => 'home',
                'short_description' => 'Comprehensive spatial planning, customized millwork, and refined material curation for luxury homes.',
                'short_description_bn' => 'বিলাসবহুল বাড়ির জন্য নান্দনিক স্পেস প্ল্যানিং, কাঠের সূক্ষ্ম কারুকাজ এবং প্রিমিয়াম ম্যাটেরিয়াল সিলেকশন।',
                'starting_price_bdt' => 180000.00,
                'features' => ['Bespoke spatial layout & zoning', 'Custom furniture & joinery drafting', 'Lighting architecture & circadian design', 'Material sampling & procurement concierge'],
                'banner_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Corporate & Office Spaces',
                'title_bn' => 'কর্পোরেট ও অফিস ডিজাইন',
                'slug' => 'corporate-office-spaces',
                'icon' => 'briefcase',
                'short_description' => 'Inspiring workspaces that elevate brand identity, employee ergonomics, and collaborative velocity.',
                'short_description_bn' => 'কর্মক্ষেত্রে আধুনিক ব্র্যান্ড পরিচিতি ও কর্মীবান্ধব পরিবেশ সৃষ্টিতে প্রিমিয়াম অফিস ইন্টেরিয়র।',
                'starting_price_bdt' => 250000.00,
                'features' => ['Executive boardroom acoustics', 'Biophilic workplace integration', 'Ergonomic task lighting & furniture', 'Agile collaboration lounges'],
                'banner_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Modular Kitchens & Wardrobes',
                'title_bn' => 'মডুলার কিচেন ও ক্লোজেট',
                'slug' => 'modular-kitchens-wardrobes',
                'icon' => 'layers',
                'short_description' => 'Ergonomic culinary sanctuaries featuring Blum hardware, sintered stone counters, and concealed organizers.',
                'short_description_bn' => 'আধুনিক ব্লাম ফিটিংস, মার্বেল ফিনিশ এবং স্মার্ট স্পেস অর্গানাইজার সমন্বিত লাক্সারি কিচেন।',
                'starting_price_bdt' => 350000.00,
                'features' => ['Austrian Blum soft-close mechanisms', 'Anti-scratch acrylic and nano-matte finishes', 'Concealed LED strip profiles', 'Integrated appliance cabinetry'],
                'banner_image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Living & Bedroom Sanctuaries',
                'title_bn' => 'লিভিং ও বেডরুম সলিউশন',
                'slug' => 'living-bedroom-sanctuaries',
                'icon' => 'moon',
                'short_description' => 'Harmonious private retreats crafted with tactile velvets, fluted oak paneling, and indirect warm illumination.',
                'short_description_bn' => 'শান্ত ও আরামদায়ক ব্যক্তিগত আবাসের জন্য উডেন প্যানেলিং এবং সফট লাইটিং সংবলিত স্পেস।',
                'starting_price_bdt' => 150000.00,
                'features' => ['Acoustically insulated wall paneling', 'Custom motorized drapery integration', 'Bespoke headboard architecture', 'Dimmable smart scene controllers'],
                'banner_image' => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 4,
                'is_featured' => true,
            ],
            [
                'title' => '3D Architectural Visualization & VR',
                'title_bn' => 'থ্রিডি আর্কিটেকচারাল ভিজ্যুয়ালাইজেশন',
                'slug' => '3d-architectural-visualization',
                'icon' => 'box',
                'short_description' => 'Photorealistic ray-traced renders and interactive walkthroughs that let you inhabit your space before breaking ground.',
                'short_description_bn' => 'নির্মাণকাজ শুরুর পূর্বেই ফটো-রিয়ালিস্টিক থ্রিডি রেন্ডার এবং ভার্চুয়াল ওয়াকথ্রু অভিজ্ঞতা।',
                'starting_price_bdt' => 60000.00,
                'features' => ['4K photorealistic ray-traced imagery', 'Interactive 360-degree virtual tour', 'Accurate daylight and artificial lumen simulation', 'Digital twin material calibration'],
                'banner_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 5,
                'is_featured' => true,
            ],
            [
                'title' => 'Turnkey Fit-out & Execution',
                'title_bn' => 'টার্নকি এক্সিকিউশন ও ফিট-আউট',
                'slug' => 'turnkey-fit-out-execution',
                'icon' => 'check-circle',
                'short_description' => 'Complete end-to-end realization with our dedicated team of master carpenters, electricians, and site supervisors.',
                'short_description_bn' => 'ডিজাইন থেকে শুরু করে চূড়ান্ত চাবি হস্তান্তর পর্যন্ত শতভাগ দায়িত্বসহ সম্পূর্ণ এক্সিকিউশন।',
                'starting_price_bdt' => 500000.00,
                'features' => ['Guaranteed timeline milestone deliveries', 'Zero hidden cost budget guarantee', 'Dedicated site project manager', '5-year structural workmanship warranty'],
                'banner_image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1600&q=80',
                'sort_order' => 6,
                'is_featured' => true,
            ],
        ];

        foreach ($servicesData as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // 5. Featured Projects
        $projectsData = [
            [
                'title' => 'The Brass & Oak Penthouse',
                'title_bn' => 'দ্য ব্রাস অ্যান্ড ওক পেন্টহাউস',
                'slug' => 'the-brass-oak-penthouse',
                'category_id' => $categories['residential-design']->id,
                'room_type' => 'living',
                'style' => 'Modern',
                'area_sqft' => 4800,
                'location' => 'Gulshan-2, Dhaka',
                'duration' => '5 Months',
                'completion_year' => 2025,
                'client_name' => 'Dr. Rahman & Family',
                'summary' => 'A double-height living pavilion featuring bookmatched Italian Statuario marble, brushed champagne brass accents, and fluted white oak millwork.',
                'description' => 'Conceived as a serene sanctuary elevated high above the bustling capital, this duplex penthouse combines expansive panoramic vistas with intimate acoustic warmth. Custom lighting rings float like celestial sculptures above the central sunken salon.',
                'cover_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1600&q=80',
                'before_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                ],
                'model_3d_path' => 'https://modelviewer.dev/shared-assets/models/Chair.glb',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Minimalist Sanctuary Villa',
                'title_bn' => 'মিনিমালিস্ট স্যাঙ্কচুয়ারি ভিলা',
                'slug' => 'minimalist-sanctuary-villa',
                'category_id' => $categories['residential-design']->id,
                'room_type' => 'bedroom',
                'style' => 'Minimal',
                'area_sqft' => 3600,
                'location' => 'Bashundhara R/A, Dhaka',
                'duration' => '4 Months',
                'completion_year' => 2025,
                'client_name' => 'Syed A. Hasan',
                'summary' => 'Japandi aesthetic merging warm textured micro-cement walls, raw linen textures, and cantilevered walnut platform beds.',
                'description' => 'Stripping away clutter to reveal spatial poetry. Every storage element is completely flush with the lime-plastered partition walls, creating a meditative retreat bathed in filtered daylight.',
                'cover_image' => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1600&q=80',
                'before_image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=1200&q=80',
                ],
                'model_3d_path' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Apex Horizon Executive Headquarters',
                'title_bn' => 'এপেক্স হরাইজন এক্সিকিউটিভ হেডকোয়ার্টার্স',
                'slug' => 'apex-horizon-executive-headquarters',
                'category_id' => $categories['corporate-offices']->id,
                'room_type' => 'office',
                'style' => 'Contemporary',
                'area_sqft' => 8500,
                'location' => 'Banani C/A, Dhaka',
                'duration' => '6 Months',
                'completion_year' => 2024,
                'client_name' => 'Apex Venture Capital',
                'summary' => 'A flagship corporate workspace balancing biophilic indoor courtyards with smoked glass boardrooms and acoustic felt baffles.',
                'description' => 'Designed to communicate financial prestige while offering agile collaborative hubs for 120 senior executives and investment analysts.',
                'cover_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80',
                'before_image' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200&q=80',
                ],
                'model_3d_path' => 'https://modelviewer.dev/shared-assets/models/Chair.glb',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Culinary Atelier & Wine Lounge',
                'title_bn' => 'কুলিনারি আতেলিয়ে ও ওয়াইন লাউঞ্জ',
                'slug' => 'culinary-atelier-wine-lounge',
                'category_id' => $categories['modular-kitchens']->id,
                'room_type' => 'kitchen',
                'style' => 'Modern',
                'area_sqft' => 1200,
                'location' => 'Baridhara Diplomatic Zone, Dhaka',
                'duration' => '3 Months',
                'completion_year' => 2025,
                'client_name' => 'Ambassadorial Residence',
                'summary' => 'Monolithic Nero Marquina granite island with cantilevered breakfast bar, concealed spice larders, and Miele smart appliances.',
                'description' => 'A show kitchen engineered for both gourmet family cooking and state entertainment. Seamless touch-to-open doors conceal all service functions.',
                'cover_image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1600&q=80',
                'before_image' => 'https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=1200&q=80',
                'after_image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                ],
                'model_3d_path' => 'https://modelviewer.dev/shared-assets/models/Chair.glb',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projectsData as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }

        // 6. Testimonials
        $testimonialsData = [
            [
                'client_name' => 'Farhana & Tanvir Ahmed',
                'client_designation' => 'Owners, The Brass & Oak Penthouse, Gulshan-2',
                'client_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'project_name' => 'The Brass & Oak Penthouse',
                'rating' => 5,
                'quote' => 'Asad Interior turned our 4,800 sq ft shell into a breathtaking sanctuary. The 3D VR simulation matched the finished reality down to the millimetre. Their turnkey team executed on schedule without a single budget overrun.',
                'quote_bn' => 'আসাদ ইন্টেরিয়র আমাদের গুলশানের পেন্টহাউসটিকে এক অনন্য শান্তিময় শিল্পে রূপান্তর করেছে। থ্রিডি রেন্ডার যা ছিল, বাস্তবে হুবহু তাই পেয়েছি। তাদের দায়িত্বশীলতা প্রশংসনীয়।',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Mustafa Kamal Chowdhury',
                'client_designation' => 'Managing Director, Apex Venture Capital',
                'client_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'project_name' => 'Apex Horizon Executive Headquarters',
                'rating' => 5,
                'quote' => 'Our international investors are mesmerized every time they step into our Banani headquarters. The acoustic detailing and custom brass lighting define corporate luxury in Bangladesh.',
                'quote_bn' => 'আমাদের বনানীর হেডকোয়ার্টারে পদার্পণ করলেই আন্তর্জাতিক বিনিয়োগকারীরা মুগ্ধ হন। তাদের অ্যাকোস্টিক ডিজাইন এবং লাক্সারি ফিনিশিং সত্যিই অসাধারণ।',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Ayesha Siddiqua',
                'client_designation' => 'Homeowner, Bashundhara R/A',
                'client_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'project_name' => 'Minimalist Sanctuary Villa',
                'rating' => 5,
                'quote' => 'The team’s respect for natural materials, silence, and clean lines is rare. Every morning feels like waking up in a 5-star Kyoto boutique retreat right here in Dhaka.',
                'quote_bn' => 'প্রাকৃতিক উপাদান এবং মিনিমালিজমের প্রতি আসাদ টিমের গভীর মনোযোগ বিরল। প্রতিদিনের সকাল যেন এক আন্তর্জাতিক মানের শান্তি নিয়ে আসে।',
                'is_featured' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonialsData as $testimonial) {
            Testimonial::firstOrCreate(
                ['client_name' => $testimonial['client_name']],
                $testimonial
            );
        }

        // 7. Team Members
        $teamData = [
            [
                'name' => 'Ar. Asaduzzaman (Asad)',
                'role' => 'Founder & Principal Architect',
                'role_bn' => 'প্রতিষ্ঠাতা ও প্রধান স্থপতি',
                'bio' => 'Graduated from BUET with Master of Architecture from Politecnico di Milano. 12+ years pioneering contextual luxury across South Asia.',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'instagram_url' => 'https://instagram.com',
                'sort_order' => 1,
            ],
            [
                'name' => 'Nusrat Jahan',
                'role' => 'Director of Interior Styling & FF&E',
                'role_bn' => 'পরিচালক, ইন্টেরিয়র স্টাইলিং ও আসবাব',
                'bio' => 'Curates rare textiles, tactile stone slabs, and heritage artisanal metalcraft to imbue every residence with distinct soul.',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'instagram_url' => 'https://instagram.com',
                'sort_order' => 2,
            ],
            [
                'name' => 'Mahmudul Hassan',
                'role' => 'Head of 3D Visualization & VR',
                'role_bn' => 'প্রধান, থ্রিডি ও ভার্চুয়াল রিয়েলিটি',
                'bio' => 'Master of Unreal Engine and photorealistic rendering, translating conceptual blueprints into immersive real-time digital twins.',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'instagram_url' => 'https://instagram.com',
                'sort_order' => 3,
            ],
            [
                'name' => 'Engr. Tareq Enam',
                'role' => 'Chief Project Execution Engineer',
                'role_bn' => 'প্রধান প্রকল্প বাস্তবায়ন প্রকৌশলী',
                'bio' => 'Oversees our carpentry atelier, MEP integrations, and rigorous quality control across all active building sites.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'instagram_url' => 'https://instagram.com',
                'sort_order' => 4,
            ],
        ];

        foreach ($teamData as $member) {
            TeamMember::firstOrCreate(
                ['name' => $member['name']],
                $member
            );
        }

        // 8. FAQs
        $faqsData = [
            [
                'category' => 'pricing',
                'question' => 'How do you calculate interior design and turnkey execution costs in Dhaka?',
                'question_bn' => 'ঢাকায় ইন্টেরিয়র ডিজাইন ও সম্পূর্ণ কাজের খরচ কীভাবে নির্ধারণ করা হয়?',
                'answer' => 'Our pricing is structured transparently based on square footage and finish tier. Standard turnkey execution begins at ৳1,800/sq ft, Premium finishes at ৳2,800/sq ft, and Bespoke Luxury (imported marbles, Blum hardware, acoustic veneer) ranges between ৳3,800–৳5,500/sq ft. We provide a detailed Bill of Quantities (BOQ) with zero hidden fees.',
                'answer_bn' => 'আমাদের খরচ নির্ধারণ সম্পূর্ণ স্বচ্ছ। প্রতি বর্গফুট স্ট্যান্ডার্ড টার্নকি শুরু হয় ১,৮০০ টাকা থেকে, প্রিমিয়াম ২,৮০০ টাকা এবং বিলাসবহুল ফিনিশ ৩,৮০০ থেকে ৫,৫০০ টাকা পর্যন্ত হতে পারে।',
                'sort_order' => 1,
            ],
            [
                'category' => 'process',
                'question' => 'How long does a typical full-apartment interior project take?',
                'question_bn' => 'একটি সম্পূর্ণ ফ্ল্যাটের ইন্টেরিয়র কাজে সাধারণত কত সময় লাগে?',
                'answer' => 'A standard 2,500 to 3,500 sq ft residence takes approximately 90 to 120 days from concept approval to handover. We dedicate the first 3 weeks strictly to 3D architectural visualization, material approvals, and factory fabrication before civil site work commences.',
                'answer_bn' => 'ধারণাগত অনুমোদন থেকে হ্যান্ডওভার পর্যন্ত প্রায় ৯০ থেকে ১২০ দিন সময় লাগে। প্রাথমিক ৩ সপ্তাহ থ্রিডি ডিজাইন ও ম্যাটেরিয়াল ফাইনাল করার জন্য বরাদ্দ থাকে।',
                'sort_order' => 2,
            ],
            [
                'category' => 'turnkey',
                'question' => 'What warranties do you provide on turnkey craftsmanship and hardware?',
                'question_bn' => 'কাজের ফিনিশিং এবং হার্ডওয়্যারে আপনারা কী ধরনের ওয়ারেন্টি প্রদান করেন?',
                'answer' => 'We offer a 5-Year comprehensive structural warranty on all factory-fabricated millwork and modular cabinetry, lifetime replacement warranty on Austrian Blum hinges and runners, and 1-Year complimentary quarterly maintenance visits.',
                'answer_bn' => 'আমরা সকল ক্যাবিনেট্রি ও কাঠের কাজে ৫ বছরের স্ট্রাকচারাল ওয়ারেন্টি এবং ব্লাম ফিটিংসে লাইফটাইম রিপ্লেসমেন্ট ওয়ারেন্টি প্রদান করি।',
                'sort_order' => 3,
            ],
            [
                'category' => 'general',
                'question' => 'Can we view our apartment in 3D VR before starting carpentry?',
                'question_bn' => 'কাজ শুরু করার আগে কি পুরো অ্যাপার্টমেন্টটি থ্রিডিতে দেখা সম্ভব?',
                'answer' => 'Yes! Every project includes photorealistic 4K renders and our interactive web-based 3D showcase. You can also visit our Gulshan design studio to experience your space in a virtual reality headset with real-time lighting and finish toggling.',
                'answer_bn' => 'হ্যাঁ, প্রতিটি ক্লায়েন্টের জন্য আমরা ৪কে থ্রিডি রেন্ডার এবং আমাদের স্টুডিওতে ভিআর হেডসেটের মাধ্যমে রিয়েল-টাইম ওয়াকথ্রু প্রদর্শন করি।',
                'sort_order' => 4,
            ],
        ];

        foreach ($faqsData as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }

        // 9. Blog Posts
        $postsData = [
            [
                'author_id' => $admin->id,
                'title' => 'Elevating Minimalist Living in Dhaka: The Fusion of Warm Oak & Micro-Cement',
                'title_bn' => 'ঢাকায় মিনিমালিস্ট জীবনধারা: উষ্ণ কাঠ ও মাইক্রো-সিমেন্টের মেলবন্ধন',
                'slug' => 'elevating-minimalist-living-dhaka',
                'category' => 'Design Philosophy',
                'excerpt' => 'How intelligent spatial editing and organic textures transform compact urban high-rises into meditative sanctuaries.',
                'content' => 'In a bustling metropolis like Dhaka where the external environment is dense with kinetic energy, our homes must serve as tranquil sensory antidotes. By replacing ornate surface clutter with honest natural materials—warm Burmese teak, textured lime wash, and monolithic fluted stone—we cultivate visual quietude that revitalizes the spirit.',
                'cover_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'tags' => ['Minimalism', 'Urban Living', 'Dhaka Interiors', 'Natural Materials'],
                'views_count' => 842,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'author_id' => $admin->id,
                'title' => 'The Art of Circadian Lighting: Sculpting Mood in Modern Luxury Penthouses',
                'title_bn' => 'সার্কাডিয়ান লাইটিং: আধুনিক লাক্সারি পেন্টহাউসে আলোর নান্দনিক ব্যবহার',
                'slug' => 'the-art-of-circadian-lighting',
                'category' => 'Lighting Architecture',
                'excerpt' => 'Why indirect architectural illumination and tunable 2700K warm LEDs are essential for well-being and visual depth.',
                'content' => 'Great interior design is fundamentally the art of controlling light and shadow. Harsh overhead downlights flatten architectural volume. At Asad Interior Design, we orchestrate hidden cove lighting, grazing wall washers, and sculptural focal fixtures that mimic the natural sun cycle from invigorating dawn to soothing dusk.',
                'cover_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                'tags' => ['Lighting Design', 'Penthouse', 'Smart Home', 'Luxury'],
                'views_count' => 621,
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'author_id' => $admin->id,
                'title' => 'Engineering the Perfect Culinary Atelier: Blum Hardware Meets Sintered Stone',
                'title_bn' => 'আধুনিক স্মার্ট কিচেন: ব্লাম হার্ডওয়্যার ও সিন্টার্ড স্টোনের সমন্বয়',
                'slug' => 'engineering-the-perfect-culinary-atelier',
                'category' => 'Kitchen Innovation',
                'excerpt' => 'Exploring the ergonomics and material science behind contemporary zero-maintenance modular kitchens in Bangladesh.',
                'content' => 'The kitchen has evolved into the emotional anchor of the home. By utilizing scratch-proof, heat-resistant sintered stone surfaces and precision Austrian soft-close hardware, we craft kitchens that retain their flawless factory aesthetic for decades while enhancing daily culinary joy.',
                'cover_image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                'tags' => ['Modular Kitchen', 'Interior Engineering', 'Blum', 'Dhaka Living'],
                'views_count' => 915,
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($postsData as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 10. Sample Inquiries for CRM
        $firstService = Service::first();
        $inquiriesData = [
            [
                'booking_number' => 'RIME-2026-1001',
                'name' => 'Zafar Iqbal',
                'email' => 'zafar@example.com',
                'phone' => '+880 1712 345 678',
                'service_id' => $firstService?->id,
                'property_type' => 'Penthouse',
                'budget_range' => '৳30–60 Lakh',
                'area_sqft' => 3800,
                'preferred_date' => now()->addDays(3)->toDateString(),
                'preferred_time' => '11:30 AM',
                'message' => 'Looking for full turnkey interior architecture for a newly handed over Gulshan penthouse.',
                'status' => 'New',
            ],
            [
                'booking_number' => 'RIME-2026-1002',
                'name' => 'Nadia Karim',
                'email' => 'nadia@example.com',
                'phone' => '+880 1819 555 222',
                'service_id' => $firstService?->id,
                'property_type' => 'Apartment',
                'budget_range' => '৳15–30 Lakh',
                'area_sqft' => 2200,
                'preferred_date' => now()->addDays(5)->toDateString(),
                'preferred_time' => '03:00 PM',
                'message' => 'Interested in Japandi minimal living room & modular kitchen renovation in Banani.',
                'status' => 'Quoted',
            ],
            [
                'booking_number' => 'RIME-2026-1003',
                'name' => 'Rezaul Haque',
                'email' => 'rezaul@example.com',
                'phone' => '+880 1911 888 999',
                'service_id' => $firstService?->id,
                'property_type' => 'Office',
                'budget_range' => '৳60+ Lakh',
                'area_sqft' => 5400,
                'preferred_date' => now()->subDays(2)->toDateString(),
                'preferred_time' => '02:00 PM',
                'message' => 'Corporate headquarters interior fit-out with acoustic executive pods.',
                'status' => 'Won',
            ],
        ];

        foreach ($inquiriesData as $inq) {
            Inquiry::firstOrCreate(['booking_number' => $inq['booking_number']], $inq);
        }
    }
}
