<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            return $this->authService->authenticate($request);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            return $this->authService->logout($request);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }
}
