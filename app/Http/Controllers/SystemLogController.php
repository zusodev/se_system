<?php

namespace App\Http\Controllers;

use App\Services\SystemLogService;
use Illuminate\Support\Collection;
use function request;

class SystemLogController extends Controller
{
    private $service;

    public function __construct(SystemLogService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $files = $this->service->fileNames();

        $fileName = $this->getFileName($files);

        $fileContent = $this->service->getLogContent($fileName);

        return view('systemLog.index', [
            'files' => $files,
            'fileName' => $fileName,
            'fileContent' => $fileContent
        ]);
    }

    /**
     * @param Collection $files
     * @return mixed|string
     */
    public function getFileName(Collection $files)
    {
        $fileName = '';
        if ($files->isEmpty()) {
            return $fileName;
        }

        $fileName = request('fileName') ?: $files[0];

        if (!in_array($fileName, $files->toArray())) {
            return '';
        }

        return $fileName;
    }

}
