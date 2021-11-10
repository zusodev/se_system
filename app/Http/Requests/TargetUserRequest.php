<?php

namespace App\Http\Requests;

use App\Models\TargetDepartment;
use App\Models\TargetUser;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Route;

class TargetUserRequest extends FormRequest
{
    /**
     * @param int $departmentId
     * @param string $table
     * @return Unique
     */
    public static function getEmailUniqueRule($companyId = null, $departmentId = null): Unique
    {
        $sql = "
            SELECT * FROM target_user
            WHERE target_user.email = ? AND
                department_id IN (SELECT * FROM target_department WHERE company_id = ?)
        ";
        return Rule::unique(TargetUser::TABLE)
            ->where(function (Builder $query) use ($departmentId) {

                return $query->where('department_id', $departmentId);
            });
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch (Route::currentRouteName()) {
            case "target_users.store":
                $storeRules = $this->storeRules();
                return $storeRules;
            case "target_users.update":
                return [
                    "name" => ["required", "string", "max:191"],
                    "email" => [
                        "required",
                        "string",
                        "email",
                        "max:191",
                    ],
                    "department_id" => ["required"],
                ];
            case "target_users.upload.store":
                return [
                    "users_file" => ["required", "file"]
                ];
        }

        return [];
    }

    public function paginateWhere(): array
    {
        $where = [];
        $name = $this->get("name");
        if (isset($name)) {
            $where[] = [TargetUser::NAME, "LIKE", "%" . $name . "%"];
        }

        $email = $this->get("email");
        if (isset($email)) {
            $where[] = [TargetUser::EMAIL, "LIKE", "%" . $email . "%"];
        }

        $departmentId = $this->get("department_id");
        if (isset($departmentId)) {
            $where[] = [TargetUser::DEPARTMENT_ID, "=", $departmentId];
        }

        $companyId = $this->get("company_id");
        if (isset($companyId)) {
            $where[] = [TargetDepartment::COMPANY_ID, "=", $companyId];
        }
        return [$where];
    }

    public function formAttributes(): collection
    {
        $attributes = $this->only([
            "name",
            "email",
            "department_id",
        ]);

        return Collection::make($attributes);
    }

    public static function storeRules(): array
    {
        $departmentTable = TargetDepartment::TABLE;
        return [
            "name" => ["required", "string", "max:191"],
            "email" => [
                "required",
                "string",
                "email",
                "max:191",
            ],
            "department_id" => ["required", "exists:{$departmentTable},id"],
        ];
    }
}
