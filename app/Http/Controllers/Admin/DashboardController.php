<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Services\UserService;

class DashboardController extends Controller
{

    public $userService,$supportService;

    protected $title_name;
    protected $route;
    protected $singular_name;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->title_name = 'Dashboards';
        $this->singular_name = 'Dashboard';
        $this->route = 'dashboard';

        view()->share("title", $this->title_name);
        view()->share("singular_name", $this->singular_name);
        view()->share("route", $this->route);
    }

    public function index()
    {
        
        $appUsersCount = $this->userService->getAppUserCount();
        $adminUsersCount = $this->userService->getAdminUserCount();
        $supportsCount = 0;
        return view('admin.' . $this->route . '.index',compact('appUsersCount','adminUsersCount','supportsCount'));
    }
}
