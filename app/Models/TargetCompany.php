<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TargetCompany extends Model
{
    const TABLE = "target_company";
    const ID = self::TABLE . ".id";
    const NAME = self::TABLE . ".name";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
    ];

    public function targetDepartments()
    {
        return $this->hasMany(TargetDepartment::class, "company_id", "id");
    }
}
