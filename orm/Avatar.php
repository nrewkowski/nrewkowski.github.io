<?php

class Avatar{
    public $bodyImage; 
    public $chest; 
    public $head; 
    public $shoes;


    //we only need the id because if the player is validated, then that's all we need
    //this will get all of the player's info from the database and set them to the above variables
    public function __construct($bodyImage,$chest,$head,$shoes){
        $this->bodyImage=$bodyImage;
        $this->chest=$chest;
        $this->head=$head;
        $this->shoes=$shoes;
    }

}