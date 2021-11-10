<?php

use App\Models\EmailJob;
use App\Models\EmailProject;
use App\Models\EmailTemplate;
use App\Models\TargetDepartment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmailJob::TABLE, function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("project_id");
            $table->foreign("project_id")
                ->references("id")
                ->on(EmailProject::TABLE);

            $table->unsignedInteger("department_id");
            $table->foreign("department_id")
                ->references("id")
                ->on(TargetDepartment::TABLE);


            $table->tinyInteger("status")->default(EmailJob::WAIT_STATUS);
            $table->integer("send_total")->default(0);
            $table->integer("expected_send_total")->default(0);
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
        Schema::dropIfExists(EmailJob::TABLE);
    }
}
