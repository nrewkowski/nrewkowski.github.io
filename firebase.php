<?php

require_once('orm/Player.php');
require_once('orm/Monster.php');
require_once('orm/BattleAction.php');
require_once('orm/Item.php');
require_once('orm/Apparel.php');
require_once('orm/Avatar.php');
require_once('orm/Inventory.php');
require '\vendor\ktamas77\firebase-php\src\firebaseLib.php';

//http://wwwp.cs.unc.edu/Courses/comp426-f16/users/nrewkows/project/firebase.php
///afs/cs.unc.edu/project/courses/comp426-f16/public_html/users/nrewkows/project

const DEFAULT_URL = 'https://comp426-project.firebaseio.com';
const DEFAULT_TOKEN = 'mZu3uFzFAPLvxWYj2vhbQVoyRKhTQBO5ustKLV8G';
const DEFAULT_PATH = '/firebase/comp426-project';

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
//$path_components = explode('/', $_SERVER['PATH_INFO']);

/*

this is mostly for luke and i, but it would be good for everyone to understand how to orm layer works
if we just want to do a simple GET, the syntax is the same as we said yesterday.
However, for a POST call, I want us to add the type of object to call it on and the method name as a part of the url path, 
with ? parameters being playerID, and the paremeters of the method. So if you wanted to add something to a player's inventory, then you should do this:
/baseURL/addToInventory?playerID=_&itemIDToAdd=_&numToAdd=_
if we wanted to change the health of a monster, then you can say /baseURL/updateMonsters?playerID=_&monster1HP=_&monster1Attack=_&monster1Defense=_&monster1Experience=_
&monster1Speed=_&monster2HP=_&etc....
if you wanted to change gold, username, etc., then call like this
/baseURL/changeGold?playerID=_&amountToChange=_


for GET ,
if we want to get a specific member variable of a player, then we need the parameters ?playerID=_&?requestedVariable=_. This can return any of Player's member variables in the ORM layer I sent.
if we want to get a specific monster for a player, then we need the parameters ?playerID=_&requestedVariable="monster"&monsterID=_
this same logic applies to a member variable of any object. so the basic structure is this:
?playerID=_&requestedVariable='nameOfVariable'&requestedVariableID=_&requestedVariableChild="nameOfVariableChild"&requestedVariableChildID=_&.....
ID is only required is the requested variable is part of an array

*/
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  /*
     if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) { //this implies call of a method

      /*
        $player_id = intval($path_components[1]);

        // Look up object via ORM
        $todo = Player::findByID($todo_id);

        if ($todo == null) {
        // Todo not found.
        header("HTTP/1.0 404 Not Found");
        print("Todo id: " . $todo_id . " not found.");
        exit();
        }

        // Check to see if deleting
        if (isset($_REQUEST['delete'])) {
        $todo->delete();
        header("Content-type: application/json");
        print(json_encode(true));
        exit();
        } 

        // Normal lookup.
        // Generate JSON encoding as response
        header("Content-type: application/json");
        print($todo->getJSON());
        */
        /*
        exit();

    }
    else{ //just a get method*/
      if (isset($_REQUEST['playerID'])) {
        $playerID = intval(trim($_REQUEST['playerID']));
        if ($playerID == "") {
          header("HTTP/1.0 400 Bad Request");
          //print("Bad title");
          exit();
        }

        print(json_encode(Player::getPlayerByID($playerID)));
      }
    //}
}
/*
$test = array(
    "foo" => "bar",
    "i_love" => "lamp",
    "id" => 42
);

$dateTime = new DateTime();
$firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

// --- storing a string ---
$firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");

// --- reading the stored string ---
$name = $firebase->get(DEFAULT_PATH . '/name/contact001');
*/

//print(json_encode(Player::getPlayerByID(1)));
print("worked");
?>