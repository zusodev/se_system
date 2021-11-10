<?php

use App\Models\TargetCompany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetCompanyTable extends Migration
{
    public function up()
    {
        Schema::create(TargetCompany::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TargetCompany::TABLE);
    }
}
