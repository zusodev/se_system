<?php

namespace App\Models;

use App\Presenters\TaiwanDateTimeTrait;
use Illuminate\Database\Eloquent\Model;


class EmailLog extends Model
{
    use TaiwanDateTimeTrait;
    const TABLE = 'email_log';
    const T_ID = self::TABLE . '.id';
    const UUID = self::TABLE . ".uuid";
    const T_JOB_ID = self::TABLE . ".job_id";
    const TARGET_USER_ID = self::TABLE . ".target_user_id";

    const IS_SEND = self::TABLE . ".is_send";
    const IS_OPEN = self::TABLE . ".is_open";
    const IS_OPEN_LINK = self::TABLE . ".is_open_link";
    const IS_OPEN_ATTACHMENT = self::TABLE . ".is_open_attachment";
    const IS_POST_FROM_WEBSITE = self::TABLE . ".is_post_from_website";

    protected $table = self::TABLE;

    protected $fillable = [
        "uuid",
        "job_id",
        "target_user_id",
        "is_send",
        "is_open",
        "is_open_link",
        "is_open_attachment",
        "is_post_from_website"
    ];

    public function emailJob()
    {
        return $this->belongsTo(EmailJob::class, "job_id", "id");
    }

    public function targetUser()
    {
        return $this->belongsTo(TargetUser::class, "target_user_id", "id");
    }

    public function emailProject()
    {
        return $this->emailJob()->join(EmailProject::TABLE, EmailJob::PROJECT_ID, "=", EmailProject::ID)
            ->select([EmailProject::TABLE . ".*"]);
    }
}
