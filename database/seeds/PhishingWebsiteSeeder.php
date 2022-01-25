<?php

use App\Repositories\PhishingWebsiteRepository;
use Illuminate\Database\Seeder;

class PhishingWebsiteSeeder extends Seeder
{
    public function run(PhishingWebsiteRepository $repository)
    {
        $repository->create([
            'name' => 'facebook',
            'template' => file_get_contents(
                storage_path('default_phishing_website/facebook.html')
            )
        ]);
        $repository->create([
            'name' => 'line',
            'template' => file_get_contents(
                storage_path('default_phishing_website/line.html')
            )
        ]);
    }
}
