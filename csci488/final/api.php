<?php
require_once 'framework/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$now = time();
$ret = [];

$token = $_GET["token"];

if (!api_log::validate($token)){
    $ret["error"] = "Invalid token";
}
else{
    $call = get_call();//logs and gets type of call
    
    //call can be scenes, or lines. If it is null, then it is works
    //It is like an enum, but not really since enums are php 8.1 and we are on 7.4
    //bye bye hour of my life. Hardly knew ye.
    
    switch ($call) {
        case "scenes":
            $sql = "SELECT * FROM " . SHAKESPEARE_CHAPTERS_TABLE . " WHERE chap_work_id =  '". $_GET["work"] . "'";
            $result = lib::db_query($sql);
            while ($row = $result->fetch_assoc()) {
                $append = [];
    
                $append["scene_id"] = $row["chap_id"];
                $append["scene_work_id"] = $row["chap_work_id"];
                $append["scene_act"] = $row["chap_act"];
                $append["scene_scene"] = $row["chap_scene"];
                $append["scene_location"] = $row["chap_description"];
    
                $ret[] = $append;
            }
            break;
        case "lines":
            $sql = "SELECT sc.chap_description as loc, sp.par_number as num, sp.par_char_id as char_id, sp.par_text as words FROM " . SHAKESPEARE_CHAPTERS_TABLE . " sc, " . SHAKESPEARE_PARAGRAPHS_TABLE . " sp where sp.par_work_id = sc.chap_work_id and sc.chap_act = sp.par_act and sc.chap_scene = sp.par_scene and sp.par_act = " . $_GET["act"] . " and sp.par_scene = " . $_GET["scene"] . " and sc.chap_work_id = '" . $_GET["work"] . "'";
            $result = lib::db_query($sql);
            $ret["scene_location"] = $result->fetch_assoc()["loc"];
            //reset the pointer
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $append = [];
    
                $append[] = $row["num"];
                $append[] = $row["char_id"];
                $append[] = $row["words"];
    
                $ret["paragraphs"][] = $append;
            }
            break;
        default:
            $sql = "SELECT * FROM " . SHAKESPEARE_WORKS_TABLE;
            $result = lib::db_query($sql);
            while ($row = $result->fetch_assoc()) {
                $ret[] = $row;
            }
            break;
    }
}


echo json_encode($ret);

function get_call() {
    global $now;
    global $token;
    $log = new api_log();
    //token
    $acc = new account();
    $acc->load($token, "acc_api_key");
    $log->values["api_log_fk_acc_id"] = $acc->get_id_value();
    $log->values["api_log_access_time"] = $now;
    $log->values["api_log_ipv4"] = $_SERVER['REMOTE_ADDR'];
    $log->values["api_log_query"] = $_SERVER['QUERY_STRING']; //thanks stackoverflow
    $log->save();
    if (isset($_GET["work"])){
        if (isset($_GET["act"]) && isset($_GET["scene"])){
            return "lines";
        }
        //improper calls
        if (!isset($_GET["act"]) && isset($_GET["scene"])){
            return null;
        }
        if (isset($_GET["act"]) && !isset($_GET["scene"])){
            return null;
        }
        return "scenes";
    }
    return null;//default to listing works
}

?>