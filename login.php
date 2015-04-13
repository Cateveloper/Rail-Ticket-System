<?PHP
require_once("./utility.php");

if (isset($_POST['submitted']))
{
    Login();
    Redirect("index.php");
}


function Login()
{
    if (empty($_POST['username']))
    {
        echo 'no user name';
        return false;
    }
     
    if (empty($_POST['password']))
    {
        echo 'no password';
        return false;
    }
     
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(!isset($_SESSION))
    {
        session_start(); 
    }

    if(!CheckPWD($username, $password))
    {
        echo 'user name and password not matched';
        return false;
    }
     
    $_SESSION[GetLoginSessionVar()] = $username;
     
    return true;
}

function CheckPWD ($user_name, $password)
{
    $table_name = 'users';

    $pwdmd5 = md5($password);
    $sql = "SELECT user_name, admin FROM $table_name WHERE email='$user_name' AND password='$pwdmd5'";

    //echo $sql . '<br>';
        
    $result = DB_Query($sql);

    if (!$result || mysqli_num_rows($result) <= 0)
    {
        return false;
    }
        
    $row = mysql_fetch_assoc($result);

    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['admin'] = $row['admin'];
        
    return true;
}

function CheckLogin ()
{
    if(!isset($_SESSION))
    {
        session_start();
    }

    $session_var = GetLoginSessionVar();

    if(empty($_SESSION[$session_var]))
    {
        return false;
    }

    return true;
}

?>
