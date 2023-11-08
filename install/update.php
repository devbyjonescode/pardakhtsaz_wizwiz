<?php

require "../baseInfo.php";
$connection = new mysqli('localhost',$dbUserName,$dbPassword,$dbName);

$arrays = [
    "ALTER TABLE `pays` ADD `reference` VARCHAR(200) NULL AFTER `price`;",
    ];


function updateBot(){
    global $arrays, $connection;
    
    foreach($arrays as $query){
        try{
            $connection->query($query);
        }catch (exception $error){
            
        }
    }
    $stmt = $connection->prepare("SELECT * FROM `setting` WHERE `type` = 'BOT_STATES'");
    $stmt->execute();
    $isExists = $stmt->get_result();
    $stmt->close();
    if($isExists->num_rows>0){
        
        $botState = $isExists->fetch_assoc()['value'];
        if(!is_null($botState)) $botState = json_decode($botState,true);
        else $botState = array();

        if (!isset($botState['pardakhtSazState'])) {
            $botState['pardakhtSazState'] = 'off';
        }
        if (!isset($botState['individualExistence'])) {
            $botState['individualExistence'] = 'on';
        }
        if (!isset($botState['sharedExistence'])) {
            $botState['sharedExistence'] = 'on';
        }
        if (!isset($botState['testAccount'])) {
            $botState['testAccount'] = 'off';
        }
        if (!isset($botState['agencyState'])) {
            $botState['agencyState'] = 'off';
        }
        $query = "UPDATE `setting` SET `value` = ? WHERE `type` = 'BOT_STATES'";

        $newData = json_encode($botState);

        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $newData);
        $stmt->execute();
        $stmt->close();
    }

}
?>
