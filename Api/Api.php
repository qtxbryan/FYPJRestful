<?php
    require_once '../includes/DbOperation.php';

    function isTheseParametersAvailable($params){

        $available = true;
        $missingparams = "";

        foreach($params as $param){

            if(!isset($_POST[$param]) || strlen($_POST[$param]) <=0){

                $available = false;
                $missingparams = $missingparams . ", " .$param;
            }
        }

        if(!$available){

            $response = array();
            $response['error'] = true;
            $response['message'] = 'Parameters ' . substr($missingparams, 1,
                    strlen($missingparams)) . ' missing';

            //displaying error
            echo json_encode($response);

            //stopping further execution
            die();
        }
    }

    //an array to display response
    $response = array();

    if(isset($_GET['apicall'])){

        switch ($_GET['apicall']){

            case 'getpermission':
                $db = new DbOperation();
                $response['error'] = false;
                $response['message'] = 'Request successfully completed';
                $response['details']= $db->getPermission();
                break;

            case 'getmethod':
                if(isset($_GET['id'])){
                    $db = new DbOperation();
                    if($db->getMethod($_GET['id'])){

                        $response['error'] = false;
                        $response['message'] = 'Request successfully completed';
                        $response['details'] = $db->getMethod($_GET['id']);
                    }else{

                        $response['error'] = true;
                        $response['message'] = 'Some error occured please try again';
                    }
                }else{

                    $response['error'] = true;
                    $response['message'] = 'Nothing to delete, provide an id please';
                }
                break;

            case 'getapp':
                if(isset($_GET['id'])){
                    $db = new DbOperation();
                    if($db->getApp($_GET['id'])){
                        $response['details']= $db->getApp($_GET['id']);
                    }else{

                        $response['error'] = true;
                        $response['message'] = 'Some error occured please try again';
            		}
                }else{
                    $response['error'] = true;
                    $response['message'] = 'Nothing to delete, provide an id please';
                }
                break;

            case 'getapppermission':
                if(isset($_GET['id'])){
                    $db = new DbOperation();
                    if($db->getAppPermission($_GET['id'])){
                        $response['details'] = $db->getAppPermission($_GET['id']);
                    }else{
                        $response['error'] = true;
                        $response['message'] = 'Some error occurred please try again';
                    }
                }else{
                    $response['error'] = true;
                    $response['message'] = 'Nothing to delete, provide an id please';
                }
                break;
        }
    }else{

        $response['error'] = true;
        $response['message'] = 'Invalid API Call';
    }

//displaying the response in json structure
echo json_encode($response);

    ?>


