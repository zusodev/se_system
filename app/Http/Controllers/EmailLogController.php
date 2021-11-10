<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailLogRequest;
use App\Mailer\AppMailer;
use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Repositories\EmailDetailLogRepository;
use App\Repositories\EmailLogRepository;
use App\Repositories\EmailProjectRepository;
use App\Services\EmailLogCollector;
use function request;
use function response;

class EmailLogController extends Controller
{
    private $repository;

    public function __construct(EmailLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(EmailProjectRepository $projectRepository)
    {
        $where = [];

        $project = $projectRepository->mustfindOne(request("project_id"));
        if ($project) {
            $where[] = [EmailJob::PROJECT_ID, $project->id];
        }

        if (request("is_not_send")) {
            $where[] = [EmailLog::IS_SEND, "!=", true];
        }

        $paginator = $this->repository->paginate($where);
        $paginator->appends(request()->input());


        return view('emailLog.index', [
            "paginator" => $paginator,
            "projects" => $projectRepository->getWithNameId(),
            "selectedProject" => $project
        ]);
    }

    public function showDetail(EmailLog $emailLog, EmailDetailLogRepository $repository)
    {
        $where = [
            ["log_id", $emailLog->id],
        ];
        return view("emailLog.detail-log", [
            "log" => $emailLog,
            "detailLogs" => $repository->get($where)
        ]);
    }

    public function resend(EmailLogRequest $request, EmailProjectRepository $projectRepository)
    {
        $logs = $this->repository->getNotSendByUUIDs($request->formUUIDs());
        foreach ($logs as $log) {
            AppMailer::trySendMail(
                $log,
                $projectRepository->findOneByLogId($log->id)
            );
        }
        return response()->redirectToRoute("email_logs.index");
    }
}
