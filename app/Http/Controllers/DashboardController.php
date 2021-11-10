<?php

namespace App\Http\Controllers;

use App\Mail\TemplateMail\TemplateExeAttachementGenerator;
use App\Modules\WordReport\ReportRepository;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailLogRepository;
use App\Repositories\EmailProjectRepository;
use App\Repositories\TargetCompanyRepository;
use App\Repositories\TargetDepartmentRepository;
use App\Repositories\TargetUserRepository;
use DB;
use Illuminate\Support\Collection;
use function fopen;
use function fputcsv;
use function rewind;
use function stream_get_contents;
use function view;

class DashboardController extends Controller
{
    private $userRepository;
    private $departmentRepository;
    private $jobRepository;
    private $logRepository;
    private $reportRepository;
    private $projectRepository;
    private $companyRepository;

    public function __construct(
        TargetDepartmentRepository $departmentRepository,
        TargetUserRepository $userRepository,
        EmailJobRepository $jobRepository,
        EmailLogRepository $logRepository,
        ReportRepository $reportRepository,
        EmailProjectRepository $projectRepository,
        TargetCompanyRepository $companyRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->userRepository = $userRepository;
        $this->jobRepository = $jobRepository;
        $this->logRepository = $logRepository;
        $this->reportRepository = $reportRepository;
        $this->projectRepository = $projectRepository;
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $sql = "
        SELECT COUNT(*) AS count FROM target_company
        UNION ALL
        SELECT COUNT(*) AS count FROM target_user
        UNION ALL
        SELECT COUNT(*) AS count FROM email_project
        UNION ALL
        SELECT COUNT(*) AS count FROM email_log;
        ";
        $result = Collection::make(DB::select($sql));
        [$companyCount, $userCount, $projectCount, $emailLogCount] = $result
            ->pluck("count")
            ->toArray();

        $emailProjects = $this->reportRepository->allActionLogCountByEmailProject();

        return view("dashboard.index", [
            "companyCount" => $companyCount,
            "userCount" => $userCount,
            "projectCount" => $projectCount,
            "emailLogCount" => $emailLogCount,
            "emailProjects" => $emailProjects,
        ]);
    }
}
