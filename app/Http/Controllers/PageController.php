<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function function1()
    {
        return view('page1');
    }
    
    public function function2()
    {
        return view('page2');
    }
    
    public function function3()
    {
        return view('/folder1/page3');
    }
    
    public function jobpost(Request $request)
    {
        // Add Bearer token to the request's Authorization header
        $request->headers->set('Authorization', 'Bearer '.session('token').'');

        return view('jobpost');
    }
}
