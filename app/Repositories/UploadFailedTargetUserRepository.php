<?php


namespace App\Repositories;


use App\Models\UploadFailedTargetUser;
use DB;

class UploadFailedTargetUserRepository extends BaseRepository
{
    public function create(array $fields)
    {
        return UploadFailedTargetUser::create($fields);
    }

    protected function start(bool $isModal)
    {
        $this->builder = $isModal ? UploadFailedTargetUser::query() : DB::table(UploadFailedTargetUser::TABLE);

        return $this;
    }
}
