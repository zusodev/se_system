<?php

namespace App\Http\Requests;

use App\Models\TargetCompany;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Route;
use function trim;

class TargetCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $baseRule = $this->getBaseRules();

        switch (Route::currentRouteName()) {
            case "target_companys.store":
                $baseRule["name"] = "unique:" . TargetCompany::TABLE;
                return $baseRule;
            case "target_companys.update":
                $baseRule["name"] = Rule::unique(TargetCompany::TABLE)->ignore(
                    $this->route()->parameter("target_company")
                );
                return $baseRule;
        }
        return [];
    }

    public function formAttributes(): array
    {
        $attributes = $this->only([
            "name",
        ]);
        $attributes["name"] = trim($attributes["name"]);
        return $attributes;
    }

    /**
     * @return array
     */
    protected function getBaseRules(): array
    {
        return [
            "name" => ["required", "string", "max:191"],
        ];
    }
}
