<?php


namespace App\Mail\TemplateMail;


use App\Models\EmailLog;
use App\Models\EmailProject;
use Exception;
use Log;
use Storage;
use function file_get_contents;
use function shell_exec;
use function storage_path;
use function str_replace;

class TemplateExeAttachementGenerator
{
    /**
     * @param EmailProject $emailProject
     * @param EmailLog $emailLog
     * @param string $attachmentLink
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function getAttachment(
        EmailProject $emailProject,
        EmailLog $emailLog,
        string $attachmentLink
    ): string
    {
        $storage = self::localStorage();
        if ($storage->exists(self::getExeBasePath($emailProject, $emailLog))) {
            return $storage->get(self::getExeBasePath($emailProject, $emailLog));
        }

        self::generateGoFile($emailProject, $emailLog, $attachmentLink);

        self::generateExe($emailProject, $emailLog);

        self::removeGoFile($emailProject, $emailLog);

        return $storage->get(self::getExeBasePath($emailProject, $emailLog));
    }

    public static function localStorage()
    {
        return Storage::disk("email_project");
    }

    protected static function generateGoFile(
        EmailProject $emailProject,
        EmailLog $emailLog,
        string $attachmentLink
    )
    {
        $path = self::getGoLangBasePath($emailProject, $emailLog);
        $content = str_replace(
            "http://target_url",
            $attachmentLink,
            file_get_contents(storage_path("attachment_templates/create-exe.go"))
        );
        return self::localStorage()->put(
            $path,
            $content
        );
    }


    protected static function generateExe(EmailProject $emailProject, EmailLog $emailLog)
    {
        $exePath = storage_path("app/email_project/" . self::getExeBasePath($emailProject, $emailLog));
        $cmd = "GOCACHE=/tmp/.go_cache GOOS=windows GOARCH=amd64 go build -o " .
            $exePath . " " .
            storage_path("app/email_project/" . self::getGoLangBasePath($emailProject, $emailLog));
        $chownCmd = "sudo -u chown www-data:www-data " . $exePath;

        if(env("LOG_GENERATE_EXE_ATTACHMENT_CMD")){
            Log::info(shell_exec("whoami"));
           Log::info($cmd);
           Log::info($chownCmd);
        }

        return shell_exec($cmd) && shell_exec($chownCmd);
    }

    /**
     * @param EmailProject $emailProject
     * @param EmailLog $emailLog
     * @return string
     */
    protected static function getExeBasePath(EmailProject $emailProject, EmailLog $emailLog): string
    {
        return $emailProject->id . "/" . $emailLog->id . ".exe";
    }

    /**
     * @param EmailProject $emailProject
     * @param EmailLog $emailLog
     * @return string
     */
    protected static function getGoLangBasePath(EmailProject $emailProject, EmailLog $emailLog): string
    {
        return $emailProject->id . "/" . $emailLog->id . ".go";
    }

    protected static function removeGoFile(EmailProject $emailProject, EmailLog $emailLog)
    {
        $path = self::getGoLangBasePath($emailProject, $emailLog);
        if (self::localStorage()->exists($path)) {
            return self::localStorage()->delete($path);
        }
        return true;
    }
}
