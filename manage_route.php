<?PHP
require_once("./login.php");

$login_status = CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Manage Routes</title>
      <link rel="STYLESHEET" type="text/css" href="datetimepicker-master/jquery.datetimepicker.css" />
      <link rel="STYLESHEET" type="text/css" href="css/form.css" />
      <script src="js/jquery-1.11.2.min.js"></script>
      <script src="js/jquery.redirect.js"></script>
      <script src="js/manage_route.js"></script>
      <script src="datetimepicker-master/jquery.datetimepicker.js"></script>
</head>
<body>
    <div id='content'>

<script type='text/javascript'>
var station_data = {};
</script>

<?PHP

function GetStationInfo ()
{
    $sql = "SELECT city_id, city_name FROM city WHERE is_delete=0";
    $result = DB_Query($sql);

    if ($result)
    {
?>
        <script type='text/javascript'>
<?PHP
        while($row = mysqli_fetch_array($result))
        {
?>
            station_data[<?PHP echo $row['city_id']?>] = '<?PHP echo $row['city_name']?>';
<?PHP
        }
?>
        </script>
<?PHP
    }
}

function GetRouteData ()
{
    $sql = "SELECT * FROM railroad_head WHERE is_delete=0";
    return DB_Query($sql);
}

const DB_UPDATE_SUCCEEDED = 1;
const DB_UPDATE_FAILED = 2;
const DB_DUPLICATE_ROUTE = 3;

function GetRouteID ($route_number)
{
    $sql = "SELECT railroad_head_id FROM railroad_head WHERE railroad_number='$route_number' AND is_delete=0";

    $result = DB_Query($sql);
    if (!$result)
    {
        return -1;
    }

    if (0 == mysqli_num_rows($result))
    {
        return -1;
    }

    if (1 != mysqli_num_rows($result))
    {
        return -1;
    }
   
    $route_id = 0;
    while ($row = mysqli_fetch_array($result))
    {
        $route_id = $row['railroad_head_id'];
    }

    return $route_id;
}

function AddRoute ()
{
    if (empty($_POST['route_number']))
    {
        echo 'no route number';
        return DB_UPDATE_FAILED;
    }

    if (empty($_POST['station_count']))
    {
        echo 'no station count';
        return DB_UPDATE_FAILED;
    }

    $route_number = $_POST['route_number'];
    $station_count = $_POST['station_count'];

    $route_id = GetRouteID($route_number);
    if ($route_id >= 0)
    {
        return DB_DUPLICATE_ROUTE;
    }

    $train_id = 1;
    $sql = "INSERT INTO railroad_head (railroad_number, train_id, weekday) VALUES ('$route_number', $train_id, 255)";

    $result = DB_Query($sql);
    if (!$result)
    {
        echo $sql;
        return DB_UPDATE_FAILED;
    }

    $route_id = GetRouteID($route_number);

    $connection_count = $station_count - 1;
    for ($station_idx = 0; $station_idx < $station_count; ++$station_idx)
    {
        $station_id = $_POST['station_idx_' . $station_idx];
        $departure_time = $_POST['train_time_' . $station_idx];
        $price = 0;

        if (!empty($_POST['price_' . $station_idx]))
        {
            $price = $_POST['price_' . $station_idx];
        }

        //echo $station_idx . '<br>';
        //echo $station_id . '<br>';
        //echo $train_time . '<br>';
        //echo $price . '<br>';
        //echo '<br>';

        $sql = "INSERT INTO railroad_detail (railroad_head_id, railroad_order, departure_city_id, departure_time, price, is_delete) VALUES ($route_id, $station_idx, $station_id, '$departure_time', $price, 0)";

        $result = DB_Query($sql);
        if (!$result)
        {
            echo $sql;
            return DB_UPDATE_FAILED;
        }

        $total_price = $price;
        for ($arrival_station_idx = $station_idx + 1; $arrival_station_idx < $station_count; ++$arrival_station_idx)
        {
            $arrival_station_id = $_POST['station_idx_' . $arrival_station_idx];
            $arrival_time = $_POST['train_time_' . $arrival_station_idx];

            $sql = "INSERT INTO schedule (railroad_id, railroad_number, train_id, departure_city_id, arrival_city_id, departure_time, arrival_time, price, is_delete) VALUES ($route_id, '$route_number', $train_id, $station_id, $arrival_station_id, '$departure_time', '$arrival_time', $price, 0)";
        
            $result = DB_Query($sql);
            if (!$result)
            {
                echo $sql;
                return DB_UPDATE_FAILED;
            }

            if (!empty($_POST['price_' . $arrival_station_idx]))
            {
                $price += $_POST['price_' . $arrival_station_idx];
            }
        }
    }

    return DB_UPDATE_SUCCEEDED;
}

function UpdateRoute ()
{
/*
    if (empty($_POST['route_number']))
    {
        echo 'no route number';
        return false;
    }

    if (empty($_POST['station_count']))
    {
        echo 'no station count';
        return false;
    }

    $route_number = $_POST['route_number'];
    $station_count = $_POST['station_count'];

    $sql = "SELECT * FROM railroad_head WHERE railroad_number=$route_number";

    $result = DB_Query($sql);
    if (!$result)
    {
        return DB_UPDATE_FAILED;
    }

    if (1 != mysqli_num_rows($result))
    {
        return DB_UPDATE_FAILED;
    }

    $sql = "UPDATE railroad_head SET railroad_number=$route_number, train_id=1, weekday=255";

    $result = DB_Query($sql);
    if (!$result)
    {
        return DB_UPDATE_FAILED;
    }

    return DB_UPDATE_SUCCEEDED;
*/
}

function DeleteRoute ()
{
    if (empty($_POST['route_id']))
    {
        echo 'no route id';
        return;
    }

    if (!isset($_SESSION))
    {
        session_start();
    }

    $route_id = $_POST['route_id'];

    $sql = "UPDATE railroad_head SET is_delete=1 WHERE railroad_head_id=$route_id";
    $result = DB_Query($sql);
    if (!$result)
    {
        return DB_QUERY_FAILED;
    }

    $sql = "UPDATE railroad_detail SET is_delete=1 WHERE railroad_head_id=$route_id";
    $result = DB_Query($sql);
    if (!$result)
    {
        return DB_QUERY_FAILED;
    }

    $sql = "UPDATE schedule SET is_delete=1 WHERE railroad_head_id=$route_id";
    $result = DB_Query($sql);
    if (!$result)
    {
        return DB_QUERY_FAILED;
    }

    return DB_UPDATE_SUCCEEDED;
}

$db_operation_result = 0;

if (IS_ADMIN != $login_status)
{
        Redirect("index.php");
}
else
{
        if (isset($_POST['manage_route_submitted']))
        {
            if (1 == $_POST['manage_route_submitted'])
            {
                $db_operation_result = AddRoute();
            }
            else
            {
                $db_operation_result = UpdateRoute();
            }
        }

        if (isset($_POST['manage_route_delete']))
        {
            $db_operation_result = DeleteRoute();
        }
?>

        <form id='route_form' action='manage_route.php' method='post' accept-charset='UTF-8'>
        <fieldset>
        <legend>Manage Routes</legend>

<?PHP
        if (DB_UPDATE_SUCCEEDED == $db_operation_result)
        {
            echo 'Update succeeded';
        }
        else if (DB_UPDATE_FAILED == $db_operation_result)
        {
            echo 'Update failed';
        }
        else if (DB_DUPLICATE_ROUTE == $db_operation_result)
        {
            echo 'Has duplicated route';
        }
?>
        
        <div class='container'>
            <table id='route_table' border="1">
                <tr>
                <th>Route ID</th>
                <th>Route Number</th>
                <th></th>
                <th></th>
                </tr>

<?PHP
                GetStationInfo();
                $result = GetRouteData();

                if ($result)
                {
                    while ($row = mysqli_fetch_array($result))
                    {
                        echo '<tr>';
                        echo '<td>' . $row['railroad_head_id'] . '</td>';
                        echo '<td>' . $row['railroad_number'] . '</td>';
                        echo '<td><button type="button" onclick="UpdateRoute(this)">Update</button></td>';
                        echo '<td><button type="button" onclick="DeleteRoute(this)">Delete</button></td>';
                        echo '</tr>';
                    }
                }
?>
            </table>
        </div>

        <input type='hidden' name='manage_route_submitted' id='manage_route_submitted' value='1'/>
        <input type='hidden' name='station_count' id='station_count' value='1'/>

        <div class='container'>
            <label for='route_number' >Route Number</label><br/>
            <input type='text' name='route_number' id='route_number' value='' maxlength="50" /><br/>
        </div>

        <div class='container'>
            <table id='route_info' border="1">
                <tr>
                <td></td>
                <td><button type="button" id="init_add_button">Add City</button></td>
                <td></td>
                </tr>
            </table>
        </div>

        <div class='container'>
            <input type='button' name='Submit' id='submit_button' value='Add Route' />
        </div>

        <div class='short_explanation'>
            <a href='index.php'>Go back</a>
        </div>

        </fieldset>
        </form>
<?PHP
}
?>
    </div>
</body>
