<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Block;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Settings
        Setting::create(['key' => 'site_name', 'value' => 'Bethel Gold']);
        Setting::create(['key' => 'logo_url', 'value' => '/img/Homelogo.jpg']);
        Setting::create(['key' => 'primary_color', 'value' => '#C9A635']); // Gold
        Setting::create(['key' => 'secondary_color', 'value' => '#1A1A2E']); // Deep navy
        Setting::create(['key' => 'contact_phone', 'value' => '+1 (123) 456-7890']);
        Setting::create(['key' => 'contact_email', 'value' => 'info@bethelgoldfirm.com']);
        Setting::create(['key' => 'contact_address', 'value' => '123 Gold Street, Mining District, City']);
        Setting::create(['key' => 'contact_hours', 'value' => 'Monday-Friday: 9am - 5pm']);

        // Menu Items
        $menuItems = [
            ['label' => 'Home', 'url' => '/', 'order' => 1],
            ['label' => 'About Us', 'url' => '/about', 'order' => 2],
            ['label' => 'Buy Gold', 'url' => '/buy-gold', 'order' => 3],
            ['label' => 'Sell Gold', 'url' => '/sell-gold', 'order' => 4],
            ['label' => 'Live Prices', 'url' => '/live-prices', 'order' => 5],
            ['label' => 'Services', 'url' => '/services', 'order' => 6],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 7],
        ];
        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }

        // Pages
        $pages = [
            ['title' => 'Home', 'slug' => 'home', 'status' => 'published', 'meta_description' => 'Bethel Gold - Excellence in Gold Trading & Mining'],
            ['title' => 'About Us', 'slug' => 'about', 'status' => 'published', 'meta_description' => 'Learn about Bethel Gold, your trusted partner in gold trading and mining'],
            ['title' => 'Services', 'slug' => 'services', 'status' => 'published', 'meta_description' => 'Comprehensive gold trading solutions'],
            ['title' => 'Mining', 'slug' => 'mining', 'status' => 'published', 'meta_description' => 'Expert gold mining with state-of-the-art technology'],
            ['title' => 'Assistance', 'slug' => 'assistance', 'status' => 'published', 'meta_description' => 'Supporting miners with essential resources'],
            ['title' => 'Equipment', 'slug' => 'equipment', 'status' => 'published', 'meta_description' => 'Advanced mining equipment for rent'],
            ['title' => 'Contact', 'slug' => 'contact', 'status' => 'published', 'meta_description' => 'Get in touch with our team'],
            ['title' => 'Buy Gold', 'slug' => 'buy-gold', 'status' => 'draft', 'meta_description' => 'Purchase gold coins, bars, and jewelry at competitive prices'],
            ['title' => 'Sell Gold', 'slug' => 'sell-gold', 'status' => 'draft', 'meta_description' => 'Sell your gold with transparent pricing and instant payments'],
            ['title' => 'Live Prices', 'slug' => 'live-prices', 'status' => 'draft', 'meta_description' => 'Real-time gold, silver, and platinum prices'],
        ];
        foreach ($pages as $page) {
            Page::create($page);
        }

        // Blocks for Home Page
        $homePage = Page::where('slug', 'home')->first();
        Block::create([
            'page_id' => $homePage->id,
            'type' => 'hero',
            'content' => json_encode([
                'headline' => 'Excellence in Gold Trading & Mining',
                'subtext' => 'Maximizing profits for our clients and investors through premium gold services',
                'cta_text' => 'Get Started',
                'cta_url' => '/contact',
                'background_image' => '/storage/images/hero-bg.jpeg',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $homePage->id,
            'type' => 'testimonials',
            'content' => json_encode([
                'items' => [
                    [
                        'quote' => 'Bethel Gold has consistently provided excellent returns on our gold investments. Their market knowledge is unparalleled.',
                        'client' => 'James Wilson, Investment Group CEO',
                    ],
                    [
                        'quote' => 'The mining assistance and equipment rental services have transformed our operations. Our yield has increased by 40% since partnering with Bethel Gold.',
                        'client' => 'Sarah Mensah, Mining Cooperative Director',
                    ],
                ],
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for About Page
        $aboutPage = Page::where('slug', 'about')->first();
        Block::create([
            'page_id' => $aboutPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'About Bethel Gold',
                'subtitle' => 'Your trusted partner in gold trading and mining',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $aboutPage->id,
            'type' => 'text_image',
            'content' => json_encode([
                'headline' => 'We Are Industry Leaders',
                'text' => [
                    'Bethel Gold is a financially solid company with many different investment options available. We are equipped to meet various investment styles and risk tolerance levels.',
                    'We\'ve earned a strong reputation in providing the best services in the buying and selling of gold. Our investors expect a consistently great return on their investment, and Bethel Gold more than delivers.',
                    'Our goal is to maximize profits for our clients and investors through strategic gold trading and mining operations.',
                ],
                'image' => '/storage/images/about-img.jpeg',
                'cta_text' => 'Learn More',
                'cta_url' => '/contact',
                'image_position' => 'right',
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Services Page
        $servicesPage = Page::where('slug', 'services')->first();
        Block::create([
            'page_id' => $servicesPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Our Gold Services',
                'subtitle' => 'Comprehensive gold trading solutions',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $servicesPage->id,
            'type' => 'grid',
            'content' => json_encode([
                'items' => [
                    [
                        'icon' => 'fas fa-hand-holding-usd',
                        'title' => 'Gold Buying',
                        'description' => 'We offer competitive rates for gold purchases with transparent pricing and immediate payment.',
                    ],
                    [
                        'icon' => 'fas fa-coins',
                        'title' => 'Gold Selling',
                        'description' => 'Access to international markets ensures you get the best possible price for your gold.',
                    ],
                    [
                        'icon' => 'fas fa-chart-line',
                        'title' => 'Investment Options',
                        'description' => 'Various investment vehicles tailored to your risk tolerance and financial goals.',
                    ],
                ],
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Mining Page
        $miningPage = Page::where('slug', 'mining')->first();
        Block::create([
            'page_id' => $miningPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Our Mining Operations',
                'subtitle' => 'Expert gold mining with state-of-the-art technology',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $miningPage->id,
            'type' => 'text_image',
            'content' => json_encode([
                'headline' => 'Professional Gold Mining',
                'text' => [
                    'With collective individual experience in the mining industry, Bethel Gold is committed to finding and maintaining the best assets. As a respected producer of gold, we are known for our state-of-the-art capabilities and advanced processes to locate and secure the best assets.',
                    'We operate and manage an impressive portfolio of profitable gold mines in some of the most lucrative regions throughout West Africa with a vision of future global presence.',
                    'We are proud to be considered the \'miner of choice\' by our partners, suppliers and peers in the industry.',
                ],
                'image' => '/storage/images/about-img.jpeg',
                'cta_text' => 'Explore Our Mines',
                'cta_url' => '/contact',
                'image_position' => 'left',
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Assistance Page
        $assistancePage = Page::where('slug', 'assistance')->first();
        Block::create([
            'page_id' => $assistancePage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Mining Assistance Services',
                'subtitle' => 'Supporting miners with essential resources',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $assistancePage->id,
            'type' => 'text_image',
            'content' => json_encode([
                'headline' => 'Comprehensive Miner Support',
                'text' => [
                    'We are proud to be recognized as the \'go-to\' source for miners. We help miners by providing capital and essential resources, including personnel, training and logistical support.',
                    'Our team of experts offers guidance on best practices, safety protocols, and efficient extraction methods to maximize yield while minimizing environmental impact.',
                    'We believe in supporting the mining community through knowledge sharing, financial backing, and technical assistance to ensure sustainable and profitable operations for all.',
                ],
                'image' => '/storage/images/about-img.jpeg',
                'cta_text' => 'Get Assistance',
                'cta_url' => '/contact',
                'image_position' => 'right',
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Equipment Page
        $equipmentPage = Page::where('slug', 'equipment')->first();
        Block::create([
            'page_id' => $equipmentPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Equipment Rentals',
                'subtitle' => 'Advanced mining equipment for rent',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $equipmentPage->id,
            'type' => 'grid',
            'content' => json_encode([
                'items' => [
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Excavators & Loaders',
                        'description' => 'Heavy-duty equipment for large-scale mining operations with various size options.',
                    ],
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Processing Equipment',
                        'description' => 'Modern gold processing equipment for efficient extraction and refinement.',
                    ],
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Safety Equipment',
                        'description' => 'Comprehensive safety gear and monitoring systems to protect your workforce.',
                    ],
                ],
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Contact Page
        $contactPage = Page::where('slug', 'contact')->first();
        Block::create([
            'page_id' => $contactPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Contact Us',
                'subtitle' => 'Get in touch with our team',
            ]),
            'order' => 1,
            'status' => 'published',
        ]);
        Block::create([
            'page_id' => $contactPage->id,
            'type' => 'contact',
            'content' => json_encode([
                'info' => [
                    ['icon' => 'fas fa-map-marker-alt', 'detail' => '123 Gold Street, Mining District, City'],
                    ['icon' => 'fas fa-phone', 'detail' => '+1 (123) 456-7890'],
                    ['icon' => 'fas fa-envelope', 'detail' => 'info@bethelgoldfirm.com'],
                    ['icon' => 'fas fa-clock', 'detail' => 'Monday-Friday: 9am - 5pm'],
                ],
                'form' => [
                    'fields' => ['name', 'email', 'subject', 'message'],
                ],
            ]),
            'order' => 2,
            'status' => 'published',
        ]);

        // Blocks for Buy Gold Page (Draft)
        $buyGoldPage = Page::where('slug', 'buy-gold')->first();
        Block::create([
            'page_id' => $buyGoldPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Buy Gold',
                'subtitle' => 'Purchase gold coins, bars, and jewelry at competitive prices',
            ]),
            'order' => 1,
            'status' => 'draft',
        ]);
        Block::create([
            'page_id' => $buyGoldPage->id,
            'type' => 'grid',
            'content' => json_encode([
                'items' => [
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Gold Coins',
                        'description' => 'High-purity gold coins for collectors and investors.',
                    ],
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Gold Bars',
                        'description' => 'Certified gold bars in various weights for secure investment.',
                    ],
                    [
                        'image' => '/storage/images/about-img.jpeg',
                        'title' => 'Gold Jewelry',
                        'description' => 'Elegant gold jewelry with guaranteed authenticity.',
                    ],
                ],
            ]),
            'order' => 2,
            'status' => 'draft',
        ]);
        Block::create([
            'page_id' => $buyGoldPage->id,
            'type' => 'text',
            'content' => json_encode([
                'text' => 'Secure payment options and insured shipping available. Contact our sales team to place your order or inquire about current pricing linked to live market rates.',
                'cta_text' => 'Contact Sales',
                'cta_url' => '/contact',
            ]),
            'order' => 3,
            'status' => 'draft',
        ]);

        // Blocks for Sell Gold Page (Draft)
        $sellGoldPage = Page::where('slug', 'sell-gold')->first();
        Block::create([
            'page_id' => $sellGoldPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Sell Gold',
                'subtitle' => 'Sell your gold with transparent pricing and instant payments',
            ]),
            'order' => 1,
            'status' => 'draft',
        ]);
        Block::create([
            'page_id' => $sellGoldPage->id,
            'type' => 'steps',
            'content' => json_encode([
                'steps' => [
                    [
                        'title' => 'Get a Free Quote',
                        'description' => 'Use our online calculator to estimate your gold’s value based on weight and purity.',
                    ],
                    [
                        'title' => 'Submit Your Gold',
                        'description' => 'Bring or send your gold for professional testing with transparent methods.',
                    ],
                    [
                        'title' => 'Instant Payment',
                        'description' => 'Receive immediate payment via your preferred method with no hidden fees.',
                    ],
                ],
            ]),
            'order' => 2,
            'status' => 'draft',
        ]);
        Block::create([
            'page_id' => $sellGoldPage->id,
            'type' => 'testimonials',
            'content' => json_encode([
                'items' => [
                    [
                        'quote' => 'Selling my gold to Bethel Gold was seamless. The process was transparent, and I got paid instantly!',
                        'client' => 'John Doe, Satisfied Seller',
                    ],
                ],
            ]),
            'order' => 3,
            'status' => 'draft',
        ]);

        // Blocks for Live Prices Page (Draft)
        $livePricesPage = Page::where('slug', 'live-prices')->first();
        Block::create([
            'page_id' => $livePricesPage->id,
            'type' => 'section_title',
            'content' => json_encode([
                'title' => 'Live Prices',
                'subtitle' => 'Real-time gold, silver, and platinum prices',
            ]),
            'order' => 1,
            'status' => 'draft',
        ]);
        Block::create([
            'page_id' => $livePricesPage->id,
            'type' => 'live_prices',
            'content' => json_encode([
                'prices' => [
                    'gold' => 2500.00, // Default prices for seeding
                    'silver' => 30.00,
                    'platinum' => 950.00,
                ],
                'calculator' => true,
            ]),
            'order' => 2,
            'status' => 'draft',
        ]);
    }
}
