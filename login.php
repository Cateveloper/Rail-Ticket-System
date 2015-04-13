<?PHP

function Login()
{
    if(empty($_POST['username']))
    {
        //$this->HandleError("UserName is empty!");
        return false;
    }
     
    if(empty($_POST['password']))
    {
        //$this->HandleError("Password is empty!");
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
        return false;
    }
     
    $_SESSION[$this->GetLoginSessionVar()] = $username;
     
    return true;
}

function CheckPWD($user_name, $password)
{
    $table_name = 'table';

    $pwdmd5 = md5($password);
    $sql = "Select name, email from $table_name where username='$user_name' and password='$pwdmd5' and confirmcode='y'";
        
    $result = DB_Query($sql);
        
    if(!$result || mysql_num_rows($result) <= 0)
    {
        //$this->HandleError("Error logging in. The username or password does not match");
        return false;
    }
        
    $row = mysql_fetch_assoc($result);

    $_SESSION['name_of_user']  = $row['name'];
    $_SESSION['email_of_user'] = $row['email'];
        
    return true;
}

?>
