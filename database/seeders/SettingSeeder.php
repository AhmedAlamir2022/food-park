<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = array(
            array(
                "id" => 1,
                "key" => "site_name",
                "value" => "Food Park",
                "created_at" => "2025-08-05 10:31:55",
                "updated_at" => "2025-08-06 06:19:16",
            ),
            array(
                "id" => 2,
                "key" => "site_default_currency",
                "value" => "USD",
                "created_at" => "2025-08-05 10:31:55",
                "updated_at" => "2025-08-06 06:56:35",
            ),
            array(
                "id" => 3,
                "key" => "site_currency_icon",
                "value" => "$",
                "created_at" => "2025-08-05 10:31:55",
                "updated_at" => "2025-08-06 03:43:30",
            ),
            array(
                "id" => 4,
                "key" => "site_currency_icon_position",
                "value" => "left",
                "created_at" => "2025-08-05 10:31:55",
                "updated_at" => "2023-08-06 07:30:18",
            ),
            array(
                "id" => 5,
                "key" => "site_delivery_charge",
                "value" => "50",
                "created_at" => "2025-08-05 03:43:44",
                "updated_at" => "2025-08-06 03:43:44",
            ),
            array(
                "id" => 6,
                "key" => "logo",
                "value" => "/uploads/media_688e2ebcb9790.png",
                "created_at" => "2025-08-05 09:27:14",
                "updated_at" => "2025-08-05 10:05:49",
            ),
            array(
                "id" => 7,
                "key" => "footer_logo",
                "value" => "/uploads/media_688e2ebcc3160.png",
                "created_at" => "2025-08-05 09:27:14",
                "updated_at" => "2025-08-05 09:28:55",
            ),
            array(
                "id" => 8,
                "key" => "favicon",
                "value" => "/uploads/media_688e2ebcc69f8.png",
                "created_at" => "2025-08-05 09:27:14",
                "updated_at" => "2025-08-05 09:28:55",
            ),
            array(
                "id" => 9,
                "key" => "breadcrumb",
                "value" => "/uploads/media_688e31a579903.jpg",
                "created_at" => "2025-08-05 09:27:14",
                "updated_at" => "2025-08-05 09:28:55",
            ),
            array(
                "id" => 10,
                "key" => "site_email",
                "value" => "foodpark@gmail.com",
                "created_at" => "2025-08-05 11:18:32",
                "updated_at" => "2025-08-05 11:18:32",
            ),
            array(
                "id" => 11,
                "key" => "site_phone",
                "value" => "+96487452145214",
                "created_at" => "2025-08-05 11:18:32",
                "updated_at" => "2025-08-05 11:18:32",
            ),
            array(
                "id" => 12,
                "key" => "site_color",
                "value" => "#ed7011",
                "created_at" => "2025-08-05 04:02:41",
                "updated_at" => "2025-08-05 04:15:30",
            ),
            array(
                "id" => 13,
                "key" => "seo_title",
                "value" => "Food Park",
                "created_at" => "2025-08-05 05:17:55",
                "updated_at" => "2025-08-05 05:17:55",
            ),
            array(
                "id" => 14,
                "key" => "seo_description",
                "value" => "Discover the tastiest dishes at Food Park! Your ultimate destination for a premium food experience from top restaurants and global cuisines. Fast service and unmatched quality.",
                "created_at" => "2025-08-05 05:17:55",
                "updated_at" => "2025-08-05 05:17:55",
            ),
            array(
                "id" => 15,
                "key" => "seo_keywords",
                "value" => "Food Park, food delivery, restaurants, fast food, healthy meals, international cuisine, online food order, tasty meals, food app, food park, food park app, food park delivery",
                "created_at" => "2025-08-05 05:17:55",
                "updated_at" => "2025-08-05 05:17:55",
            ),
        );

        DB::table('settings')->insert($settings);
    }
}
