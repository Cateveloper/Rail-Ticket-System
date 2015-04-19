<?PHP
require_once("./login.php");

$login_status = CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Manage Train Routes</title>
      <link rel="STYLESHEET" type="text/css" href="css/form.css" />
      <script src="js/jquery-1.11.2.min.js"></script>
</head>
<body>
    <div id='content'>

<?PHP
$db_table_name = 'city';

function AddStation ($station_name)
{
        global $db_table_name;
        $sql = "INSERT INTO $db_table_name (city_name) VALUES ('$station_name')";

        $result = DB_Query($sql);

        if (!$result)
        {
            return false;
        }

        return true;
}

function GetStationData ()
{
        global $db_table_name;
        $sql = "SELECT city_id, city_name FROM $db_table_name";
        return DB_Query($sql);
}

$db_operation_result = -1;

if (IS_ADMIN != $login_status)
{
        Redirect("index.php");
}
else
{
        if (isset($_POST['manage_station_submitted']))
        {
            if (empty($_POST['station_name']))
            {
                echo 'no station name';
                return;
            }

            $station_name = $_POST['station_name'];
            if (0 == strlen($station_name))
            {
                echo 'no station name';
                return;
            }

            if (!isset($_SESSION))
            {
                session_start();
            }

            $result = AddStation($station_name);

            if ($result)
            {
                $db_operation_result = 1;
            }
            else
            {
                $db_operation_result = 0;
            }
        }
?>
        <form id='add' action='manage_station.php' method='post' accept-charset='UTF-8'>
        <fieldset>
            <legend>Manage Stations</legend>

<?PHP
        if (1 == $db_operation_result)
        {
            echo 'Update succeeded';
        }
        else if (0 == $db_operation_result)
        {
            echo 'Update failed';
        }
?>

            <div class='container'>
                <table id='station_table' border="1">
                    <tr>
                    <th>Station ID</th>
                    <th>Station Name</th>
                    <th></th>
                    </tr>

<?PHP
        $result = GetStationData();

        if ($result)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                echo "<tr>";
                echo "<td>" . $row['city_id'] . "</td>";
                echo "<td>" . $row['city_name'] . "</td>";
                echo "</tr>";
            }
        }
?>

                </table>
            </div>

            <input type='hidden' name='manage_station_submitted' id='manage_station_submitted' value='1'/>
            <div class='container'>
                <label for='station_name' >New Station Name</label>
                <input type='text' name='station_name' id='station_name' maxlength="50" /><br/>
            </div>

            <div class='container'>
                <input type='submit' name='Submit' value='Add' />
            </div>
        </fieldset>
        </form>
<?PHP
}
?>
    </div>
</body>
