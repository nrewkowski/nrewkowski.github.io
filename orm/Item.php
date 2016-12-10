<?php

class Item{
    public $description; 
    public $image; 
    public $healthChange; 
    public $name; 
    public $price; 


    public function __construct($description,$image,$healthChange,$name,$price){
        $this->description=$description;
        $this->image=$image;
        $this->healthChange=$healthChange;
        $this->name=$name;
        $this->price=$price;
        
    }

}