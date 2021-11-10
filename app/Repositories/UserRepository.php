<?php


namespace App\Repositories;


use App\Models\User;
use DB;

class UserRepository extends BaseRepository
{
    /**
     * @param array $fields
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $fields)
    {
        return User::create($fields);
    }

    protected function start(bool $isModal): self
    {
        $this->builder = $isModal ? User::query() : DB::table(User::TABLE);
        return $this;
    }
}
