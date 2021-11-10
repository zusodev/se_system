<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$fileNames = ["e_t_resources", "p_w_resources"];
        foreach ($fileNames as $fileName) {
            $storage = Storage::disk("local");
            $path = "public/" . $fileName;

            if ($storage->exists($path)) {
                $storage->deleteDirectory($path);
            }

            $storage->makeDirectory($path);
        }*/

        $this->call([
            UserSeeder::class,
            TargetCompanySeeder::class,
            TargetDepartmentSeeder::class,
            TargetUserSeeder::class,
            PhishingWebsiteSeeder::class,
            EmailTemplateSeeder::class,
            EmailJobSeeder::class,
        ]);
    }
}
