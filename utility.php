<?PHP

$rand_key = '15qtUcnKB4r0Chf';
$host_name = 'us-cdbr-azure-southcentral-e.cloudapp.net';
$db_name = 'rail_tickets_db';
$user_id = 'b76923aa07bae4';
$user_pwd = 'f80b6765';

function DB_Query ($sql)
{
    global $host_name, $db_name, $user_id, $user_pwd;

    $con = mysqli_connect($host_name, $user_id, $user_pwd, $db_name);
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,$db_name);
    $result = mysqli_query($con, $sql);

    mysqli_close($con);
    return $result;
}

function Redirect ($url)
{
    header("Location: $url");
    exit;
}

function GetLoginSessionVar()
{
	global $rand_key;
    $ret_var = md5($rand_key);
    $ret_var = 'usr_'.substr($ret_var, 0, 10);
    return $ret_var;
}

?>
