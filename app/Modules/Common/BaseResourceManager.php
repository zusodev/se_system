<?php


namespace App\Modules\Common;


use App\Models\EmailTemplate;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Storage;
use function is_null;

abstract class BaseResourceManager
{
    static protected $singleton;

    /** @var Filesystem */
    protected $storage;

    /** @var int */
    protected $emailTemplateId;

    public function __construct(int $emailTemplateId)
    {
        $this->emailTemplateId = $emailTemplateId;
    }

    public static function instance(int $modelId = null)
    {
        if (!self::$singleton) {
            if (is_null($modelId)) {
                throw new Exception();
            }

            self::$singleton = new static($modelId);
        }

        return self::$singleton;
    }

    abstract protected function getStorageDiskName();

    public function checkAndCreateFolder(): bool
    {
        if ($this->getStorage()->exists($this->emailTemplateId)) {
            return true;
        }
        return $this->getStorage()
            ->makeDirectory($this->emailTemplateId);
    }

    public function cleanResources(EmailTemplate $emailTemplate, string $templateContent)
    {
        $emailTemplateResources = $emailTemplate->resources;
        foreach ($emailTemplateResources as $resource){
            $resource->file_name;
        }
    }

    public function put(UploadedFile $file)
    {
        $this->checkAndCreateFolder();

        return $this->getStorage()->put(
            $this->emailTemplateId . "/" . $file->getClientOriginalName(),
            $file->get()
        );
    }

    public function removeFolder()
    {
        if ($this->getStorage()->exists($this->emailTemplateId)) {
            return $this->getStorage()
                ->deleteDirectory($this->emailTemplateId);
        }

        return true;
    }

    protected function getStorage()
    {
        if ($this->storage) {
            return $this->storage;
        }
        $this->storage = Storage::disk(
            $this->getStorageDiskName()
        );
        return $this->storage;
    }
}
