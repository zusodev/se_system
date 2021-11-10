<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhishingWebsite extends Model
{
    const TABLE = "phishing_website";
    const ID = self::TABLE . ".id";

    protected $table = self::TABLE;

    protected $fillable = [
        "name",
        "template",
        "received_form_data_is_ok",
    ];

    public function phishingWebsiteResources()
    {
        return $this->hasMany(
            PhishingWebsiteResource::class,
            "phishing_website_id",
            "id"
        );
    }

    public function setReceivedFormDataIsOk()
    {
        $this->update([
           "received_form_data_is_ok" => true,
        ]);
    }
}
