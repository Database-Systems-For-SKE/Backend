<?php
/**
 * Created by PhpStorm.
 * User: kamontat
 * Date: 4/6/2017 AD
 * Time: 10:08 PM
 */

/**
 * @param bool $success
 * @param array|null $array
 * @return string json object (UTF-8 code ONLY)
 */
function toJSON(bool $success, array $array = null /* mapping array */)
{
    $array_success = array('success' => $success ? "true" : "false");
    if (isset($array)) {
        $result = array_merge($array_success, $array);

        return str_replace("\\", "", json_encode($result, JSON_PRETTY_PRINT)); // remove \
    } else {
        return json_encode($array_success, JSON_PRETTY_PRINT);
    }
}

/**
 * change failure to json
 * @param $description string why fail
 * @return string failure json
 */
function failureToJSON($description = "Some error occurred.")
{
    return toJSON(false, array("message" => $description));
}

/**
 * if pass string meaning fail.
 * @param mysqli_result|bool|string $result
 * @return string json of data
 */
function sqlToJSON($result)
{
    if (is_string($result)) {
        return failureToJSON($result);
    } else if (is_object($result)) {
        $array = to_array($result);
        $result->free();
        if (!isset($array) or count($array) <= 0) // when array empty or null
            return failureToJSON("Result not found.");
        else
            return toJSON(true, $array);
    } else {
        return toJSON($result);
    }
}

/**
 * @param $json string json string
 * @return bool
 */
function JSON_isTrue($json)
{
    $json_de = json_decode($json, true);

    if (!key_exists("success", $json_de)) return false;
    return $json_de['success'] === "true";
}

?>