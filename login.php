<?PHP
require_once("./utility.php");

define("NOT_LOGIN", 0);
define("IS_ADMIN", 1);
define("IS_USER", 2);

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
    $sql = "SELECT user_id, user_name, admin FROM $table_name WHERE email='$user_name' AND password='$pwdmd5'";

    //echo $sql . '<br>';
        
    $result = DB_Query($sql);

    if (!$result || mysqli_num_rows($result) <= 0)
    {
        return false;
    }
        
    $row = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['admin'] = $row['admin'];

    //echo '' . $row['admin'];
        
    return true;
}

function CheckLogin ()
{
    if (!isset($_SESSION))
    {
        session_start();
    }

    $session_var = GetLoginSessionVar();

    if (empty($_SESSION[$session_var]))
    {
        return NOT_LOGIN;
    }

    if (1 == $_SESSION['admin'])
    {
        return IS_ADMIN;
    }

    return IS_USER;
}

?>
