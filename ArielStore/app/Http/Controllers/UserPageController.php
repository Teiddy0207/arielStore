<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function index()
    {
        return view('userpage.index');
    }

    public function showShirt() 
    {
        return view('userpage.shirt');
    }

    public function showPant()
    {
        return view('userpage.pant');
    }

    public function showSkirt() 
    {
        return view('userpage.skirt');
    }

    public function showAccessories() 
    {
        return view('userpage.accessories');
    }

    public function showAll() 
    {
        return view('userpage.all');
    }

    public function showSale() 
    {
        return view('userpage.sale');
    }

        public function showNew() 
    {
        return view('userpage.new');
    }
}
