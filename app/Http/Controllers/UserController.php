<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use function __;
use function request;
use function view;

class UserController extends Controller
{
    private $service;
    private $repository;

    public function __construct(UserRepository $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(UserRequest $request)
    {
        $where = $request->paginateWhere();
        $paginator = $this->repository->paginate($where, ["*"], false);
        $paginator->appends(request()->input());
        return view("user.index", [
            "paginator" => $paginator,
        ]);
    }

    public function create()
    {
        return view("user.create", []);
    }

    public function store(UserRequest $request)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(...(
            $this->service->store($attributes)
        ));
    }

    public function edit($id)
    {
        return view("user.edit", [
            "user" => User::find($id),
        ]);
    }

    public function update(User $user, UserRequest $request)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(...(
            $this->service->update($user, $attributes)
        ));
    }

    public function destroy($id)
    {
        $user = User::find($id, ["id", "name", "email"]);

        if (User::count() == 1) {
            $message = "禁止刪除最後的管理者";
            return $this->operationRedirectResponse(false, __($message));
        }

        if (!$user) {
            return $this->operationRedirectResponse(false, __("Id is not valid"));
        }

        return $this->operationRedirectResponse(...(
            $this->service->destroy($user)
        ));
    }
}
