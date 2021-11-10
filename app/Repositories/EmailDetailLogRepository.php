<?php


namespace App\Repositories;


use App\Models\EmailDetailLog;
use DB;

class EmailDetailLogRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return $this->getBuilderWithStart(true)
            ->create($attributes);
    }

    public function get(array $where)
    {
        return $this->getBuilderWithStart(true)
            ->where($where)
            ->get();
    }

    protected function start(bool $isModal): self
    {
        $this->builder = $isModal ? EmailDetailLog::query() : DB::table(EmailDetailLog::TABLE);
        return $this;
    }
}
