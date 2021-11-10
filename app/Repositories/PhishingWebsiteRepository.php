<?php


namespace App\Repositories;


use App\Models\EmailProject;
use App\Models\PhishingWebsite;
use DB;
use Illuminate\Support\Collection;

class PhishingWebsiteRepository extends BaseRepository
{
    protected $perPage = 30;

    public function paginateJoinWithProjectCount()
    {
        return $this->start(true)
            ->joinWithProjectUsed()
            ->builder
            ->orderBy(PhishingWebsite::ID, "desc")
            ->groupBy(PhishingWebsite::ID)
            ->paginate($this->perPage, [
                PhishingWebsite::ID,
                PhishingWebsite::TABLE . ".name",
                PhishingWebsite::TABLE . ".received_form_data_is_ok",
                "sub.project_count",
            ]);
    }

    protected function joinWithProjectUsed()
    {
        $builder = DB::table(PhishingWebsite::TABLE)
            ->leftJoin(EmailProject::TABLE, PhishingWebsite::ID, "=", EmailProject::PHISHING_WEBSITE_ID)
            ->select(["phishing_website.id as phishing_website_id"])
            ->selectRaw("COUNT(email_project.id)  as project_count")
            ->groupBy(PhishingWebsite::ID);

        $this->builder->leftJoin(
            DB::raw("( {$builder->toSql()} ) as `sub`"),
            PhishingWebsite::ID,
            "=",
            "sub.phishing_website_id"
        );
        return $this;
    }

    protected function start(bool $isModal)
    {
        $this->builder = $isModal ?
            PhishingWebsite::query() :
            DB::table(PhishingWebsite::TABLE);
        return $this;
    }

    public function update(int $id, array $attributes)
    {
        $attributes["received_form_data_is_ok"] = false;

        return $this->getBuilderWithStart(true)
            ->where("id", $id)
            ->update($attributes);
    }

    /**
     * @param bool $false
     * @return Collection|PhishingWebsite[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get(bool $isModel = true)
    {
        return $this->getBuilderWithStart($isModel)
            ->get();
    }
}
