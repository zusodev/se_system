<?php

use App\Repositories\TargetCompanyRepository;
use Illuminate\Database\Seeder;

class TargetCompanySeeder extends Seeder
{

    public function run(TargetCompanyRepository $companyRepository)
    {

        if (env("APP_ENV") == "local") {
            $companyRepository->create([
                'name' => "zuso",
            ]);


            /*$faker = Faker\Factory::create();
            for ($i = 0; $i < 5; $i++) {
                $companyRepository->create([
                    "name" => $faker->company,
                ]);
            }*/
        }
    }
}
