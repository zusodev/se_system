<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailLogRequest;
use App\Models\EmailLog;
use App\Models\EmailProject;
use App\Modules\EmailLog\WebsiteTemplateResponser;
use App\Repositories\EmailLogRepository;
use App\Repositories\EmailProjectRepository;
use App\Services\EmailLogCollector;
use function base64_encode;
use function dd;
use function file_get_contents;
use function public_path;
use function response;
use function route;
use function str_replace;

class EmailLogController extends Controller
{
    private $service;

    private $repository;

    private $projectRepository;

    public function __construct(
        EmailLogCollector $service,
        EmailLogRepository $repository,
        EmailProjectRepository $projectRepository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
    }

    public function open(EmailLogRequest $request)
    {
        $this->getEmailLogAndUpdateByUUID($request, EmailLog::IS_OPEN);

        return $this->binaryFileResponse(
            file_get_contents(public_path("default.png")),
            "image/png",
            "default.png"
        );
    }

    public function openLink(EmailLogRequest $request)
    {
        $emailLog = $this->getEmailLogAndUpdateByUUID($request, EmailLog::IS_OPEN_LINK);

        /** @var EmailProject $project */
        $project = $this->projectRepository->findOneByLogId($emailLog->id);

        if (!$project->phishing_website_id) {
            return response()->redirectTo($project->log_redirect_to);
        }

        if (!$project->website->template) {
            return response()->redirectTo($project->log_redirect_to);
        }

        $template = WebsiteTemplateResponser::setTemplateFormUrlScript(
            $project->website->template,
            route('api.email_logs.post.log', [
                'uuid' => base64_encode($request->getUUID())
            ])
        );

        $responseWithSetFormUrlScript = str_replace("@email@", $emailLog->targetUser->email, $template);

        return response($responseWithSetFormUrlScript);
    }

    public function postLog(EmailLogRequest $request)
    {
        $emailLog = $this->getEmailLogAndUpdateByUUID($request, EmailLog::IS_POST_FROM_WEBSITE);
        /** @var EmailProject $project */
        $project = $this->projectRepository->findOneByLogId($emailLog->id);
        return response()->redirectTo($project->log_redirect_to);
    }

    public function openAttachment(EmailLogRequest $request)
    {
        $emailLog = $this->getEmailLogAndUpdateByUUID($request, EmailLog::IS_OPEN_ATTACHMENT);

        $project = $this->projectRepository->findOneByLogId($emailLog->id);
        return response()->redirectTo($project->log_redirect_to);
    }

    protected function getEmailLogAndUpdateByUUID(EmailLogRequest $request, string $actionColumn)
    {
        $emailLog = $this->repository->findOne($request->getUUID());
        if (!$emailLog) {
            abort(404);
        }
        $this->service->updateLog($emailLog, $actionColumn);

        return $emailLog;
    }
}
