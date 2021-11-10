<?php

use App\Models\EmailDetailLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailDetailLogsTable extends Migration
{
    public function up()
    {
        Schema::create(EmailDetailLog::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_id');

            $table->json('ips')->default('{}');
            $table->string('agent');
            $table->string('action');
            $table->json('request_body')->default('{}');
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
        Schema::dropIfExists(EmailDetailLog::TABLE);
    }
}
