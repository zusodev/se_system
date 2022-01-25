<?php


namespace App\Modules\EmailTemplate;


use App\Modules\Common\BaseResourceManager;

class ResourceManager extends BaseResourceManager
{
    public function generateUrl(string $fileName): string
    {
        return '/storage/e_t_resources/' . $this->emailTemplateId . '/' . $fileName;
    }

    protected function getStorageDiskName(): string
    {
        return 'email_template_resources';
    }
}
