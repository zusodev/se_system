<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;
use function trim;

class TargetDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $baseRules = [
            "name" => ["required", "string", "max:191"],
            "is_test" => ["nullable"],
        ];

        switch (Route::currentRouteName()) {
            case "target_departments.store":
                $baseRules["company_id"] = ["required"];
                return $baseRules;
            case "target_departments.update":
                return $baseRules;
        }
        return [];
    }

    public function createFormAttributes()
    {
        $attributes = $this->formAttributes();
        $attributes["company_id"] = $this->get("company_id");

        return $attributes;
    }

    public function formAttributes(): array
    {
        $attributes = $this->only([
            "name",
            "is_test",
        ]);

        $attributes["name"] = trim($attributes["name"]);
        $attributes["is_test"] = isset($attributes["is_test"]);
        return $attributes;
    }
}
