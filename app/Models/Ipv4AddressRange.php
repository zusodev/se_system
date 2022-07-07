<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Ipv4AddressRange extends Model
{
    const ID = 'id';
    const TABLE = 'ipv4_address';

    const FIRST_ADDRESS = 'first_address';
    const LAST_ADDRESS = 'last_address';

    protected $table = self::TABLE;

    protected $fillable = [
        self::FIRST_ADDRESS,
        self::LAST_ADDRESS,
    ];
}
