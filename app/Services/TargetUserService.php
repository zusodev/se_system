<?php


namespace App\Services;


use App\Http\Requests\TargetUserRequest;
use App\Models\TargetCompany;
use App\Models\TargetUser;
use App\Repositories\TargetDepartmentRepository;
use App\Repositories\TargetUserRepository;
use App\Repositories\UploadFailedTargetUserRepository;
use App\Rules\TargetUserEmailUniqueRule;
use DB;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Iterator;
use League\Csv\Reader;
use Log;
use function is_array;
use function now;
use function trim;

class TargetUserService extends BaseService
{
    private $repository;
    private $targetDepartmentRepository;
    /**
     * @var TargetCompany
     */
    private $company;

    public function __construct(TargetUserRepository $repository, TargetDepartmentRepository $targetDepartmentRepository)
    {
        $this->repository = $repository;
        $this->targetDepartmentRepository = $targetDepartmentRepository;
    }

    public function store(Collection $attributes)
    {
        try {
            DB::beginTransaction();
            if (!$this->repository::checkUserEmailIsValid(
                $attributes["email"],
                $attributes["department_id"]
            )) {
                throw new Exception("信箱已被使用在於此公司(1)");
            }
            $result = (bool)$this->repository->create($attributes->toArray());
            $message = $this->resultMessage($result, self::IS_CREATE);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $result = false;
            $message = $this->resultMessage($result, self::IS_CREATE, $e);
        }

        $name = $attributes["name"];
        return [$result, $name . " " . $message];
    }

    public function uploadStore(TargetCompany $company, string $fileName, string $filePath)
    {
        $this->company = $company;
        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $this->insertRecordsToDB($fileName, $csv->getRecords());
            $result = true;
            $message = $this->resultMessage($result, self::IS_CREATE);
        } catch (Exception $e) {
            $result = false;
            $message = $this->resultMessage($result, self::IS_CREATE, $e);
        }
        return [$result, $fileName . " " . $message];
    }

    public function update(TargetUser $user, Collection $attributes)
    {
        try {
            DB::beginTransaction();
            if (!$this->repository::checkUserEmailIsValidExcept(
                $attributes["email"],
                $attributes["department_id"],
                $user->id
            )) {
                throw new Exception("信箱已被使用在於此公司(2)");
            }
            $result = $user->update($attributes->toArray());
            $message = $this->resultMessage($result, self::IS_UPDATE);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $result = false;
            $message = $this->resultMessage($result, self::IS_UPDATE, $e);
        }
        return [$result, $message];
    }

    public function destroy(TargetUser $user)
    {
        try {
            $result = $user->delete();
            $message = $this->resultMessage($result, self::IS_DELETE);
        } catch (Exception $e) {
            $result = false;
            $message = $this->resultMessage($result, self::IS_DELETE, $e);
        }

        $name = $user->name;
        return [$result, $name . " " . $message];
    }

    /**
     * @param string $fileName
     * @param $records
     */
    private function insertRecordsToDB(string $fileName, Iterator $records): void
    {
        $createAt = now();
        $targetDepartments = Collection::make();
        foreach ($records as $offset => $record) {
            try {
                if ($offset == 0) {
                    continue;
                }
                if (!is_array($record)) {
                    throw new Exception("It not CSV");
                }

                DB::beginTransaction();
                $departmentName = trim($record[1]);
                $departmentId = $this->departmentIdAfterCreateOrFind($targetDepartments, $departmentName);

                $fields = [
                    "name" => trim($record[0]),
                    "department_id" => $departmentId,
                    "email" => trim($record[2]),
                ];

                $validator = $this->checkTargetUserFieldsIsInvalid($fields);
                if ($validator->fails()) {
                    $fields["reason"] = $validator->errors()->toJson();
                    $this->createFailed($fileName, $createAt, $fields);
                    DB::rollBack();
                    continue;
                }

                $result = $this->repository->create($fields);
                if (!$result) {
                    throw new Exception("failed without any message");
                }
                DB::commit();;
            } catch (Exception $e) {
                DB::rollBack();
                $fields["reason"] = $e->getMessage();
                $this->createFailed($fileName, $createAt, $fields);
            }
        }
    }

    private function departmentIdAfterCreateOrFind(Collection $targetDepartments, string $departmentName): int
    {
        if (isset($targetDepartments[$departmentName])) {
            $departmentId = $targetDepartments[$departmentName];
        } else {
            $attributes = [
                "company_id" => $this->company->id,
                "name" => $departmentName,
            ];
            $department = $this->targetDepartmentRepository->firstOrCreate($attributes);
            $targetDepartments[$department->name] = $department->id;
            $departmentId = $department->id;
        }
        return $departmentId;
    }

    private function createFailed(string $fileName, Carbon $uploadedAt, array $FailedRecordFields)
    {
        $FailedRecordFields["file_name"] = $fileName;
        $FailedRecordFields["uploaded_at"] = $uploadedAt;
        $FailedRecordFields["company_name"] = $this->company->name;
        try {
            UploadFailedTargetUserRepository::modelCreate($FailedRecordFields);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    private function checkTargetUserFieldsIsInvalid(array $fields)
    {
        $rules = TargetUserRequest::storeRules();

        $rules["email"][] = new TargetUserEmailUniqueRule($this->company->id);

        unset($rules["department_id"]);

        $valiator = Validator::make($fields, $rules);
        return $valiator;
    }
}
