<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailProjectRequest;
use App\Models\EmailProject;
use App\Models\TargetCompany;
use App\Models\TargetDepartment;
use App\Repositories\EmailProjectRepository;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\PhishingWebsiteRepository;
use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use App\Services\EmailProjectService;
use DB;
use Illuminate\Http\Request;
use function count;
use function dd;
use function in_array;
use function is_null;
use function session;

class EmailProjectController extends Controller
{
    private $repository;
    private $service;

    public function __construct(
        EmailProjectRepository $repository,
        EmailProjectService $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        $lengthAwarePaginator = $this->repository->paginateJoin();
        return view("email-project.index", [
            "paginator" => $lengthAwarePaginator,
        ]);
    }

    public function create(
        EmailTemplateRepository $templateRepository,
        PhishingWebsiteRepository $websiteRepository,
        TargetCompanyRepository $companyRepository
    )
    {
        [$companies, $deparmentsMap] = $this->getEditFormOptions($companyRepository);

        return view("email-project.create", [
            "emailTemplates" => $templateRepository->get(false),
            "phishingWebsites" => $websiteRepository->get(false),

            "companies" => $companies,
            "companyIds" => $companies->pluck("id")->toArray(),
            "deparmentsMap" => $deparmentsMap
        ]);
    }

    public function store(EmailProjectRequest $request, TargetDepartmentRepository $repository)
    {
        $attributes = $request->projectAttributes();
        $departmentIds = $request->get("department_ids");

        if(is_null($departmentIds)){
            return $this->operationRedirectResponse(
                false,
                "尚未選擇部門"
            );
        }



        $isSelectedAll = in_array("all", $departmentIds);
        if($isSelectedAll){
            $targetDepartments = $repository->get(["*"], [["company_id", $attributes["company_id"]]]);

            if ($targetDepartments->isEmpty()) {
                return $this->operationRedirectResponse(
                    false,
                    "此公司部門為空"
                );
            }
            $departmentIds = $targetDepartments->pluck("id")->toArray();
        } else {
            $count = DB::table(TargetDepartment::TABLE)
                ->where([
                    [TargetDepartment::COMPANY_ID, $attributes["company_id"]]
                ])
                ->whereIn("id", $departmentIds)
                ->count();

            if($count !== count($departmentIds)){
                return $this->operationRedirectResponse(
                    false,
                    "部門 id 有誤，請重新輸入"
                );
            }
        }


        return $this->operationRedirectResponse(
            ...($this->service->store($attributes, $departmentIds))
        );
    }

    public function show(EmailProject $emailProject)
    {
        //
    }

    public function edit(EmailProject $emailProject)
    {
        //
    }

    public function update(Request $request, EmailProject $emailProject)
    {
        //
    }

    public function destroy(EmailProject $emailProject)
    {
        //
    }

    protected function getEditFormOptions(TargetCompanyRepository $companyRepository): array
    {
        $companies = $companyRepository->getWithDepartments();

        /** @var array $deparmentsMap
         * key：company_id
         * value：Collection, Departments[]
         */
        $deparmentsMap = $companies->reduce(function (array $deparmentsMap, TargetCompany $company) {
            $deparmentsMap[$company->id] = $company->targetDepartments->toArray();
            return $deparmentsMap;
        }, []);
        return [$companies, $deparmentsMap];
    }
}
