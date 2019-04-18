<?
header('Content-type:text/html;charset=utf-8');

$link = mysqli_connect('127.0.0.1','root', '', 'fedoreev');

$login = 'admin';
$password = '123456';

if($login == $_GET['login'] and $password == $_GET['password']){
    $query = $_GET['query'];
    $table = $_GET['table'];

    if($_GET['where']){
        $where = $_GET['where'];
    }
    if($_GET['limit']){
        $limit = $_GET['limit'];
    }
    if($_GET['fields']){
        $fields = $_GET['fields'];
    }
    else{
        $fields = "*";
    }
    if($_GET['values']){
        $values = $_GET['values'];
    }

    $data = [
        'table' => $table,
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
    $sql = "INSERT INTO ".$data['table'].'('.$data['fields'].') VALUES ('.$data['values'].')';
    echo $sql;
    $link->query($sql);
}

function select($data){
    global $link;

    $sql = 'SELECT '.$data['fields'].' FROM '.$data['table'];

    if($data['where']){
        $sql = $sql . ' WHERE '.$data['where'];
    }
    if($data['limit']){
        $sql = $sql . ' LIMIT '.$data['limit'];
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

    foreach($fields as $key => $value){
        $update_values = $update_values . $value.'='.$values[$key].',';
    }
    $update_values = substr($update_values, 0, -1);

    $sql = "UPDATE ".$data['table']." SET ".$update_values;

    if($data['where']){
        $sql = $sql . ' WHERE '.$data['where'];
    }

    $link->query($sql);
 
}
function delete($data){
    global $link;

    $sql = "DELETE FROM ".$data['table'];

    if($data['where']){
        $sql = $sql . ' WHERE '.$data['where'];
    }
    $link->query($sql);
}
?>