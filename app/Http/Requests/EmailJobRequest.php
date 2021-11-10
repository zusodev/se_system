<?php

namespace App\Http\Requests;

use App\Models\TargetDepartment;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use function is_null;
use function now;

class EmailJobRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function paginateWhere(): array
    {
        $where = [];
        $departmentName = $this->get("name");
        if (!is_null($departmentName)) {
            $where[] = [TargetDepartment::NAME, "LIKE", "%" . $departmentName . '%'];
        }

        return $where;
    }

    public function formAttributes(): Collection
    {
        $attributes = $this->only([
            "name",
            "description",
            "email_template_id",
            "groups",
            "sender_name",
            "sender_email",
            "start_date",
            "start_time",
        ]);

        if (!$attributes["start_date"] || !$attributes["start_time"]) {
            $attributes["start"] = now();
        } else {
            $attributes["start"] = Carbon::create($attributes["start_date"] . " " . $attributes["start_time"]);
        }
        unset($attributes["start_date"]);
        unset($attributes["start_time"]);

        return Collection::make($attributes);
    }
}
