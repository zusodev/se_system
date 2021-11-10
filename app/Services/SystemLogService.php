<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Log;
use function array_merge;
use function array_values;
use function env;
use function file_exists;
use function file_get_contents;
use function filesize;
use function is_array;
use function is_dir;
use function is_string;
use function number_format;
use function scandir;
use function storage_path;

class SystemLogService
{
    /**
     * @param string $fileName
     * @return string
     */
    public function getLogContent(string $fileName): string
    {
        if ($fileName == "") {
            return "";
        }
        $path = $this->filePathByFileName($fileName);


        try {
            $fileSizeMB = $this->formatSizeToMb(filesize($path));
            if ($fileSizeMB > 2) {
                return "file size is over 2MB, Sorry(QQ)";
            }

            $fileContent = file_get_contents($path);
        } catch (Exception $e) {
            Log::warning("SystemLogService getLogContent Error :" . $e->getMessage());
            $fileContent = "Error : " . $e->getMessage();
        }
        return is_string($fileContent) ? $fileContent : "";
    }

    public function fileNames(): Collection
    {
        $path = storage_path("logs");
        if (!file_exists($path) || !is_dir($path)) {
            return Collection::make();
        }

        $files = scandir($path);
        $files = $this->appendFiles($files, $this->webServerPathFromEnv());

        $files = Collection::make(is_array($files) ? $files : []);
        $files = $files->filter(function ($fileName) {
            if (Str::contains($fileName, ".log")) {
                return true;
            }

            return false;
        });

        $files = array_values($files->toArray());
        return Collection::make($files);
    }


    private function filePathByFileName(string $fileName): string
    {
        if (Str::contains($fileName, "laravel-20")) {
            $path = storage_path("logs/" . $fileName);
        } elseif (Str::contains($fileName, "access")) {
            $path = $this->webServerPathFromEnv() . "/" . $fileName;
        } elseif (Str::contains($fileName, "error")) {
            $path = $this->webServerPathFromEnv() . "/" . $fileName;
        } else {
            $path = "";
        }

        return $path;
    }

    /**
     * @return mixed
     */
    private function webServerPathFromEnv(): string
    {
        return env("WEB_SERVER_LOG_PATH", "/var/log/nginx/");
    }

    /**
     * @param array $files
     * @param string $path
     * @return array
     */
    private function appendFiles(array $files, string $path): array
    {
        if (!file_exists($path) || !is_dir($path)) {
            return $files;
        }

        try {
            $files = array_merge($files, scandir($path));
        } catch (Exception $e) {
            Log::warning("SystemLogService appendFiles Error :" . $e->getMessage());
        }
        return $files;
    }

    private function formatSizeToMb($bytes)
    {
        return (float)number_format($bytes / 1048576, 4);
    }
}
