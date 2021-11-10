<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailTemplateRequest;
use App\Mail\TestTemplateMail;
use App\Models\EmailTemplate;
use App\Modules\EmailTemplate\Attachment;
use App\Repositories\EmailTemplateRepository;
use App\Services\EmailTemplateService;
use Exception;
use Mail;
use Symfony\Component\HttpFoundation\Response;
use function dd;
use function file_get_contents;
use function response;
use function route;
use function storage_path;
use function view;

class EmailTemplateController extends Controller
{
    private $repository;
    private $service;

    public function __construct(EmailTemplateRepository $repository, EmailTemplateService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return view("email-template.index", [
            "paginator" => $this->repository->paginateJoinWithProjectCount(),
        ]);
    }

    public function store(EmailTemplateRequest $request)
    {
        $attributes = $request->formAttributes();
        if ($this->repository->exists([["name", $attributes["name"]]])) {
            return $this->operationRedirectResponse(
                false,
                $attributes["name"] . " 樣式已存在，請修改名稱"
            );
        }

        return $this->operationRedirectResponse(...(
        $this->service->store($attributes)
        ));
    }

    public function downloadAttachment(EmailTemplate $emailTemplate)
    {
        return $this->binaryFileResponse(
            $emailTemplate->attachment,
            $emailTemplate->attachment_mime_type,
            $emailTemplate->attachment_name
        );
    }

    public function downloadDefaultAttachment(string $fileName)
    {
        return $this->binaryFileResponse(
            file_get_contents(storage_path("attachment_templates/" . $fileName)),
            Attachment::getContentTypes($fileName),
            $fileName
        );
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view("email-template.edit", [
            "template" => $emailTemplate,
            "imageUrl" => route(
                    "email_templates.upload.image",
                    [$emailTemplate->id]
                ) . "?",
            "attachmentTemplates" => Attachment::getAttachmentTemplates()
        ]);
    }

    public function update(EmailTemplate $emailTemplate, EmailTemplateRequest $request)
    {
        $attributes = $request->formAttributes();
//        dd($request->all(), $attributes);

        return $this->operationRedirectResponse(...(
            $this->service->update($emailTemplate, $attributes)
        ));
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        return $this->operationRedirectResponse(...(
            $this->service->destroy($emailTemplate)
        ));
    }

    public function sendEmail(EmailTemplate $emailTemplate, EmailTemplateRequest $request)
    {
        $result = true;
        $email = $request->get('email');
        $message = $email;
        try {
            Mail::to($email)
                ->send(new TestTemplateMail($emailTemplate));

            /*SendEmailPressureTestJob::dispatch([$email]);*/
            $message .= " 寄信成功";
        } catch (Exception $e) {
            $result = false;
            $message .= " 寄信失敗 \n" . $e->getMessage();
        }

        return $this->operationRedirectResponse($result, $message);
    }

    public function uploadImage(EmailTemplate $emailTemplate, EmailTemplateRequest $request)
    {
        $file = $request->file("upload");
        $fileSize = $file->getSize() / 1000;
        if ($fileSize > 1024) {
            return [
                "uploaded" => 0,
                "error" => [
                    "message" => "上傳失敗，檔案大小超過 1 MB"
                ]
            ];
        }

        $resultJson = $this->service->storeImageResource($emailTemplate, $file);

        if (empty($resultJson)) {
            return response("", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($resultJson);
    }
}
