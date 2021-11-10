<?php

namespace App\Http\Requests;

use App\Repositories\EmailLogRepository;
use Illuminate\Foundation\Http\FormRequest;
use function base64_decode;
use function is_array;
use function is_string;

class EmailLogRequest extends FormRequest
{
    private $repository;

    public function __construct(EmailLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getUUID(): string
    {
        $uuid = $this->query("uuid");
        if (!$uuid || !is_string($uuid)) {
            return "";
        }
        $uuid = base64_decode($uuid);
        return $uuid;
    }

    public function formUUIDs(): array
    {
        $uuids = $this->get("ids");
        if (!is_array($uuids)) {
            return [];
        }
        return $uuids;
    }
}
