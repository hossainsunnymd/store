<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PolicyController extends Controller
{
    public function policyByType(Request $request){
        $type = $request->type;
        return Cache::remember('policyByType'.$type, 3600, function () use ($type) {
            return Policy::where('type', $type)->first();
        });
    }
}
