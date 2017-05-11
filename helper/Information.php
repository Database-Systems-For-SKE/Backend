<?php

/**
 * Created by PhpStorm.
 * User: kamontat
 * Date: 4/14/2017 AD
 * Time: 1:35 PM
 */
class Information
{
    const VERSION_NAME = "v3.1.1";
    const VERSION = "version";

    const array = "array";
    const string = "string";
    const int = "integer";
    const encrypt = "encrypt";
    const unknown = "unknown";

    const GET = "GET";
    const POST = "POST";

    const TABLE = "table_s";
    const COLUMN = "columns_as";
    const CONDITION = "conditions_as";
    const FIRST_NAME = "first_s";
    const LAST_NAME = "last_s";
    const FIELD = "fields_a";
    const NEW_VALUE = "new_values_a";
    const ADDRESS = "address_s";
    const EMAIL = "email_s";
    const NIGHT = "night_i";
    const CHECK_IN = "check_in_s";
    const CHECK_OUT = "check_out_s";

    const CARD_NAME = "card_name_s";
    const CARD_NO = "card_number_s";
    const EXPIRE_DATE = "expire_data_s";

    const ROOM_ID = "room_id_i";

    const PASSWORD = "password";

    /**
     * First element is expected/required method, and other is all key that should pass with action.
     * @param $action
     * @return array
     */
    public static function get_required_key($action)
    {
        switch ($action) {
            case "select":
                return array(Information::GET, Information::TABLE, Information::COLUMN, Information::CONDITION);
                break;
            case "select_all":
                return array(Information::GET, Information::TABLE, Information::CONDITION);
                break;
            case "insert_customer":
                return array(Information::POST, Information::FIRST_NAME, Information::LAST_NAME, Information::ADDRESS, Information::EMAIL, Information::PASSWORD);
                break;
            case "insert_payment":
                return array(Information::POST, Information::CARD_NAME, Information::CARD_NO, Information::EXPIRE_DATE);
                break;
            case "update_customer":
                return array(Information::POST, Information::FIELD, Information::NEW_VALUE, Information::EMAIL, Information::PASSWORD);
                break;
            case "search_customer":
                return array(Information::POST, Information::EMAIL, Information::PASSWORD);
                break;
            case "booking":
                return array(Information::POST, Information::EMAIL, Information::PASSWORD, Information::ROOM_ID, Information::NIGHT, Information::CHECK_IN, Information::CHECK_OUT);
            case "login":
                return array(Information::POST, Information::EMAIL, Information::PASSWORD);
            default:
                http_response_code(501);
                die(failureToJSON($action . " isn't implementation yet!"));
        }
    }

    /**
     * @param string $parameter
     * @return array
     */
    public static function get_class_of($parameter)
    {
        // is password
        if ($parameter == 'password') return array(Information::encrypt);
        $arr = explode("_", $parameter);
        $end_arr = strval(end($arr));
        // not match anything
        if ($end_arr === false) return array(Information::unknown);
        $return_arr = [];
        if (strpos($end_arr, 'a') !== false) $return_arr[] = Information::array;
        if (strpos($end_arr, 'i') !== false) $return_arr[] = Information::int;
        if (strpos($end_arr, 's') !== false) $return_arr[] = Information::string;
        return $return_arr;
    }
}
