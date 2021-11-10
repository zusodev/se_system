<?php

use App\Models\PhishingWebsite;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhishingWebsitesTable extends Migration
{
    public function up()
    {
        Schema::create(PhishingWebsite::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 100)->unique();
            $table->mediumText("template")->default("");
            $table->boolean("received_form_data_is_ok")->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(PhishingWebsite::TABLE);
    }
}
