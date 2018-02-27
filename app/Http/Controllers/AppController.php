<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard()
    {
    	$data["page"] = "App Dashboard";
    	return view("app.dashboard", $data);
    }
    public function add_task()
    {
    	sleep(1);
    	return view("app.add_task");
    }
    public function view_task()
    {
    	sleep(1);
    	return view("app.view_task");
    }
}

