<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use Modules\Setting\Entities\CompanyProfile as EntitiesCompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        EntitiesCompanyProfile::create([
            'company_name' => 'Gwallek Nirman Sewa',
            'company_email' => 'info@gwalleknirmansewa.com',
            'company_phone' => '+977-9800000000',
            'company_address' => 'Dhangadhi, Kailali, Nepal',
            'logo' => 'uploads/logo.png',
            'footer_logo' => 'uploads/footer_logo.png',
            'favicon' => 'uploads/favicon.ico',
            'image' => 'uploads/company_image.jpg',
            'footer_text' => '© 2025 Gwallek Nirman Sewa. All rights reserved.',
            'introduction' => 'Gwallek Nirman Sewa is a Construction Company for Nepal.',
            'vision' => 'To simplify restaurant operations with affordable digital solutions.',
            'mission' => 'Empower restaurants with technology that saves time, cost, and effort.',
            'map' => '<iframe src="https://maps.google.com/..." width="100%" height="200" frameborder="0"></iframe>',
            'facebook' => 'https://facebook.com/gwalleknirmansewa',
            'instagram' => 'https://instagram.com/gwalleknirmansewa',
            'twitter' => 'https://twitter.com/gwalleknirmansewa',
            'youtube' => 'https://youtube.com/gwalleknirmansewa',
            'meta_title' => 'Construction Company | Gwallek Nirman Sewa',
            'meta_description' => 'Affordable Construction Company  in Nepal.',
            'meta_keywords' => 'Construction Company in Nepal, Gwallek Nirman Sewa, Nepal Best Construction Site',
        ]);
    }
}
