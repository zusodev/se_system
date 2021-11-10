<?php

use App\Models\PhishingWebsite;
use App\Models\PhishingWebsiteResource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePhishingWebsiteResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PhishingWebsiteResource::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string("file_name");

            $table->unsignedInteger("phishing_website_id");
            $table->foreign("phishing_website_id")
                ->references("id")
                ->on(PhishingWebsite::TABLE)
                ->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(PhishingWebsiteResource::TABLE);
    }
}
