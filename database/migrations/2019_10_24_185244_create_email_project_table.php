<?php

use App\Models\EmailProject;
use App\Models\EmailTemplate;
use App\Models\PhishingWebsite;
use App\Models\TargetCompany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmailProject::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 191);
            $table->string("description", 191)->nullable();

            $table->unsignedInteger("company_id");
            $table->foreign("company_id")
                ->references("id")
                ->on(TargetCompany::TABLE);


            $table->unsignedInteger("email_template_id");
            $table->foreign("email_template_id")
                ->references("id")
                ->on(EmailTemplate::TABLE);

            $table->unsignedInteger("phishing_website_id")->nullable();
            $table->foreign("phishing_website_id")
                ->references("id")
                ->on(PhishingWebsite::TABLE);

            $table->string("sender_name", 191);
            $table->string("sender_email", 191);
            $table->dateTime("start_at")->nullable();
            $table->string("log_redirect_to")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(EmailProject::TABLE);
    }
}
