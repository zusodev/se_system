<?php

namespace App\Http\Controllers;

use App\Models\EmailProject;
use App\Modules\WordReport\ReportRepository;
use App\Modules\WordReport\WordReportGenerator;
use Exception;
use Log;
use function array_merge;
use function env;
use function explode;
use function request;
use function response;
use function str_replace;
use function view;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        $paginator = $this->reportRepository->paginateEmailProject();

        return view('report.index', [
            'paginator' => $paginator,
        ]);
    }

    public function downloadPage(EmailProject $emailProject, string $type)
    {
        $typeText = '';
        switch ($type) {
            case 'open_mail_users_csv':
                $typeText = 'CSV 開啟連結名單';
                break;
            case 'word':
                $typeText = 'Word 報告書';
                break;
        }


        $route = route('report.download', [$emailProject->id, $type]);
        if (strpos(env('APP_URL'), 'https') !== false) {
            $route = str_replace('http', 'https', $route);
        }
        return view('report.download-page', [
            'projectName' => $emailProject->name,
            'name' => $typeText . ' 下載',
            'downloadReportUrl' => $route
        ]);
    }

    public function download(EmailProject $emailProject, string $type, WordReportGenerator $reportGenerator)
    {
        try {
            $projectIds = [$emailProject->id];
            if (request('project_ids')) {
                $projectIds = array_merge($projectIds, explode(',', request('project_ids')));
            }
            switch ($type) {
                case 'open_mail_users_csv':
                    return $this->csvResponse(
                        $this->reportRepository->openMailUsersCsv($projectIds),
                        $emailProject->name . '_開啟連結名單'
                    );
                case 'word':
                    $extension = '.docx';
                    $reportGenerator->generate($projectIds);
                    return response()->download(
                        $reportGenerator->wordPath() .
                        '/' .
                        $emailProject->id . $extension,
                        $emailProject->id . '_' .
                        $emailProject->name . '_演練報告書' . $extension
                    );
            }

        } catch (Exception $e) {
            Log::error($e);
        }

        return view('report.close');
    }

}
