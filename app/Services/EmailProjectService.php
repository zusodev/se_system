<?php


namespace App\Services;


use App\Mail\TemplateMail\TemplateExeAttachementGenerator;
use App\Models\EmailProject;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailProjectRepository;
use DB;
use Exception;
use function dd;

class EmailProjectService extends BaseService
{
    /**
     * @var EmailProjectRepository
     */
    private $repository;
    /**
     * @var EmailJobRepository
     */
    private $jobRepository;

    public function __construct(
        EmailProjectRepository $repository,
        EmailJobRepository $jobRepository
    )
    {
        $this->repository = $repository;
        $this->jobRepository = $jobRepository;
    }

    public function store(array $projectAttributes, array $departmentIds)
    {

        DB::beginTransaction();
        try {
            /** @var EmailProject $project */
            $project = $this->repository->create($projectAttributes);
            TemplateExeAttachementGenerator::localStorage()->makeDirectory($project->id);

            $this->result = (bool)$project;


            $jobAttributes = ["project_id" => $project->id];
            foreach ($departmentIds as $departmentId) {
                $jobAttributes["department_id"] = $departmentId;
                $this->jobRepository->create($jobAttributes);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $projectAttributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function update()
    {

    }
}
