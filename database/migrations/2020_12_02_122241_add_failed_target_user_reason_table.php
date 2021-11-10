<?php

use App\Models\UploadFailedTargetUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFailedTargetUserReasonTable extends Migration
{
    public function up()
    {
        Schema::table(UploadFailedTargetUser::TABLE, function (Blueprint $table) {
            $table->text("reason")->default("");
        });
    }

    public function down()
    {
        Schema::table(UploadFailedTargetUser::TABLE, function (Blueprint $table) {
            $table->removeColumn("reason");
        });
    }
}
