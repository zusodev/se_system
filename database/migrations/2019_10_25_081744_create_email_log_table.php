<?php

use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\TargetUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogTable extends Migration
{
    public function up()
    {
        Schema::create(EmailLog::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->unsignedInteger('job_id');
            $table->foreign('job_id')
                ->references('id')
                ->on(EmailJob::TABLE);

            $table->unsignedInteger('target_user_id');
            $table->foreign('target_user_id')
                ->references('id')
                ->on(TargetUser::TABLE);

            $table->boolean('is_send')->default(false);
            $table->boolean('is_open')->default(false);
            $table->boolean('is_open_link')->default(false);
            $table->boolean('is_open_attachment')->default(false);
            $table->boolean('is_post_from_website')->default(false);
            $table->unique(['job_id', 'target_user_id']);
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
        Schema::dropIfExists(EmailLog::TABLE);
    }
}
