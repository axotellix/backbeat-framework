<?php

namespace Backbeat;
use Backbeat\Models\Image;


// class HomeController extends Controller {
class HomeController {

    public function index() {

        $imgs = Image::all();

        return view('pages/index', ['imgs' => $imgs]);

        //echo 'done';
        // get > cards
        //$cards = Card::all();

        // return > view
        //return view('index', ['cards' => $cards]);
    
    }

}




?>