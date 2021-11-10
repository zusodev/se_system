<?php


namespace App\Repositories;


use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as TableBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Str;

abstract class BaseRepository
{
    /** @var Builder|TableBuilder */
    protected $builder;

    protected $perPage = 10;

    public static function getQueryWithBindings(string $sql, array $bindings): string
    {
        return Str::replaceArray("?", $bindings, $sql);
    }

    /**
     * @param array $where
     * @param array $column
     * @param bool $isModel
     * @return LengthAwarePaginator|LengthAwarePaginatorInterface
     */
    public function paginate(array $where = [], array $column = ["*"], bool $isModel = true): LengthAwarePaginator
    {
        return $this->start($isModel)
            ->builder
            ->where($where)
            ->orderBy("id", "desc")
            ->paginate($this->perPage, $column);
    }

    public function count(): int
    {
        return $this->start(false)
            ->builder
            ->count();
    }

    /**
     * @param bool $isModal
     * @return self
     */
    abstract protected function start(bool $isModal);

    protected function getBuilderWithStart(bool $isModal = false)
    {
        return $this->start($isModal)
            ->builder;
    }

    public function create(array $attributes)
    {
        return $this->getBuilderWithStart(true)
            ->create($attributes);
    }

    public function exists(array $where)
    {
        return $this->getBuilderWithStart(true)
            ->where($where)
            ->exists();
    }
}
