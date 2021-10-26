<?php

namespace Backbeat;
use Backbeat\Models\Image;


class ImageController {

    public function index() {

        return view('pages/create');
    
    }


    public function store() {

        $URL   = $_POST['URL'] ?? ''; 
        $description = $_POST['description'] ?? ''; 

        Image::add([
            'URL'  => $URL, 
            'description' => $description,
        ]);
    
    }

}




?>