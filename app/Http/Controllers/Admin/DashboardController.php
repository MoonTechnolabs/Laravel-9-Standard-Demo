<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public $userService,$supportService;

    protected $title_name;
    protected $route;
    protected $singular_name;


    public function __construct()
    {


        $this->title_name = 'Dashboards';
        $this->singular_name = 'Dashboard';
        $this->route = 'dashboard';

        view()->share("title", $this->title_name);
        view()->share("singular_name", $this->singular_name);
        view()->share("route", $this->route);
    }

    public function index()
    {

        $appUsersCount = 0;
        $adminUsersCount = 0;
        $supportsCount = 0;
        return view('admin.' . $this->route . '.index',compact('appUsersCount','adminUsersCount','supportsCount'));
    }
}
