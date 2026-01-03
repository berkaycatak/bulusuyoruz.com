<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $events = auth()->user()->events()->latest()->get();
        return view('dashboard', compact('events'));
    }
}
