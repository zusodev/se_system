<?php

namespace App\Models;

use App\Models\PhishingWebsite;
use Illuminate\Database\Eloquent\Model;

class PhishingWebsiteResource extends Model
{
    const TABLE = "phishing_website_resource";

    protected $table = self::TABLE;

    protected $fillable = [
        "file_name",
        "phishing_website_id",
    ];

    public function phishingWebsite()
    {
        return $this->belongsTo(
            PhishingWebsite::class,
            "phishing_website_id",
            "id"
        );
    }
}
