<?php


namespace App\Modules\PhishingWebsite;


use App\Modules\Common\BaseResourceManager;

class ResourceManager extends BaseResourceManager
{
    public function generateUrl(string $fileName): string
    {
        return "/storage/p_w_resources/" . $this->emailTemplateId . "/" . $fileName;
    }

    protected function getStorageDiskName(): string
    {
        return "phishing_website_resources";
    }
}
