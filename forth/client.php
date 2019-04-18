<?
header('Content-type:application/json;charset=utf-8');
function ApiQuery($data){
    if($data){
        $login = 'admin'; // ID пользователя 
        $password = '123456'; // Ключ 
        $url = 'http://gubin/forth/api/server.php'; 
        foreach($data as $k=>$item){
            $gets[$k] = $item;
        }
        
        $get = $url . '?' . urldecode(http_build_query($gets)) . '&login=' . $login . '&password=' . $password; // URL для парсера
        $r = json_decode(@file_get_contents($get));

        return $r;
    }
    else{
        exit("Неправильный запрос"); 
    }
    
 }

 $data = [
    'query' => 'select',
    'table' => 'User'
 ];

 print_r(ApiQuery($data));
  
?>