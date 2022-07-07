<?php

use App\Models\Ipv4AddressRange;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpv4AddressTable extends Migration
{
    public function up()
    {
        Schema::create(Ipv4AddressRange::TABLE, function (Blueprint $table) {
            $table->string(Ipv4AddressRange::ID)->primary();
            $table->ipAddress(Ipv4AddressRange::FIRST_ADDRESS)->primary();
            $table->ipAddress(Ipv4AddressRange::LAST_ADDRESS)->primary();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Ipv4AddressRange::TABLE);
    }
}
