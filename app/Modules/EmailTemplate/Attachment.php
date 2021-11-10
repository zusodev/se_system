<?php


namespace App\Modules\EmailTemplate;


use function shell_exec;
use function storage_path;

class Attachment
{
    const CONTENT_TYPES = [
        "email_template_default.doc" => "text/rtf",
        "default.html" => "text/html",
        "default.vbs" => "text/plain"
    ];

    const WORD_FILENAME = "email_template_default.doc";
    const HTML_FILENAME = "default.html";
    const VBS_FILENAME = "default.vbs";
    const PS1_FILENAME = "default.ps1";
    const URL_FILENAME = "default.url";
    const BAT_FILENAME = "default.bat";
    const EXE_FILENAME = "default.exe";

    public static function getAttachmentTemplates()
    {
        return [
            'doc' => [
                'file_name' => self::WORD_FILENAME,
                'note' => ""
            ],
            'HTML' => [
                'file_name' => self::HTML_FILENAME,
                'note' => "",
            ],
            'vbs' => [
                'file_name' => self::VBS_FILENAME,
                'note' => "注意，VBS 易被 Mail Server 視為惡意附件檔案，而阻擋信件"
            ],
            'ps1' => [
                'file_name' => self::PS1_FILENAME,
                'note' => "ps1 檔案必須使用 PowerShell 執行才能收到 log "
            ],
            'url' => [
                "file_name" => self::URL_FILENAME,
                "note" => "",
            ],
            'bat' => [
                "file_name" => self::BAT_FILENAME,
                "note" => "",
            ],
            /*'exe' => [
                "file_name" => self::EXE_FILENAME,
                "note" => "EXE 檔案需經過編譯建置，使用 EXE 檔將影響寄信速度",
            ],*/
        ];
    }

    public static function getContentTypes(string $fileName)
    {
        if (empty(self::CONTENT_TYPES[$fileName])) {
            return "text/plain";
        }

        return self::CONTENT_TYPES[$fileName];
    }

}
