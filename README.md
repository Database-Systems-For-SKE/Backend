# Backend
Using `php` and hand to wrote it. I don't use any external library in this project. 

# To folk
You need to fixed database connection `model/Model.php` first.

## Example 
1. Constants.ini
```ini
; IP address
ssh_host = ""
local_host = ""

; user
root_user = "root"
database_manager = ""

; pass
database_password = ""

; database
database_name = ""

; port
default_sql_port = 3306

```

# Explanation
1. [api](api) folder
    - method_api.php - contains *useful* method
    - json_parser.php - contains parse `query result` to `json`
    - query_api.php - contains provide query method
2. [model](model) folder - contains `database` connection
3. [helper](helper) folder - contains `condition` of each request method 
4. main php is name: [senter.php](index.php) **@deprecated** because security problem
5. local running by `php -S localhost:XXXX` when XXXX is running port 

# To connection

```diff
+ Implement auto insert `'` already!
- Warning: If the query require ' you must add in the request too.
```

The example will using `Ajax` in `jquery` to connect the server
The request link is `api.kamontat.me` and the example is below (the number in code meaning link below)

```javascript
var request = $.ajax({
    method: "GET|POST",
    url: "https://api.kamontat.me",
    // async: false, // make web freeze when loading data
    dataType: "json",
    data: {
        "action": "XXXXX", 
        "": ""
    } // learn more (2)
}); // learn more parameter (3)

// complete
// response: return from object, In this case will be JSON Object
// status: `success` string (I think)
// xhr: debug object, contains all information of this request
request.done(function (response, status, xhr) {
    // do something when request successfully
});

// failure
// xhr: debug object, contains all information of this request
//      EX: xhr.responseText = response in `done` method
//      EX: xhr.status: it's http status code (learn more (1))
// status: `error` string (I think)
// error: string why error and http status code (learn more (1))
request.fail(function (xhr, status, error) {
    // do something when resuest failture
});
```

1. [http status code](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes)
2. [JSON Format](#json-format)
3. [Ajax](http://api.jquery.com/jquery.ajax/)


------

# json format
- [X] Insert Customer **(POST Method)**
 ```json
 {
     "action":"insert_customer",
     "first_s": "first name",
     "last_s": "last name",
     "address_s": "address",
     "email_s": "email",
     "password": "md5 encryption"
 }
 ```
 
- [X] Update Customer **(POST Method)**
  ```json
  {
      "action":"update_customer",
      "fields_a": [
          "column1", "column2"
      ],
      "new_values_a": [
          "new_value1", "new_value1"
      ],
      "email_s": "email",
      "password": "md5 encryption"
  }
  ```
  
- [X] Search Customer by password **(POST Method)**
```json
  {
      "action":"search_customer",
      "email_s": "email",
      "password": "md5 encryption"
  }
```

- [X] get All Data from table **(GET Method)**
```json
  {
      "action":"select_all",
      "table_s": "Hotel|Room|RoomType|Facilities",
      "conditions_as": [
          "id=1001", "id=1002"
      ]
  }
```

- [X] get some column **(GET Method)**
```json
  {
      "action":"select",
      "table_s": "Hotel|Room|RoomType|Facilities",
      "columns_as": [
          "name", "description"
      ],
      "conditions_as": [
          "id=1001"
      ]
  }
```

- [ ] booking room **(POST Method)**
1. v1
```json
  {
      "action":"booking",
      "email_s":"email",
      "password":"md5 encryption",
      "room_id_i":1001,
      "night_i":1,
      "check_in_s":"date",
      "check_out_s":"date"
  }
```
2. v2
```json
  {
      "action":"booking",
      "customer_id_i": -1,
      "room_id_i":1001,
      "night_i":1,
      "check_in_s":"date",
      "check_out_s":"date"
  }
```

- [ ] delete customer **(POST Method)**

- [ ] filter rooms **(GET Method)**

- [ ] cancel room **(POST Method)**


### Output
1. success
```json
{
    "success": "true", 
    "key": "value"
}
```
**PS.**: `key/value` can be `0...N` and it's will appear iff SELECT / SHOW / DESCRIBE / EXPLAIN was executed (might more than 1).

2. failure
```json
{
    "success": "false", 
    "message":"condition"
}
```


# Example
On branch `tester`

# Credit
1. Kamontat Chantrachirathumrong
2. Render markdown to html in `index.html` by [`display-markdown`](https://github.com/sawmac/display-markdown)
