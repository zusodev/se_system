<?php

namespace App\Rules;

use App\Models\TargetDepartment;
use App\Repositories\TargetUserRepository;
use DB;
use Illuminate\Contracts\Validation\Rule;

class TargetUserEmailUniqueRule implements Rule
{
    /** @var int */
    protected $companyId;
    /** @var int */
    protected $departmentId;

    public function __construct(int $companyId = null, int $departmentId = null)
    {
        $this->companyId = $companyId;
        $this->departmentId = $departmentId;
    }

    public function passes($attribute, $value)
    {
        return TargetUserRepository::checkUserEmailIsValid($value, $this->departmentId, $this->companyId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is exists in this company';
    }
}
