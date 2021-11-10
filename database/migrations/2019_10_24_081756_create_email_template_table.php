<?php

use App\Models\EmailTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmailTemplate::TABLE, function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 100)->unique();
            $table->string("subject", 191)->nullable();
            $table->mediumText("template")->default("");
            $table->string("attachment_name", 191)->nullable();
            $table->string("attachment_mime_type", 10)->nullable();
//            $table->binary("attachment")->nullable();
            $table->timestamps();
        });
        $tableName = EmailTemplate::TABLE;
        DB::statement("ALTER TABLE {$tableName} ADD attachment MEDIUMBLOB DEFAULT NULL ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(EmailTemplate::TABLE);
    }
}
