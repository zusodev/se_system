<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TargetDepartment extends Model
{
    const TABLE = "target_department";
    const ID = self::TABLE . ".id";
    const NAME = self::TABLE . ".name";
    const COMPANY_ID = self::TABLE . ".company_id";
    const IS_TEST = self::TABLE . ".is_test";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
        "company_id",
        "is_test",
    ];

    public function targetCompany()
    {
        return $this->belongsTo(TargetCompany::class, "company_id", "id");
    }

    public function targetUsers()
    {
        return $this->hasMany(TargetUser::class, "department_id", "id");
    }

    public function emailJobs()
    {
        return $this->hasMany(EmailJob::class, "department_id", "id");
    }

    public function setNameAttribute(string $value)
    {
        $this->attributes['name'] = trim($value);
    }
}
