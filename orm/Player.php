<?php

class Player{
    public $username; //string
    public $monsters; //array
    public $avatar; //avatar
    public $inventory; //inventory
    public $playerID; //int

    public static function connect(){
        $DEFAULT_URL = 'https://comp426-project.firebaseio.com';
        $DEFAULT_TOKEN = 'mZu3uFzFAPLvxWYj2vhbQVoyRKhTQBO5ustKLV8G';
        //const DEFAULT_PATH = '/firebase/comp426-project';
        //now the default path is root

        return new \Firebase\FirebaseLib($DEFAULT_URL, $DEFAULT_TOKEN);
    }

    public static function getPlayerByID($id){
        $firebase=Player::connect();
        $username=$firebase->get('/Players/' . $id . '/Username');
        //str_replace('\\',"a",$username);
        //print($username);
        $monsters=array();
        for ($i=1; $i<7; $i++){
            $monsterID=intval($firebase->get('/Players/' . $id . '/Monsters/Monster' . $i . 'ID'));
            print($monsterID);
            $permanentStats=array(
                "HP"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterPermanentStatCollection/HP')),
                "Attack"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterPermanentStatCollection/Attack')),
                "Defense"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterPermanentStatCollection/Defense')),
                "Experience"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterPermanentStatCollection/Experience')),
                "Speed"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterPermanentStatCollection/Speed')),
            );

            //print("made stat array1");

            $currentStats=array(
                "HP"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterTemporaryStatCollection/HP')),
                "Attack"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterTemporaryStatCollection/Attack')),
                "Defense"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterTemporaryStatCollection/Defense')),
                "Experience"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterTemporaryStatCollection/Experience')),
                "Speed"=>intval($firebase->get('/StatCollections/MonsterStatCollection/' . $monsterID . '/MonsterTemporaryStatCollection/Speed')),
            );

            //print("made stat array2");

            $numOfbattleActions=intval($firebase->get('/Monsters/' . $monsterID . '/NumberOfBattleActions'));

            $battleActionIDs=json_decode($firebase->get('/Monsters/' . $monsterID . '/BattleActions'),true);
            //print($battleActionIDs);
            //print("testingggggggggggggg");

            //print(json_encode($battleActionIDs));

            $battleActions=array();

            /*
            for ($j=1;$j<$numOfbattleActions+1;$j++){
                $battleActionIDs[$j]=$firebase->get('/Monsters/' . $monsterID . '/BattleActions');
            }*/

            foreach ($battleActionIDs as &$battleActionID){
                if ($battleActionID!=null){
                    //print("battle action id   " . $battleActionID);
                    $collectionID=intval($firebase->get('/BattleActions/' . $battleActionID . '/BattleActionStatCollectionID'));

                    $hpChange=intval($firebase->get('/StatCollections/BattleActionStatCollection/' . $collectionID . '/HP'));

                    $name=$firebase->get('/BattleActions/' . $battleActionID . '/Name');

                    $battleActions[]=new BattleAction($hpChange,$name);
                }
            }

            //print(json_encode($battleActionIDs));

            $givenName=$firebase->get('/Monsters/' . $monsterID . '/GivenName');
            
            $level=$firebase->get('/Monsters/' . $monsterID . '/Level');

            $monsters[]=new Monster($permanentStats,$currentStats,$battleActions,$givenName,$level);
        }
        //THIS IS ALL FOR AVATAR
        $bodyImageID=intval($firebase->get('/Players/' . $id . '/Avatar/BodyImageID'));
        $bodyImage=$firebase->get('/Images/BodyImages/' . $bodyImageID);

        $chestID=intval($firebase->get('/Players/' . $id . '/Avatar/Clothes/chest/ApparelID'));
        $headID=intval($firebase->get('/Players/' . $id . '/Avatar/Clothes/head/ApparelID'));
        $shoesID=intval($firebase->get('/Players/' . $id . '/Avatar/Clothes/shoes/ApparelID'));

        $chestImageID=intval($firebase->get('/Apparel/' . $chestID . '/ApparelImageID'));
        //print("chest image id  " . $chestImageID);
        $chestName=$firebase->get('/Apparel/' . $chestID . '/Name');
        $chestSlot=intval($firebase->get('/Apparel/' . $chestID . '/Slot'));
        $chestValue=intval($firebase->get('/Apparel/' . $chestID . '/Value'));
        $chestImage=$firebase->get('/Images/ApparelImages/' . $chestImageID);

        $headImageID=intval($firebase->get('/Apparel/' . $headID . '/ApparelImageID'));
        $headName=$firebase->get('/Apparel/' . $headID . '/Name');
        $headSlot=intval($firebase->get('/Apparel/' . $headID . '/Slot'));
        $headValue=intval($firebase->get('/Apparel/' . $headID . '/Value'));
        $headImage=$firebase->get('/Images/ApparelImages/' . $headImageID);

        $shoesImageID=intval($firebase->get('/Apparel/' . $shoesID . '/ApparelImageID'));
        $shoesName=$firebase->get('/Apparel/' . $shoesID . '/Name');
        $shoesSlot=intval($firebase->get('/Apparel/' . $shoesID . '/Slot'));
        $shoesValue=intval($firebase->get('/Apparel/' . $shoesID . '/Value'));
        $shoesImage=$firebase->get('/Images/ApparelImages/' . $shoesImageID);

        $chest=new Apparel($chestImage,$chestName,$chestSlot,$chestValue);
        $head=new Apparel($headImage,$headName,$headSlot,$headValue);
        $shoes=new Apparel($shoesImage,$shoesName,$shoesSlot,$shoesValue);

        $avatar=new Avatar($bodyImage,$chest,$head,$shoes);

        //THIS IS ALL FOR INVENTORY
        $items=array();
        $numOfItems=$firebase->get('/Players/' . $id . '/Inventory/ApparelStored');
        $apparel=array();
        $numOfApparel=$firebase->get('/Players/' . $id . '/Inventory/Items');

        $itemCount=count($numOfItems);
        $apparelCount=count($numOfApparel);
        $k=0;
        print("got here 1");

        for ($i=0;$i<$itemCount;$i++) {
            $k++;

            //$description,$image,$healthChange,$name,$price
            $itemID=intval($firebase->get('/Players/' . $id . '/Inventory/Items/' . $k . '/ItemID'));

            $description=$firebase->get('/Items/' . $itemID . '/Description');
            $itemImageID=$firebase->get('/Items/' . $itemID . '/ItemImageID');
            $itemStatCollectionID=$firebase->get('/Items/' . $itemID . '/ItemStatCollectionID');
            $name=$firebase->get('/Items/' . $itemID . '/Name');
            $price=$firebase->get('/Items/' . $itemID . '/Price');
            $itemImage=$firebase->get('/Images/ItemImages/' . $itemImageID);
            $healthChange=$firebase->get('/StatCollections/ItemStatCollection/' . $itemStatCollectionID . '/HP');

            $items[]=new Item($description,$itemImage,$healthChange,$name,$price);

        }

        $k=0;

        for($i=0;$i<$apparelCount;$i++){
            $k++;

            //$description,$image,$healthChange,$name,$price
            $apparelID=intval($firebase->get('/Players/' . $id . '/Inventory/ApparelStored/' . $k . '/ApparelID'));

            $apparelImageID=$firebase->get('/Apparel/' . $itemID . '/ApparelImageID');
            $name=$firebase->get('/Apparel/' . $itemID . '/Name');
            $price=$firebase->get('/Apparel/' . $itemID . '/Value');
            $slot=$firebase->get('/Apparel/' . $itemID . '/Slot');
            $apparelImage=$firebase->get('/Images/ApparelImages/' . $apparelImageID);

            //$image,$name,$slot,$value
            $apparel[]=new Apparel($apparelImage,$name,$slot,$price);

        }

        $inventory=new Inventory($apparel,$items);

        return new Player($username, $monsters, $avatar, $inventory, $id);
    }
    //we only need the id because if the player is validated, then that's all we need
    //this will get all of the player's info from the database and set them to the above variables
    private function __construct($username, $monsters, $avatar, $inventory, $playerID){
        $this->username=$username;
        $this->monsters=$monsters;
        $this->avatar=$avatar;
        $this->inventory=$inventory;
        $this->playerID=$playerID;
    }

}