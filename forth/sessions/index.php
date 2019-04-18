<?
header('Content-type:text/html;charset=utf-8');
session_start();
//session_destroy();
$login = "admin";
$password = "123456";

if($_POST['login']){
    if($_POST['login'] == $login and $_POST['password'] == $password){
        $_SESSION['is_auth'] = true;
    }
}

?>

<?if(!$_SESSION['is_auth']){?>
    <form method="post">
        <input type="text" name='login'>
        <input type="password" name = "password">
        <input type="submit">
    </form>
<?}
else{
    echo "Личный кабинет";
}?>