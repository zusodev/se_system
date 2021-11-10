<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDetailLog extends Model
{
    const TABLE = "email_detail_logs";
    const ID = self::TABLE . '.id';

    const ACTION = self::TABLE . ".action";

    const REQUEST_BODY = self::TABLE . ".request_body";
    const LOG_ID = self::TABLE . ".log_id";

    protected $table = self::TABLE;

    /**
     * ips 資料結構如下：
     * 1. {} 空白
     * 2. { "ips": ["127.0.0.1"], "HTTP_X_FORWARD_FOR" => "127.0.0.1", "HTTP_X_REAL_IP" => "127.0.0.1" }
     */
    protected $fillable = [
        "log_id",
        "ips",
        "agent",
        "action",
        "request_body",
    ];

    public function actionHtml(): string
    {
        switch ($this->action) {
            case 'is_open':
                return "<span class='badge badge-primary' style='font-size: 16px;'>開啟信件</span>";
            case "is_open_link":
                return "<span class='badge badge-warning' style='font-size: 16px;'>開啟連結</span>";
            case "is_open_attachment":
                return "<span class='badge badge-danger' style='font-size: 16px;'>開啟附件</span>";
            case "is_post_from_website":
                return "<span class='badge badge-danger' style='font-size: 16px;'>送出表單</span>";
        }
        return "";
    }
}
