<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Route;

class EmailProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $route = Route::currentRouteName();
        switch ($route) {
            case "email_projects.store":
                return [
                    "name" => ["required", "string", "max:191"],
                    "description" => ["nullable", "string", "max:191"],
                    "sender_name" => ["required", "string", "max:191", Rule::notIn(['test']),],
                    "sender_email" => ["required", "string", "max:191", "email"],
                    "email_template_id" => ["required", "exists:email_template,id"],
                    "phishing_website_id" => ["nullable", "exists:phishing_website,id"],
                    "company_id" => ["required", "exists:target_company,id"],
                    "department_ids" => ["required", "array"],
                    "start_at" => ["required", "date_format:Y-m-d\TH:i"],
                    "log_redirect_to" => ["required","string", "url"]
                ];
        }
        return [
            //
        ];
    }

    public function projectAttributes()
    {
        $attributes = $this->only([
            "name",
            "description",
            "sender_email",
            "sender_name",
            "email_template_id",
            "phishing_website_id",
            "company_id",
            "start_at",
            "log_redirect_to",
        ]);

        $attributes["start_at"] = Carbon::create($attributes["start_at"]);

        return $attributes;
    }
}
