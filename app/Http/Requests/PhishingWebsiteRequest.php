<?php

namespace App\Http\Requests;

use App\Models\PhishingWebsite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class PhishingWebsiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $route = Route::getCurrentRoute();
        $baseRules = [
            "name" => ["required", "string", "max:191"],
            "template" => ["nullable", "string", "max:16700000"],
        ];
        switch ($route) {
            case "phishing_websites.store":
                return $baseRules;
            case "phishing_websites.update":

                $baseRules["name"][] = Rule::unique(PhishingWebsite::TABLE)->ignore(
                    $this->route()->parameter("phishing_website")
                );
                return $baseRules;
            case "phishing_websites.upload.image":
                return [
                    // TODO
                ];
        }

        return [];
    }

    public function formAttributes(): array
    {
        return $this->only([
            "name",
            "template"
        ]);
    }
}
