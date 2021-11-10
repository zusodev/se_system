<?php


namespace App\Services;


use App\Models\TargetDepartment;
use App\Repositories\TargetDepartmentRepository;
use Exception;

class TargetDepartmentService extends BaseService
{

    private $repository;

    public function __construct(TargetDepartmentRepository $repository)
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

    public function update(TargetDepartment $department, array $attributes)
    {
        try {
            $this->result = (bool)$department->update($attributes);
        } catch (Exception $e) {
            $this->setFailResult($e);
        }
        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function destroy(TargetDepartment $targetDepartment): array
    {

        try {
            $result = $targetDepartment->delete();
            $message = $this->resultMessage($result, null);
        } catch (Exception $e) {
            $result = false;
            $message = $this->resultMessage($result, null, $e);
        }

        return [$result, $targetDepartment->name . " " . $message];
    }
}
