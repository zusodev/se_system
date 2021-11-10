<?php

use App\Models\EmailTemplate;
use App\Models\EmailTemplateResource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmailTemplateResource::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string("file_name");

            $table->unsignedInteger("email_template_id");
            $table->foreign("email_template_id")
                ->references("id")
                ->on(EmailTemplate::TABLE)
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
        Schema::dropIfExists(EmailTemplateResource::TABLE);
    }
}
