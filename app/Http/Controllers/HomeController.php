<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /* Success Page */      
    public function success() {
        return view('front.success');
    }

    /* Set Time Zone in Sesstion For date display USE Start*/
    public function settimezone(Request $request){        
        $data = $request->all();        
        Session::put('customTimeZone', $data['timezone']);        
    }
}
