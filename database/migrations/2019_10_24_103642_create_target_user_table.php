<?php

use App\Models\TargetDepartment;
use App\Models\TargetUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetUserTable extends Migration
{
    public function up()
    {
        Schema::create(TargetUser::TABLE, function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("email");

            $table->unsignedInteger("department_id");
            $table->foreign("department_id")
                ->references("id")
                ->on(TargetDepartment::TABLE);

            $table->unique(["department_id", "email"]);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TargetUser::TABLE);
    }
}
