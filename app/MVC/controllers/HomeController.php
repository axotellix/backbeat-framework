<?php

namespace Backbeat;


// class HomeController extends Controller {
class HomeController {

    public function index() {

        return view('pages/index');
        //echo 'done';
        // get > cards
        //$cards = Card::all();

        // return > view
        //return view('index', ['cards' => $cards]);
    
    }

}




?>