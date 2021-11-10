<?php

namespace App\Http\Requests;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Log;
use Route;

class EmailTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch (Route::currentRouteName()) {
            case "email_templates.create":
                return [
                    "name" => ["required", "string", "max:50", "unique:" . EmailTemplate::TABLE],
                ];
            case "email_templates.update":
                return [
                    "name" => ["required", "string", "max:50",
//                        Rule::unique(EmailTemplate::TABLE)->ignore($this->get("name"))
                    ],
                    "subject" => ["nullable", "string", "max:191"],
                    "template" => ["nullable", "string", "max:16700000"],
                    "attachment" => ["nullable"],
                    "exe_attachment_file_name" => ["nullable", "string"]
                ];
            case "email_templates.upload.image":
                return [];
            case "email_templates.sendEmail":
                return [
                    "email" => ["required", "string", "email"],
                ];
        }
        return [];
    }

    public function formAttributes(): array
    {
        $attributes = $this->only([
            "name",
            "subject",
            "template",
        ]);


        if ($this->has("is_delete_attachment")) {
            $attributes["attachment"] = "";
            $attributes["attachment_name"] = "";
            $attributes["attachment_mime_type"] = "";
            $attributes["attachment_is_exe"] = false;
        }

        $file = $this->file("attachment");
        if ($file) {
            try {
                $attributes["attachment"] = $file->get();
                $attributes["attachment_name"] = $file->getClientOriginalName();
                $attributes["attachment_mime_type"] = $file->getMimeType();
                $attributes["attachment_is_exe"] = false;
            } catch (Exception $e) {
                Log::error($e);
            }
        }
        if ($this->get("exe_attachment_file_name")) {
            $attributes["attachment_name"] = $this->get("exe_attachment_file_name");
            $attributes["attachment_mime_type"] = "";
            $attributes["attachment_is_exe"] = true;
        }


        if (empty($attributes["subject"])) {
            $attributes["subject"] = $attributes["name"];
        }


        return $attributes;
    }
}
