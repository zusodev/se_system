<?php

use App\Models\TargetCompany;
use App\Models\TargetDepartment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetDepartmentTable extends Migration
{
    public function up()
    {
        Schema::create(TargetDepartment::TABLE, function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 191);
            $table->unsignedInteger("company_id");
            $table->foreign("company_id")
                ->references("id")
                ->on(TargetCompany::TABLE);

            $table->unique(["company_id", "name"]);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TargetDepartment::TABLE);
    }
}
