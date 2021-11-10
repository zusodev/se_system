<?php

namespace App\Http\Controllers;

use App\Responses\ControllerResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use ControllerResponseTrait, AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
