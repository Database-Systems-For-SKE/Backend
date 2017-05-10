<?php
/**
 * User: Kamontat Chantrachirathumrong
 * Date: 4/8/2017 AD
 * Time: 4:16 PM
 */
include "api/json_parser.php";
include "api/query_api.php";
include "api/method_api.php";
include "helper/Limitation.php";
include "helper/Information.php";

/* ------------------------------------------------------------------------------------ */
// Http Setting Section
/* ------------------------------------------------------------------------------------ */

// http response code: https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
header('Access-Control-Allow-Origin: *'); // bad security
header('Content-Type: application/json');

/* ------------------------------------------------------------------------------------ */
// Server Setting Section
/* ------------------------------------------------------------------------------------ */

// debug tool
// print_r($_SERVER);    // server information
// print_r($_REQUEST);   // request array (contains every thing that pass to server)
// print_r($_GET);       // parameter of get method
// print_r($_POST);      // body of post method

$method = $_SERVER['REQUEST_METHOD'];
$actual_array = [];
if ($method == 'GET') {
    $actual_array = $_GET;
} else if ($method == 'POST') {
    $actual_array = $_POST;
} else {
    http_response_code(405);
    die(failureToJSON($method . " not allow"));
}

if (count($actual_array) == 0) {
    die(failureToJSON("If you don't know how to use this api, go to https://api.kamontat.me/docs to learn it."));
}

/* ------------------------------------------------------------------------------------ */
// Action searching Section
/* ------------------------------------------------------------------------------------ */

// print_r($actual_array); // debug tool

if (!isset($actual_array['action'])) {
    http_response_code(400);
    die(failureToJSON("don't have (action) parse-in"));
}

$action = $actual_array['action'];
$expected_array = Information::get_required_key($action);

/* ------------------------------------------------------------------------------------ */
// Method allow Section
/* ------------------------------------------------------------------------------------ */

// first element of get_required_parameter() is expected method
if (array_shift($expected_array) != $method) {
    http_response_code(405);
    die($action . " not allow to sent by " . $method . " method.");
}

/* ------------------------------------------------------------------------------------ */
// Condition Configuration Section
/* ------------------------------------------------------------------------------------ */

// insert ' to condition, if condition exist
if (key_exists(Information::CONDITION, $actual_array))
    $actual_array[Information::CONDITION] = convert_condition($actual_array[Information::CONDITION]);

// encryption password
if (key_exists(Information::PASSWORD, $actual_array))
    $actual_array[Information::PASSWORD] = md5($actual_array[Information::PASSWORD]);

/* ------------------------------------------------------------------------------------ */
// Data Management Section
/* ------------------------------------------------------------------------------------ */

// debug tool
// print_r($expected_array);
// print_r($actual_array);

$str = Limitation::is_required($method, $expected_array, $actual_array);
if (is_string($str)) {
    http_response_code(400);
    die(failureToJSON($str));
}

// get result array (key and value)
$result_array = fetch_required_to_array($expected_array, $actual_array);

/* ------------------------------------------------------------------------------------ */
// query Section
/* ------------------------------------------------------------------------------------ */

// print_r($result_array);
switch ($action) {
    case "select":
        echo select($result_array[Information::TABLE], $result_array[Information::COLUMN], $result_array[Information::CONDITION]);
        break;
    case "select_all":
        echo selectAll($result_array[Information::TABLE], $result_array[Information::CONDITION]);
        break;
    case "insert_customer":
        $result = insert_customer($result_array);
        if (json_decode($result)->{"success"} === "true")
            http_response_code(201); // created
        echo $result;
        break;
    case "update_customer":
        echo update_customer($result_array[Information::EMAIL], $result_array[Information::PASSWORD], merge_array($result_array[Information::FIELD], $result_array[Information::NEW_VALUE]));
        break;
    case "search_customer":
        echo search_customer($result_array[Information::EMAIL], $result_array[Information::PASSWORD]);
        break;
    case "booking":
        echo failureToJSON("Not implement yet!");
        break;
    case "login":
        echo get_customer_id($result_array[Information::EMAIL], $result_array[Information::PASSWORD]);
        break;
}

?>
