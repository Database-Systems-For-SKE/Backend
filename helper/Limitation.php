<?php

/**
 * check limitation of query, all method in here will return 2 way allow/OK or Not OK/error occurred, so this will make program known allowed passing/ok or not.
 *
 * Created by PhpStorm.
 *
 * User: kamontat
 *
 * Date: 4/14/2017 AD
 *
 * Time: 12:42 PM
 */
class Limitation
{
    /**
     * @param string $table
     * @return true, if table is allow; otherwise, return false
     */
    public static function select_all($table)
    {
        return $table === "Hotel" or $table === "Room" or $table === "RoomType" or $table === "Facilities";
    }

    /**
     * @param string $table
     * @return bool true if table allow to deleted
     */
    public static function delete($table)
    {
        return $table === "CustomerDetail";
    }

    public static function delete_all($table)
    {
        return false; // disable delete all feature
    }

    /**
     * @param string $method 'GET', 'POST', etc
     * @param array $expected get from Information::get_required_parameter() method
     * @param array $actual get from $_GET, $_POST etc.
     * @return false|string string when have error occurred.
     */
    public static function is_required(array $expected, array $actual)
    {
        $str = "";
        $error = false;
        foreach ($expected as $req) {
            if (!isset($actual[$req]) or $actual[$req] == "") {
                $error = true;
                $str .= "`" . $req . "`" . " ";
            }
        }
        return $error ? $str . " is required for '" . $actual['action'] . "' action" : false;
    }

    /**
     * check is value of key in json is acceptable or not
     * @param $key
     * @param $value
     * @return bool true is acceptable; otherwise return false
     */
    public static function is_allow_type($key, $value)
    {
        $classes = Information::get_class_of($key);
        $check = false;

        if (in_array(Information::array, $classes)) $check = ($check or is_array($value));
        if (in_array(Information::string, $classes)) $check = ($check or is_string($value));
        if (in_array(Information::int, $classes)) $check = ($check or is_numeric($value));
        if (in_array(Information::encrypt, $classes)) $check = ($check or is_string($value)); // maybe something else
        if (in_array(Information::unknown, $classes)) $check = false;
        return $check;
    }
}