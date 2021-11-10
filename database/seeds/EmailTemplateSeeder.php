<?php

use App\Modules\EmailTemplate\Attachment;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(EmailTemplateRepository $repository)
    {
        // TODO

        $fileName = Attachment::VBS_FILENAME;
        $template = $repository->create([
            "name" => "人事室通知",
            "subject" => "人事室通知",
            "template" => view("email.defaultMail")->render(),
            "attachment_name" => $fileName,
            "attachment_mime_type" => Attachment::getContentTypes($fileName),
            "attachment" => file_get_contents(storage_path("attachment_templates/" . $fileName)),
        ]);
    }
}
