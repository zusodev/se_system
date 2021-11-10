<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetDepartmentRequest;
use App\Models\TargetDepartment;
use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use App\Services\TargetDepartmentService;
use function __;
use function is_numeric;
use function is_string;
use function request;
use function response;
use function route;
use function view;

class TargetDepartmentController extends Controller
{
    private $repository;
    private $service;

    public function __construct(TargetDepartmentRepository $repository, TargetDepartmentService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(TargetCompanyRepository $companyRepository)
    {
        $where = [];

        $company = null;
        if (is_numeric(request("company_id"))) {
            $company = $companyRepository->find(request("company_id"));
            $where[] = ["company_id", request("company_id")];
        }

        if (is_string(request('name'))) {
            $where[] = ["name", "LIKE", "%" . request("name") . "%"];
        }

        $paginator = $this->repository->paginateJoinUserJob($where);
        $paginator->appends(request()->input());

        return view("target-department.index", [
            "paginator" => $paginator,
            "company" => $company,
        ]);
    }

    public function create(TargetCompanyRepository $repository)
    {

        return view("target-department.create", [
            "companies" => $repository->get()
        ]);
    }

    public function store(TargetDepartmentRequest $request)
    {
        $attributes = $request->createFormAttributes();

        if (TargetDepartment::where([
            ["name", $attributes["name"]],
            ["company_id", $attributes["company_id"]],
        ])->exists()) {
            return $this->operationRedirectResponse(false, "名稱已重複");
        }

        return $this->operationRedirectResponse(
            ...($this->service->store($attributes))
        );
    }

    public function show()
    {
        return response()->redirectTo(route("target-department.index"));
    }

    public function edit(TargetDepartment $targetDepartment, TargetCompanyRepository $repository)
    {
        return view("target-department.edit", [
            "department" => $targetDepartment,
            "companies" => $repository->get()
        ]);
    }

    public function update(TargetDepartmentRequest $request, TargetDepartment $targetDepartment)
    {
        if (!$targetDepartment) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        $attributes = $request->formAttributes();

        if (TargetDepartment::where([
            ["id", "!=", $targetDepartment->id],
            ["name", $attributes["name"]],
            ["company_id", $targetDepartment->company_id],
        ])->exists()) {
            return $this->operationRedirectResponse(false, "名稱已重複");
        }


        return $this->operationRedirectResponse(
            ...($this->service->update($targetDepartment, $attributes))
        );
    }

    public function destroy(TargetDepartment $targetDepartment)
    {
        if (!$targetDepartment) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        return $this->operationRedirectResponse(
            ...($this->service->destroy($targetDepartment))
        );
    }
}
