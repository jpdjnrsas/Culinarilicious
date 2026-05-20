<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect('/admin/orders');
        }

        if ($user->role === 'rider') {
            return redirect('/rider/orders');
        }

        return redirect('/foods');
    }
}