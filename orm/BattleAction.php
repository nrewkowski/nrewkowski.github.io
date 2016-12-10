<?php

class BattleAction{
    public $hpChange; 
    public $name; 


    //we only need the id because if the player is validated, then that's all we need
    //this will get all of the player's info from the database and set them to the above variables
    public function __construct($hpChange,$name){
        $this->hpChange=$hpChange;
        $this->name=$name;
    }

}