<?php

namespace App\Controllers;

use App\Models\TimeModel;


class testController extends BaseController
{
    public function index(){
        return view("list_time");
    }
}