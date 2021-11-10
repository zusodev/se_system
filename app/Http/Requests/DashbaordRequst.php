<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashbaordRequst extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getLimit()
    {
        $limit = $this->query("limit");
        return $limit ? $limit : 10;
    }
}
