<?PHP
require_once("./login.php");

$login_status = CheckLogin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Manage Train Routes</title>
      <link rel="STYLESHEET" type="text/css" href="datetimepicker-master/jquery.datetimepicker.css" />
      <link rel="STYLESHEET" type="text/css" href="css/form.css" />
      <script src="js/jquery-1.11.2.min.js"></script>
      <script src="js/manage_route.js"></script>
      <script src="datetimepicker-master/jquery.datetimepicker.js"></script>
</head>
<body>
    <div id='content'>

<?PHP
if (IS_ADMIN != $login_status)
{
        Redirect("index.php");
}
else
{
?>
        <form id='route' action='update_route.php' method='post' accept-charset='UTF-8'>
        <fieldset>
        <legend>Manage Routes</legend>
        <input type='hidden' name='submitted' id='submitted' value='1'/>

        <div class='container'>
            <table id='route_table' border="1">
                <tr>
                <td></td>
                <td><button type="button" id="init_add_button">Add City</button></td>
                <td></td>
                </tr>
            </table>
        </div>

        <div class='container'>
            <input type='submit' name='Submit' value='Submit' />
        </div>

        </fieldset>
        </form>
<?PHP
}
?>
    </div>
</body>
