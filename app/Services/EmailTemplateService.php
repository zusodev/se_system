<?php


namespace App\Services;


use App\Models\EmailTemplate;
use App\Modules\EmailTemplate\ResourceManager;
use App\Repositories\EmailTemplateRepository;
use DB;
use Exception;
use Illuminate\Http\UploadedFile;
use Log;


class EmailTemplateService extends BaseService
{
    private $repository;

    public function __construct(EmailTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attributes): array
    {
        try {
            $template = $this->repository->create($attributes);
            $this->result = (bool)$template;

            $resourceManager = ResourceManager::instance($template->id);
            $this->result && $resourceManager->checkAndCreateFolder();
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function update(EmailTemplate $template, array $attributes)
    {
        $resourceManager = ResourceManager::instance($template->id);

        try {
            $this->result = $template->update($attributes);
            $resourceManager->cleanResources($template, $attributes["template"]);
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function destroy(EmailTemplate $template): array
    {
        $resourceManager = ResourceManager::instance($template->id);

        try {
            DB::beginTransaction();
            $this->result = (bool)$template->delete();
            $this->result && $resourceManager->removeFolder();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $template->name . " " . $this->newResultMessage()
        ];
    }

    public function storeImageResource(EmailTemplate $emailTemplate, UploadedFile $file)
    {
        DB::beginTransaction();
        try {
            $fileName = $file->getClientOriginalName();
            $emailTemplate->resources()->firstOrCreate([
                "file_name" => $fileName,
            ]);

            $resourceManager = ResourceManager::instance($emailTemplate->id);

            $resourceManager->put($file);

            $url = $resourceManager->generateUrl($fileName);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return [
                "uploaded" => 0,
                "error" => [
                    "message" => $e->getMessage()
                ]
            ];
        }

        return [
            "fileName" => $fileName, // test.jpg
            "uploaded" => 1,
            "url" => env("APP_URL") . $url, // /storage/test.jpg
        ];
    }
}
