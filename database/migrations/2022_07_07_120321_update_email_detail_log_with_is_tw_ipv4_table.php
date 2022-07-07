<?php

use App\Models\EmailDetailLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailDetailLogWithIsTwIpv4Table extends Migration
{
    public function up()
    {
        Schema::table(EmailDetailLog::TABLE, function (Blueprint $table) {
            $table->boolean(EmailDetailLog::IS_TW_IP)
                ->nullable()
                ->default(null);
        });

    }

    public function down()
    {
        Schema::table(EmailDetailLog::TABLE, function (Blueprint $table) {
            $table->removeColumn(EmailDetailLog::IS_TW_IP);
        });
    }
}
