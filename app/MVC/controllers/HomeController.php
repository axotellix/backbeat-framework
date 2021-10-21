<?php

namespace Backbeat;
use Backbeat\Models\Image;


// class HomeController extends Controller {
class HomeController {

    public function index() {

        //print_r( Image::all() );
        //$imgs = Schema::table('images')->all();
        $imgs = Image::select('id')->take(2)->get();

        foreach( $imgs as $img ) {
            echo $img->URL . "<br>";
        }

        //return view('pages/index');

        //echo 'done';
        // get > cards
        //$cards = Card::all();

        // return > view
        //return view('index', ['cards' => $cards]);
    
    }

}




?>