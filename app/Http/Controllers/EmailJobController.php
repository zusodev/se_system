<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailJobRequest;
use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailLogRepository;
use App\Repositories\EmailProjectRepository;
use App\Services\EmailJobService;
use Illuminate\Http\Request;
use function now;
use function request;
use function route;
use function view;

class EmailJobController extends Controller
{
    private $repository;
    private $service;

    public function __construct(EmailJobRepository $repository, EmailJobService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(EmailJobRequest $request, EmailProjectRepository $projectRepository)
    {
        $where = $request->paginateWhere();

        $project = $projectRepository->mustfindOne(request("project_id"));
        if ($project) {
            $where[] = [EmailJob::PROJECT_ID, $project->id];
        }

        $paginator = $this->repository->paginateJoinDepartment($where);
        $paginator->appends(request()->input());
//        dd($project->company->id,request()->input());

        return view("email-job.index", [
            "paginator" => $paginator,
//            "groups" => $departmentRepository->get(),
            "project" => $project
        ]);
    }

    /*public function create(TargetDepartmentRepository $departmentRepository)
    {
        $emailTemplates = DB::table(EmailTemplate::TABLE)->get();
        $groups = $departmentRepository->getLeftJoinTargetUserCount();
        return view("email-job.create", [
            "emailTemplates" => $emailTemplates,
            "groups" => $groups
        ]);
    }*/

/*    public function store(EmailJobRequest $request)
    {
        $attributes = $request->formAttributes();
        list($result, $message) = $this->service->store($attributes);
        return $this->operationRedirectResponse($result, $message);
//        for ($i = 0; $i < 200; $i++) {
//            $attributes['name'] = now();
//            list($result, $message) = $this->service->store($attributes);
//
//        }
    }*/

    public function show($id, EmailLogRepository $logRepository)
    {
        $emailJob = $this->repository->findOneJoinTemplateAndDepartment($id);
        if (!$emailJob) {
            $indexRoute = route("emailJobs.index");
            return response()->redirectTo($indexRoute);
        }
        $logPaginator = $logRepository->paginate([
            [EmailLog::T_JOB_ID, $id]
        ]);

        $chartData = $logRepository->getCounts($id);

        return view("email-job.show", [
            "emailJob" => $emailJob,
            "project" => $emailJob->emailProject,
            "logTotal" => $logPaginator->total(),
            "logPaginator" => $logPaginator,
            "chartData" => $chartData->pluck("count"),
        ]);
    }

    public function edit($id)
    {
        return view("emailJob.edit", [
            "model" => EmailJob::find($id),
        ]);
    }

    public function update(EmailJob $job, EmailJobRequest $request)
    {
        $attributes = $request->formAttributes();

        list($result, $message) = $this->service->update($job, $attributes);

        return $this->operationRedirectResponse($result, $message);
    }

//    public function destroy($id)
//    {
//        $user = EmailJob::find($id, ["id", "name"]);
//        if (!$user) {
//            return $this->operationRedirectResponse(false, __("Id is not valid"));
//        }
//        list($result, $message) = $this->service->destroy($user);
//
//        return $this->operationRedirectResponse($result, $message);
//    }

    public function logsCsv(Request $request)
    {
        $hasReport = $request->has("report_download");
        if ($hasReport) {
            return $this->csvResponse(
                $this->service->downloadCsvReport(),
                now()->format("Y-m-d H:i:s") . "_logs"
            );
        }
        $url = route($request->route()->getName(), ["report_download" => true]);

        return view("email-job.download-page", [
            "downloadReportUrl" => $url
        ]);
    }
}
