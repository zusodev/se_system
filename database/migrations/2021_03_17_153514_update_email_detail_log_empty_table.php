<?php

use App\Models\EmailDetailLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailDetailLogEmptyTable extends Migration
{
    public function up()
    {
        Schema::table(EmailDetailLog::TABLE, function (Blueprint $table) {
            $table->string('agent')
                ->nullable(true)
                ->change();
            $table->string('action')
                ->nullable(true)
                ->change();
        });
    }

    public function down()
    {
        Schema::table(EmailDetailLog::TABLE, function (Blueprint $table) {
            $table->string('agent')
                ->nullable(false)
                ->change();
            $table->string('action')
                ->nullable(false)
                ->change();
        });
    }
}
