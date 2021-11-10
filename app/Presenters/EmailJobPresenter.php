<?php


namespace App\Presenters;


use App\Models\EmailJob;

class EmailJobPresenter
{
    public static function statusText(int $status): string
    {
        switch ($status){
            case EmailJob::WAIT_STATUS:
                return '<span class="badge badge-secondary">待執行中</span>';
            case EmailJob::RUNNING_STATUS:
                return '<span class="text-white badge badge-warning">已開始寄信</span>';
            case EmailJob::FINISH_STATUS:
                return '<span class="badge badge-success">已完成寄信</span>';
            case EmailJob::CANCEL_STATUS:
                return '<span class="badge badge-danger">取消</span>';
            case EmailJob::NO_USER:
                return '<span class="text-white badge badge-warning">無目標使用者</span>';
        }
        return "";
    }
}
