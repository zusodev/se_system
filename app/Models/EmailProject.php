<?php

namespace App\Models;

use App\Presenters\TaiwanDateTimeTrait;
use Illuminate\Database\Eloquent\Model;

class EmailProject extends Model
{
    use TaiwanDateTimeTrait;
    const TABLE = "email_project";
    const ID = self::TABLE . ".id";
    const NAME = self::TABLE . ".name";
    const DESCRIPTION = self::TABLE . ".description";
    const SENDER_NAME = self::TABLE . ".sender_name";
    const SENDER_EMAIL = self::TABLE . ".sender_email";

    const COMPANY_ID = self::TABLE . ".company_id";

    const START_AT = self::TABLE . ".start_at";

    const EMAIL_TEMPLATE_ID =  self::TABLE . ".email_template_id";
    const PHISHING_WEBSITE_ID = self::TABLE . ".phishing_website_id";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
        "description",
        "company_id",
        "email_template_id",
        "phishing_website_id",
        "sender_name",
        "sender_email",
        "start_at",
        "log_redirect_to",
    ];

    protected $casts = [
        "start_at" => "datetime",
    ];

    public function company()
    {
        return $this->belongsTo(
            TargetCompany::class,
            "company_id",
            "id"
        );
    }

    public function emailTemplate()
    {
        return $this->belongsTo(
            EmailTemplate::class,
            "email_template_id",
            "id"
        );
    }

    public function website()
    {
        return $this->belongsTo(
            PhishingWebsite::class,
            "phishing_website_id",
            "id"
        );
    }
}
