<?
header('Content-type:text/html;charset=utf-8');
$link = mysqli_connect('127.0.0.1','root','','fedoreev');

$login = "admin";
$password = "123456";

if($_GET['login'] == $login && $_GET['password'] == $password){
    
    $table = $_GET['table'];
    $query = $_GET['query'];

    if($_GET['fields']){
        $fields = $_GET['fields'];
    }
    else{
        $fields = '*';
    }

    if($_GET['values']){
        $values = $_GET['values'];
    }

    if($_GET['where']){
        $where = $_GET['where'];
    }

    if($_GET['limit']){
        $limit = $_GET['limit'];
    }

    $data = [
        'table' => $table,
        'query' => $query,
        'fields' => $fields,
        'values' => $values,
        'where' => $where,
        'limit' => $limit,
    ];
    switch($query){
        case 'insert': insert($data); break;
        case 'select': select($data); break;
        case 'update': update($data); break;
        case 'delete': delete($data); break;
    }


}

function insert($data){
    global $link;

    $sql = "INSERT INTO " . $data['table'] . "(" . $data['fields'] . ") VALUES (" . $data['values'] . ")";
    $link->query($sql);

}

function select($data){
    global $link;
    $sql = "SELECT " . $data['fields'] . " FROM " . $data['table'];
    if($data['where']){
        $sql = $sql . " WHERE ". $data['where'];
    }
    if($data['limit']){
        $sql = $sql . " LIMIT ". $data['limit'];
    }
    $res = $link->query($sql);
    while($row = $res->fetch_assoc()){
        $result[] = $row;
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

function update($data){
    global $link;
    $fields = explode(',', $data['fields']);
    $values = explode(',', $data['values']);
    foreach($fields as $key=>$value){
        $result_fields = $result_fields . $value . "=" . $values[$key] . ",";
    }
    $result_fields = substr($result_fields, 0, -1);
    $sql = "UPDATE " . $data['table'] . " SET " . $result_fields;
    if($data['where']){
        $sql = $sql . " WHERE " . $data['where'];
    }
    $link->query($sql);
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