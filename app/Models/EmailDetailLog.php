<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDetailLog extends Model
{
    const TABLE = "email_detail_logs";
    const T_ID = self::TABLE . '.id';
    const T_ACTION = self::TABLE . ".action";
    const T_REQUEST_BODY = self::TABLE . ".request_body";
    const T_LOG_ID = self::TABLE . ".log_id";
    const T_IS_TW_IP = self::TABLE . '.is_tw_ip';

    const ACTION_IS_POST_FROM_WEBSITE = 'is_post_from_website';

    const LOG_ID = 'log_id';
    const IPS = 'ips';
    const AGENT = 'agent';
    const ACTION = 'action';
    const REQUEST_BODY = 'request_body';
    const IS_TW_IP = 'is_tw_ip';

    protected $table = self::TABLE;

    /**
     * ips 資料結構如下：
     * 1. {} 空白
     * 2. { "ips": ["127.0.0.1"], "HTTP_X_FORWARD_FOR" => "127.0.0.1", "HTTP_X_REAL_IP" => "127.0.0.1" }
     */
    protected $fillable = [
        self::LOG_ID,
        self::IPS,
        self::IS_TW_IP,
        self::AGENT,
        self::ACTION,
        self::REQUEST_BODY,
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
