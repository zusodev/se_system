<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFailedTargetUserRequest;
use App\Repositories\UploadFailedTargetUserRepository;
use function request;
use function view;

class UploadFailedTargetUserController extends Controller
{
    private $repository;

    public function __construct(UploadFailedTargetUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(UploadFailedTargetUserRequest $request)
    {
        $paginator = $this->repository->paginate();
        $paginator->appends(request()->input());
        return view("uploadFailedTargetUser.index", [
            "paginator" => $paginator,
        ]);
    }
}
