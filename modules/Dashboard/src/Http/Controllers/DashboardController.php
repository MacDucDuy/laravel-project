<?php

namespace Modules\Dashboard\src\Http\Controllers;



use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Trang tổng quan';
        return view('dashboard::dashboard',[
            'title' => $title
        ]);
    }
}
