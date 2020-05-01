<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;

use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Controllers\Controller;

class FrontController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function admin(){
    return view('admin.index');
  }
}
