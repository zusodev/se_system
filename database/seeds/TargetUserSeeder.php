<?php

use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use App\Services\TargetUserService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TargetUserSeeder extends Seeder
{
    public function run(
        TargetUserService $service,
        TargetDepartmentRepository $departmentRepository
    )
    {
        if (env("APP_ENV") == "local") {
            $departmentRepository->create([
                "name" => 'test',
                "company_id" => 1,
            ]);
            /*$departmentRepository->create([
                "name" => 'test_second',
                "company_id" => 1,
            ]);*/
            $service->store(Collection::make([
                "name" => 'matt',
                "email" => "matt@zuso.ai",
                "department_id" => 1,
            ]));

            /*$service->store(Collection::make([
                "name" => 'matt(self)',
                "email" => "mpp21x@gmail.com",
                "department_id" => 1,
            ]));*/
        }
    }
}
