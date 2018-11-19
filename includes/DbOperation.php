<?php
 
class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 		
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    function getPermission(){
        $stmt = $this->con->prepare("SELECT * FROM permissions");
        $stmt->execute();
        $stmt->bind_result($permId,$name, $levelId);

        $details = array();

        while($stmt->fetch()){

            $detail = array();
            $detail['perm_id'] = $permId;
            $detail['name'] = $name;
            $detail['protect_id'] = $levelId;

            array_push($details, $detail);
        }
        return $details;
    }

    function getMethod($id){
        $stmt = $this->con->prepare("SELECT name FROM method WHERE perm_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($name);

        $details = array();

        while($stmt->fetch()){
            $detail = array();
            $detail['name'] = $name;

            array_push($details, $detail);

        }

        return $details;
    }

    function getApp($id){
        $stmt = $this->con->prepare("SELECT `app_id`, `title`, `url`, `developerID`, `date_scraped` FROM app WHERE `app_id` = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($app_id, $title, $url, $developerID, $date_scraped);

        $details = array();

        while($stmt->fetch()){
            $detail = array();
            $detail['app_id'] = $app_id; 
            $detail['title'] = $title; 
            $detail['url'] = $url;
            $detail['developerID'] = $developerID;
            $detail['date_scraped'] = $date_scraped;

            array_push($details, $detail);


        }
        return $details;
    }

    function getAppPermission($id){
        $stmt = $this->con->prepare("SELECT `perm_exist`.`app_id`, `permissions`.`name`, `protection`.`level` FROM perm_exist INNER JOIN permissions ON `perm_exist`.`perm_id`= `permissions`.`perm_id`INNER JOIN protection ON `protection`.`protect_id` = `permissions`.`protect_id` WHERE `perm_exist`.`app_id` = ?");

        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->bind_result($app_id, $permName, $protectLevel);

        $details = array();

        while($stmt->fetch()){

            $detail = array();
            $detail['app_id'] = $app_id;
            $detail['permName'] = $permName;
            $detail['protectLevel'] = $protectLevel;

            array_push($details, $detail);
        }
        return $details;
    }

}