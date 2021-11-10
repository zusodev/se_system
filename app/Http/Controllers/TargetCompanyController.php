<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetCompanyRequest;
use App\Models\TargetCompany;
use App\Repositories\TargetCompanyRepository;
use App\Services\TargetCompanyService;
use DB;
use function __;
use function request;
use function view;

class TargetCompanyController extends Controller
{
    private $service;
    private $repository;

    public function __construct(
        TargetCompanyService $service,
        TargetCompanyRepository $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index()
    {
        [$paginator, $countMap] = $this->service->paginate();
        $paginator->appends(request()->input());

        return view("target-company.index", [
            "paginator" => $paginator,
            "countMap" => $countMap,
        ]);
    }

    public function create()
    {
        return view("target-company.create", []);
    }

    public function store(TargetCompanyRequest $request)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(
            ...($this->service->store($attributes))
        );
    }

    public function edit(TargetCompany $targetCompany)
    {
        return view("target-company.edit", [
            "company" => $targetCompany,
        ]);
    }

    public function update(TargetCompanyRequest $request, TargetCompany $targetCompany)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(
            ...($this->service->update($targetCompany, $attributes))
        );
    }

    public function destroy(TargetCompany $targetCompany)
    {
        if (!$targetCompany) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        return $this->operationRedirectResponse(
            ...($this->service->destroy($targetCompany))
        );
    }

    public function storeImage()
    {

    }
}
