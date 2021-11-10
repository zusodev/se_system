<?php

use App\Models\TargetDepartment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTargetDepartmentTableTestColumn extends Migration
{
    public function up()
    {
        Schema::table(TargetDepartment::TABLE, function (Blueprint $table) {
            $table->boolean("is_test")->default(false);
        });
    }

    public function down()
    {
        Schema::table(TargetDepartment::TABLE, function (Blueprint $table) {
            $table->removeColumn("is_test");
        });
    }
}
