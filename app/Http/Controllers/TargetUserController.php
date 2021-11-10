<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetUserRequest;
use App\Models\TargetCompany;
use App\Models\TargetUser;
use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use App\Repositories\TargetUserRepository;
use App\Repositories\UploadFailedTargetUserRepository;
use App\Services\TargetUserService;
use Illuminate\Support\Str;
use function __;
use function is_numeric;
use function request;
use function response;
use function storage_path;
use function urlencode;
use function view;


class TargetUserController extends Controller
{
    private $repository;
    private $service;

    public function __construct(TargetUserRepository $repository, TargetUserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(
        TargetUserRequest $request,
        TargetDepartmentRepository $departmentRepository,
        TargetCompanyRepository $companyRepository
    )
    {
        /**
         * 有 department_id 代表 "有可能" 是從 target_department index 來的
         */
        $paginator = $this->repository->paginateJoinDepartment(
            ...($request->paginateWhere())
        );
        $paginator->appends(request()->input());

        /**
         * 有 company_id 代表是從 target_comapany index 來的
         */
        $company = is_numeric(request("company_id")) ?
            $companyRepository->find((int)request("company_id")) :
            null;

        $department = is_numeric(request("department_id")) ?
            $departmentRepository->find(request("department_id")) :
            null;
        if (!$company && !$department) {
            abort(404);
        }

        if (!$company && $department) {
            $company = $department->targetCompany;
        }

        return view("target-user.index", [
            "paginator" => $paginator,
            "departments" => $departmentRepository->get(),
            "department" => $department,
            "company" => $company
        ]);
    }

    public function create(TargetCompanyRepository $companyRepository)
    {
        [$companies, $deparmentsMap] = $this->getEditFormOptions($companyRepository);

        return view("target-user.create", [
            "companies" => $companies,
            "companyIds" => $companies->pluck("id")->toArray(),
            "deparmentsMap" => $deparmentsMap
        ]);
    }

    public function store(TargetUserRequest $request)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(
            ...($this->service->store($attributes))
        );
    }

    public function downloadExampleCsv()
    {
        echo "\xEF\xBB\xBF";

        $path = storage_path("target_users_example.csv");
        return response()->download($path, "target_users_example.csv", [
            "fileName" => urlencode("target_users_example.csv"),
            "Content-Type" => "text/csv",
            "Accept" => "text/csv",
        ]);
    }

    public function uploadCreate(TargetCompany $targetCompany, UploadFailedTargetUserRepository $repository)
    {

        return view("target-user.upload", [
            "company" => $targetCompany,
            "paginator" => $repository->paginate([
                ["company_name", "=", $targetCompany->name],
            ]),
        ]);
    }

    public function uploadStore(TargetCompany $targetCompany, TargetUserRequest $request)
    {
        $usersFile = $request->file("users_file");
        $extension = $usersFile->getClientOriginalName();
        if (!Str::contains($extension, "csv")) {
            return $this->operationRedirectResponse(false, "invalid file extension");
        }

        return $this->operationRedirectResponse(...($this->service->uploadStore(
            $targetCompany,
            $usersFile->getClientOriginalName(),
            $usersFile->path()
        )));
    }

    public function edit(
        TargetUser $targetUser,
        TargetCompanyRepository $companyRepository
    )
    {
        [$companies, $deparmentsMap] = $this->getEditFormOptions($companyRepository);

        return view("target-user.edit", [
            "user" => $targetUser,
            "companies" => $companies,
            "companyIds" => $companies->pluck("id")->toArray(),
            "deparmentsMap" => $deparmentsMap
        ]);
    }

    public function update($id, TargetUserRequest $request)
    {
        $user = TargetUser::find($id);
        if (!$user) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(...(
        $this->service->update($user, $attributes)
        ));
    }

    public function destroy($id)
    {
        $user = TargetUser::find($id, ["id", "name"]);
        if (!$user) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        return $this->operationRedirectResponse(...(
        $this->service->destroy($user)
        ));
    }

    /**
     * @param TargetCompanyRepository $companyRepository
     * @return array
     */
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
