<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenenceController extends Controller
{
    public function clearAppCache(){
        Artisan::call('cache:clear');
    }
}
