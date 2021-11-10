<?php


namespace App\Services;


use App\Models\EmailLog;
use App\Repositories\EmailDetailLogRepository;
use App\Repositories\EmailLogRepository;
use Exception;
use Log;
use function explode;
use function is_string;
use function json_encode;
use function request;

class EmailLogCollector
{
    private $repository;

    private $detailLogRepository;

    public function __construct(EmailLogRepository $repository, EmailDetailLogRepository $detailLogRepository)
    {
        $this->repository = $repository;
        $this->detailLogRepository = $detailLogRepository;
    }

    public function updateLog(EmailLog $emailLog, string $actionColumn)
    {
        if (!$emailLog) {
            return;
        }

        try {
            $detailLogAction = explode(".", $actionColumn)[1];
            if (!is_string($detailLogAction)) {
                throw new Exception("error actionColumn" . $actionColumn);
            }

            $detailLogAttributes = $this->getDetailLogAttributes($detailLogAction, $emailLog->id);

            $this->repository->update($emailLog->uuid, [
                $actionColumn => true
            ]);
            $this->detailLogRepository->create($detailLogAttributes);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * @param string $logAction
     * @return array
     */
    private function getDetailLogAttributes(string $logAction, int $logId): array
    {

        $detailLogAttributes = [
            "log_id" => $logId,
            "agent" => request()->userAgent(),
            "action" => $logAction,
        ];

        $detailLogAttributes = $this->tryToAddRequestBodyWhenPostMethod($detailLogAttributes);
        $detailLogAttributes = $this->tryToAddClientIps($detailLogAttributes);
        return $detailLogAttributes;
    }

    /**
     * @param array $detailLogAttributes
     * @return array
     */
    private function tryToAddRequestBodyWhenPostMethod(array $detailLogAttributes): array
    {
        if (!env('EMAIL_LOG_IS_STORE')) {
            return $detailLogAttributes;
        }
        if (!request()->isMethod("post")) {
            return $detailLogAttributes;
        }

        try {
            $detailLogAttributes['request_body'] = json_encode(request()->all());
        } catch (Exception $e) {
            Log::error($e);
        }

        return $detailLogAttributes;
    }

    private function tryToAddClientIps(array $detailLogAttributes): array
    {

        try {
            $ips = [
                'ips' => request()->getClientIps(),
                'HTTP_X_FORWARD_FOR' => request()->server('HTTP_X_FORWARD_FOR', ''),
                'HTTP_X_REAL_IP' => request()->server('HTTP_X_REAL_IP', ''),
            ];
            $detailLogAttributes["ips"] = json_encode($ips);
        } catch (Exception $e) {
            Log::error($e);
        }

        return $detailLogAttributes;
    }
}
