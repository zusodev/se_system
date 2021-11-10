<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Str;
use Log;
use Route;
use function is_null;


class BaseService
{
    protected $result = false;
    /** @var int $resultException */
    protected $resultMessageType = null;
    /** @var Exception $resultException */
    protected $resultException = null;

    const IS_CREATE = 0;
    const IS_UPDATE = 1;
    const IS_DELETE = 2;

    protected function newResultMessage()
    {
        $this->autoSetResultyTypeByRouteName();

        return $this->resultMessage(
            $this->result,
            $this->resultMessageType,
            $this->resultException
        );
    }

    // TODO Remove
    protected function resultMessage(bool $result, ?int $type, Exception $exception = null): string
    {
        switch ($type) {
            case self::IS_CREATE:
                $message = "新增";
                break;
            case self::IS_UPDATE:
                $message = "修改 ";
                break;
            case self::IS_DELETE:
                $message = "刪除 ";
                break;
        }
        $message .= $result ? "成功" : "失敗";


        if (!is_null($exception)) {
            $message .= ", " . $exception->getMessage();
        }

        return $message;
    }

    protected function autoSetResultyTypeByRouteName(): void
    {
        $routeName = Route::currentRouteName();
        if (Str::contains($routeName, "destroy")) {
            $this->resultMessageType = self::IS_DELETE;
        } else if (Str::contains($routeName, "store")) {
            $this->resultMessageType = self::IS_CREATE;
        } else if (Str::contains($routeName, "update")) {
            $this->resultMessageType = self::IS_UPDATE;
        }
    }

    protected function setFailResult(Exception $e)
    {
        $this->result = false;
        $this->resultException = $e;
        Log::error($e);
    }
}
