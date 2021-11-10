<?php


namespace App\Services;


use App\Models\TargetCompany;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use DB;
use Exception;
use Illuminate\Support\Collection;
use stdClass;
use function array_combine;

class TargetCompanyService extends BaseService
{
    private $repository;
    private $departmentRepository;

    public function __construct(
        TargetCompanyRepository $repository,
        TargetDepartmentRepository $departmentRepository
    )
    {
        $this->repository = $repository;
        $this->departmentRepository = $departmentRepository;
    }

    public function paginate()
    {
        $paginator = $this->repository->paginate();
        $companyIds = $paginator->getCollection()
            ->map(function (TargetCompany $item) {
                return $item->id;
            })->toArray();


        /**
         * @var array $usersCountMap
         * key 是 company_id
         * value 是 { company_id, user_count, group_count }
         */
        $usersCountMap = $this->getUserAndGroupCountByCompanyIds($companyIds);

        return [$paginator, $usersCountMap];
    }

    /**
     * @param array $companyIds
     * @return array|false|Collection
     */
    private function getUserAndGroupCountByCompanyIds(array $companyIds)
    {
        $builder = DB::table(TargetDepartment::TABLE)
            ->whereIn(TargetDepartment::COMPANY_ID, $companyIds)
            ->leftJoin(TargetUser::TABLE, TargetDepartment::ID, "=", TargetUser::DEPARTMENT_ID)
            ->select([TargetDepartment::COMPANY_ID])
            ->selectSub("SELECT COUNT(*) FROM target_user WHERE target_user.department_id = " . TargetDepartment::ID, "user_count")
            ->groupBy(TargetDepartment::ID);

        $raw = DB::raw("( {$builder->toSql()} ) as sub");


        $usersCountMap = Collection::make(
            DB::table($raw)
                ->mergeBindings($builder)
                ->select([
                    "sub.company_id",
                    DB::raw("COUNT(*) as department_count"),
                    DB::raw("SUM(`sub`.user_count) AS user_count")
                ])
                ->groupBy("sub.company_id")
                ->get()
        );

        $keys = $usersCountMap->map(function (stdClass $targetDepartment) {
            return $targetDepartment->company_id;
        })->toArray();

        $values = $usersCountMap->values()->toArray();

        $usersCountMap = array_combine($keys, $values);
        return $usersCountMap;
    }

    public function store(array $attributes)
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

    public function update(TargetCompany $targetCompany, array $attributes)
    {
        try {
            $this->result = (bool)$targetCompany->update($attributes);
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function destroy(TargetCompany $targetCompany)
    {
        try {
            $this->result = (bool)$targetCompany->delete();
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $targetCompany->name . " " . $this->newResultMessage()
        ];
    }
}
