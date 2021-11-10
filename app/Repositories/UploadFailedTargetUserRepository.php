<?php


namespace App\Repositories;


use App\Models\UploadFailedTargetUser;
use DB;

class UploadFailedTargetUserRepository extends BaseRepository
{

    /**
     * @param array $fields
     * @return UploadFailedTargetUser|\Illuminate\Database\Eloquent\Model
     */
    public static function modelCreate(array $fields)
    {
        return UploadFailedTargetUser::create($fields);
    }

    /**
     * @param bool $isModal
     * @return self
     */
    protected function start(bool $isModal)
    {
        $this->builder = $isModal ? UploadFailedTargetUser::query() : DB::table(UploadFailedTargetUser::TABLE);

        return $this;
    }
}
