<?
header('Content-type:text/html;charset=utf-8');

$link = mysqli_connect('127.0.0.1','root','','fedoreev');

$login = "admin";
$password = "123456";

if($_GET['login'] == $login and $_GET['password'] == $password){
    $table = $_GET['table'];
    $query = $_GET['query'];

    if($_GET['where']){
        $where = $_GET['where'];
    }
    if($_GET['fields']){
        $fields = $_GET['fields'];
    }
    else{
        $fields = '*';
    }

    if($_GET['values']){
        $values = $_GET['values'];
    }

    if($_GET['limit']){
        $limit = $_GET['limit'];
    }

    $data = [
        'table' => $table,
        'where' => $where,
        'fields' => $fields,
        'values' => $values,
        'limit' => $limit,
    ];

    switch($query){
        case 'select': select($data); break;
        case 'insert': insert($data); break;
        case 'delete': delete($data); break;
        case 'update': update($data); break;
        
    }

}

function insert($data){
    global $link;

    $sql = "INSERT INTO ".$data['table']."(".$data['fields'].") VALUES (".$data['values'].")";
    $link->query($sql);

}

function update($data){
    global $link;

    $fields = explode(',',$data['fields']);
    $values = explode(',',$data['values']);

    foreach($fields as $key => $field){
        $fields_values = $fields_values . $field . "=" . $values[$key] . ',';
    }
    $fields_values = substr($fields_values, 0,-1);

    $sql = "UPDATE ".$data['table'] . " SET " . $fields_values;

    if($data['where']){
        $sql = $sql . " WHERE " . $data['where'];
    }
    
    $link->query($sql);
}

function select($data){
    global $link;

    $sql = "SELECT ".$data['fields'].' FROM '.$data['table'];
    if($data['where']){
        $sql = $sql . " WHERE " . $data['where'];
    }
    if($data['limit']){
        $sql = $sql . " LIMIT " . $data['limit'];
    }

    $res = $link->query($sql);

    while($row = $res->fetch_assoc()){
        $result[] = $row;
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);

}

function delete($data){
    global $link;

    $sql = "DELETE FROM ".$data['table'];

    if($data['where']){
        $sql = $sql . " WHERE " . $data['where'];
    }

    $link->query($sql);

}

?>