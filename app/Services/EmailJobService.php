<?php


namespace App\Services;


use App\Models\EmailJob;
use App\Models\TargetDepartment;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailLogRepository;
use App\Repositories\TargetDepartmentRepository;
use DB;
use Exception;
use Illuminate\Support\Collection;
use function array_unshift;
use function is_object;
use function stream_get_contents;

class EmailJobService extends BaseService
{
    private $repository;
    private $departmentRepository;
    private $logRepository;

    public function __construct(EmailJobRepository $repository, TargetDepartmentRepository $departmentRepository, EmailLogRepository $logRepository)
    {
        $this->repository = $repository;
        $this->departmentRepository = $departmentRepository;
        $this->logRepository = $logRepository;
    }

    public function store(Collection $attributes): array
    {
        $groups = $this->getStoreGroups($attributes);
        DB::beginTransaction();
        try {
            foreach ($groups as $departmentId) {
                $attributes["department_id"] = $departmentId;
                $this->repository->create($attributes->toArray());
            }
            $result = true;
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

    public function update(EmailJob $job, Collection $attributes)
    {
        try {
            $result = $job->update($attributes->toArray());
            $message = $this->resultMessage($result, self::IS_UPDATE);
        } catch (Exception $e) {
            $result = false;
            $message = $this->resultMessage($result, self::IS_UPDATE, $e);
        }
        return [$result, $message];
    }

    private function getStoreGroups(Collection $attributes)
    {
        $groups = $attributes["groups"];
        if (!$groups[0]) {
            $groups = $this->departmentRepository->getJoinTargetUserCount([
                TargetDepartment::TABLE . ".id"
            ]);
            /* @var TargetDepartment $group */
            $groups = $groups->map(function ($group) {
                return $group->id;
            });
        }
        return $groups;
    }

    public function downloadCsvReport(): string
    {
        $collection = $this->logRepository->allJoinUserJobDepartment()->toArray();
        array_unshift($collection, [
            "??????",
            "??????",
            "Email",
            "??????????????????",
            "???????????? IP",
            "???????????? Agent",
            "??????????????????",
            "??????????????????",
            "???????????? IP",
            "???????????? Agent",
            "??????????????????",
        ]);

        $f = fopen('php://memory', 'r+');
        foreach ($collection as $index => $item) {
            $item = is_object($item) ? (array)$item : $item;
            if($index != 0){
                $item['is_open'] = $item['is_open'] ? "???" : "???";
                $item['open_ip'] = $item['open_ip'] ?? "???";
                $item['open_agent'] = $item['open_agent'] ?? "???";
                $item['open_datetime'] = $item['open_datetime'] ?? "???";

                $item['is_open_link'] = $item['is_open_link'] ? "???" : "???";
                $item['open_link_ip'] = $item['open_link_ip'] ?? "???";
                $item['open_link_agent'] = $item['open_link_agent'] ?? "???";
                $item['open_link_datetime'] = $item['open_link_datetime'] ?? "???";
            }
            fputcsv($f, $item, ",", '"', "\\");
        }
        rewind($f);
        return stream_get_contents($f);
    }

}
