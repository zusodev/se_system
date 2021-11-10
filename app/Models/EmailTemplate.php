<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmailTemplate extends Model
{
    const TABLE = "email_template";
    const ID = self::TABLE . ".id";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
        "subject",
        "template",
        "attachment_name",
        "attachment_mime_type",
        "attachment",
        "attachment_is_exe",
    ];

    public function resources()
    {
        return $this->hasMany(
            EmailTemplateResource::class,
            "email_template_id",
            "id"
        );
    }
}
