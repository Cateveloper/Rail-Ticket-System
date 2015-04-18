<?PHP
require_once("./utility.php");

SignOut();

function SignOut()
{
    if (!isset($_SESSION))
    {
        session_start();
    }

    $session_var = GetLoginSessionVar();

    if (!empty($_SESSION[$session_var]))
    {
        unset($_SESSION[$session_var]);
    }

    Redirect("index.php");
}

?>
