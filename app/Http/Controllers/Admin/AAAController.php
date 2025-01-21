<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AAAController extends Controller
{
    //
    public function add()
    {
        return view('admin.news.create');
    }
}

//課題Laravel 09
use App\Http\Controllers\Admin\AAAController;
Route::Controller(AAAController::class)->group(function() {
    Route::get('/XXX', 'bbb');
});    