<?php

class Apparel{
    public $image; 
    public $name; 
    public $slot; 
    public $value;


    //we only need the id because if the player is validated, then that's all we need
    //this will get all of the player's info from the database and set them to the above variables
    public function __construct($image,$name,$slot,$value){
        $this->image=$image;
        $this->name=$name;
        $this->slot=$slot;
        $this->value=$value;
    }

}