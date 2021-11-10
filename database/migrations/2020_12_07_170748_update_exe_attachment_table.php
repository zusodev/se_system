<?php

use App\Models\EmailTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateExeAttachmentTable extends Migration
{
    public function up()
    {
        Schema::table(EmailTemplate::TABLE, function (Blueprint $table) {
            $table->boolean("attachment_is_exe")->default(false);
        });
    }

    public function down()
    {
        Schema::table(EmailTemplate::TABLE, function (Blueprint $table) {
            $table->removeColumn("attachment_is_exe");
        });
    }
}
