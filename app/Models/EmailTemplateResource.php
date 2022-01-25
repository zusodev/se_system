<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmailTemplateResource extends Model
{
    const TABLE = 'email_template_resource';

    protected $table = self::TABLE;

    protected $fillable = [
        'file_name',
        'email_template_id',
    ];

    public function emailTemplate()
    {
        return $this->belongsTo(
            EmailTemplate::class,
            'email_template_id',
            'id'
        );
    }
}
