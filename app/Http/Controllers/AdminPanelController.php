<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function getPanel(){
    	return view('admin/panel/panel');
    }
}
