<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class TargetUser extends Model
{
    use Notifiable;
    const TABLE = "target_user";
    const ID = self::TABLE . ".id";
    const NAME = self::TABLE . ".name";
    const EMAIL = self::TABLE . ".email";
    const DEPARTMENT_ID = self::TABLE . ".department_id";

    protected $table = self::TABLE;

    protected $fillable = [
        "name", "email", "department_id",
    ];

    public $timestamps = false;

    public function targetDepartment()
    {
        return $this->belongsTo(TargetDepartment::class, "department_id", "id");
    }
}
