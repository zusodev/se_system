<?php


namespace App\Repositories;


use App\Models\EmailProject;
use App\Models\EmailTemplate;
use DB;
use Illuminate\Support\Collection;

class EmailTemplateRepository extends BaseRepository
{
    protected $perPage = 30;

    public function paginateJoinWithProjectCount()
    {
        return $this->start(true)
            ->joinWithProjectUsed()
            ->builder
            ->orderBy(EmailTemplate::ID, "desc")
            ->groupBy(EmailTemplate::ID)
            ->paginate($this->perPage, [
                EmailTemplate::ID,
                EmailTemplate::TABLE . ".name",
                EmailTemplate::TABLE . "." . EmailTemplate::CREATED_AT,
                "sub.project_count",
            ]);
    }

    public function joinWithProjectUsed()
    {
        $builder = DB::table(EmailTemplate::TABLE)
            ->leftJoin(EmailProject::TABLE, EmailTemplate::ID, "=", EmailProject::EMAIL_TEMPLATE_ID)
            ->select(["email_template.id as email_template_id"])
            ->selectRaw("COUNT(email_project.id)  as project_count")
            ->groupBy(EmailTemplate::ID);

        $this->builder->leftJoin(
            DB::raw("( {$builder->toSql()} ) as `sub`"),
            EmailTemplate::ID,
            "=",
            "sub.email_template_id"
        );
        return $this;
    }

    /**
     * @param array $fields
     * @return EmailTemplate|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $fields)
    {
        return EmailTemplate::create($fields);
    }

    public function count(): int
    {
        return $this->start(false)
            ->builder
            ->count(["id"]);
    }

    protected function start(bool $isModel = false)
    {
        $this->builder = $isModel ? EmailTemplate::query() : DB::table(EmailTemplate::TABLE);
        return $this;
    }

    /**
     * @param bool $isModel
     * @return Collection|EmailTemplate[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get(bool $isModel = true)
    {
        return $this->getBuilderWithStart($isModel)
            ->get();
    }
}
