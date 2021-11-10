<?php

namespace App\Models;

use App\Presenters\TaiwanDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

class UploadFailedTargetUser extends Model
{
    use TaiwanDateTimeTrait;
    const TABLE = "upload_failed_target_user";

    protected $table = self::TABLE;

    protected $fillable = [
        "company_name",
        "name",
        "email",
        "file_name",
        "uploaded_at",
        'reason',
    ];

    protected $casts = [
        "uploaded_at" => "datetime",
    ];

    public $timestamps = false;

}
