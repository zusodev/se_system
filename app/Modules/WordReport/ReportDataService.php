<?php


namespace App\Modules\WordReport;


use App\Models\EmailProject;
use Illuminate\Support\Collection;
use PhpOffice\PhpWord\PhpWord;
use stdClass;

class ReportDataService
{
    /** @var PhpWord */
    protected $phpWord;

    /** @var ReportRepository */
    protected $reportRepository;

    /** @var EmailProject[]|\Illuminate\Database\Eloquent\Collection */
    protected $emailProjects;

    protected $projectIds = [];

    protected $allActionLogCount = [];

    /** @var Collection */
    protected $allActionCountGroupByDepartment = null;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->phpWord = new PhpWord();
        $this->reportRepository = $reportRepository;
        $this->allActionLogCount = [];
    }

    public function getPhpWord(): PhpWord
    {
        return $this->phpWord;
    }

    public function setData(array $projectIds)
    {
        $this->projectIds = $projectIds;
        $this->emailProjects = EmailProject::whereIn('id', $projectIds)
            ->orderByDesc('id')
            ->get();
        $this->company = $this->emailProjects[0]->company;
    }

    public function getFirstProject(): EmailProject
    {
        return $this->emailProjects[0];
    }

    public function getFirstProjectName()
    {
        return $this->emailProjects[0]->name;
    }

    public function getFirstCompanyName(): string
    {
        return $this->emailProjects[0]->company->name;
    }

    public function allActionLogCount()
    {
        if ($this->allActionLogCount instanceof Collection) {
            return $this->allActionLogCount;
        }

        $total = new stdClass();

        $total->user_count = 0;
        $total->open_count = 0;
        $total->open_link_count = 0;
        $total->open_attachment_count = 0;
        $total->post_count = 0;
        $total->none_count = 0;
        $counts = $this->reportRepository->allActionLogCountByEmailProject($this->projectIds);
        foreach ($counts as $count) {
            $total->user_count += $count->user_count;
            $total->open_count += $count->open_count;
            $total->open_link_count += $count->open_link_count;
            $total->open_attachment_count += $count->open_attachment_count;
            $total->post_count += $count->post_count;
            $total->none_count += $count->none_count;
        }

        $this->allActionLogCount = $total;
        return $this->allActionLogCount;
    }

    public function countActionTopTenGroupByDepartment(array $where)
    {
        return $this->reportRepository->actionCountGroupByDepartment($where, $this->projectIds);
    }

    public function getDepartmentActionCount()
    {
        if ($this->allActionCountGroupByDepartment) {
            return $this->allActionCountGroupByDepartment;
        }

        $this->allActionCountGroupByDepartment = $this->reportRepository
            ->allActionCountGroupByDepartment($this->projectIds);
        return $this->allActionCountGroupByDepartment;
    }

    public function twoActionUsers()
    {
        return $this->reportRepository
            ->twoActionUsers($this->projectIds);
    }
}
