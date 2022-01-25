<?php


namespace App\Repositories;


use App\Models\TargetCompany;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TargetCompanyRepository extends BaseRepository
{
    /**
     * @param array $where
     * @param array $column
     * @param bool $isModel
     * @return LengthAwarePaginator|LengthAwarePaginatorInterface|TargetCompany[]
     */
    public function paginate(array $where = [], array $column = ['*'], bool $isModel = true): LengthAwarePaginator
    {
        return $this->start($isModel)
            ->builder
            ->where($where)
            ->orderBy(TargetCompany::ID, 'desc')
            ->groupBy(TargetCompany::ID)
            ->paginate($this->perPage, [TargetCompany::TABLE . '.*']);
    }


    protected function start(bool $isModal)
    {
        $this->builder = $isModal ? TargetCompany::query() : DB::table(TargetCompany::TABLE);
        return $this;
    }

    public function create(array $attributes)
    {
        return $this->getBuilderWithStart(true)
            ->create($attributes);
    }

    public function find(int $id)
    {
        return $this->getBuilderWithStart(true)
            ->find($id);
    }


    /**
     * @param bool $isModel
     * @return Collection|TargetCompany[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get(bool $isModel = true)
    {
        return $this->getBuilderWithStart($isModel)
            ->get();
    }

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|TargetCompany[]
     */
    public function getWithDepartments(array $columns = ['*'])
    {
        return $this->start(true)
            ->builder
            ->with('targetDepartments')
            ->get($columns);
    }

}
