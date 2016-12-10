<?php

class Monster{
    public $permanentStats; 
    public $currentStats; 
    public $battleActions; 
    public $givenName;
    public $level; 


    //we only need the id because if the player is validated, then that's all we need
    //this will get all of the player's info from the database and set them to the above variables
    public function __construct($permanentStats,$currentStats,$battleActionIDs,$givenName,$level){
        $this->permanentStats=$permanentStats;
        $this->currentStats=$currentStats;
        $this->battleActions=$battleActionIDs;
        $this->givenName=$givenName;
        $this->level=$level;
    }

}