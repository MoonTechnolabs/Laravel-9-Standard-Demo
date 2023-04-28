<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    
    /**
    * @OA\Info(
    *    title="Laravel9 APP API",
    *    version="V1",
    * )
    */
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($type,$msg)
    {
        return redirect()->back()->with($type, $msg)->withInput();
    }
}
