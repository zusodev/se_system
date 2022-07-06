<?php

namespace App\Models;

use App\Presenters\TaiwanDateTimeTrait;
use Illuminate\Database\Eloquent\Model;


class EmailJob extends Model
{
    use TaiwanDateTimeTrait;
    const TABLE = "email_job";
    const ID = self::TABLE . ".id";

    const PROJECT_ID = "project_id";
    const DEPARTMENT_ID = self::TABLE . ".department_id";
    const STATUS = self::TABLE . ".status";
    const SEND_TOTAL = self::TABLE . ".send_total";
    const EXPECTED_SEND_TOTAL = self::TABLE . ".expected_send_total";

    const WAIT_STATUS = 0;
    const RUNNING_STATUS = 1;
    const FINISH_STATUS = 2;
    const CANCEL_STATUS = 3;
    const NO_USER = 4;

    protected $table = self::TABLE;

    protected $fillable = [
        'project_id',
        'department_id',
        'status',
        'send_total',
        'expected_send_total',
    ];

    public function targetDepartment()
    {
        return $this->belongsTo(TargetDepartment::class, 'department_id', 'id');
    }

    public function emailProject()
    {
        return $this->belongsTo(EmailProject::class, 'project_id', 'id');
    }
}
