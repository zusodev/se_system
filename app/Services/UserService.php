<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserService extends BaseService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attributes): array
    {
        try {
            $this->result = (bool)$this->repository->create($attributes);
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function update(User $user, array $attributes)
    {
        try {
            $this->result = $user->update($attributes);
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function destroy(User $user): array
    {
        try {
            $this->result = (bool)$user->delete();
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $user->name . " " . $this->newResultMessage()
        ];
    }
}
