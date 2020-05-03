<?php
include_once 'DBConnector.php';
include_once 'user.php';

if (isset($_POST['btn_save'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User($first_name, $last_name, $city, $username, $password);
    if(!$user->validateForm()){
        $user->createFormErrorSessions();
        header("Refresh:5");
        die();
    }
    $res = $user->save();

    if($res){
        echo "Inserted!";
    }
    else{
        echo "Operation not successful";
    }
    header ("refresh:3; url=lab1.php");
    
}
?>

<html>
    <head>
        <title>USER FORM</title>
        <script type = "text/javascript" src = "validate.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "validate.css">
            <style>
            table {
                border-collapse: collapse;
                width: 100%;
                color: #588c7e;
                font-family: georgia;
                font-size: 20px;
                align: center;
            }
            th 
            {
                background-color: #588c7e;
                color: white;
                text-align: left;
            }
            tr:nth-child(even) {background-color: #f2f2f2}
            </style>
    
    </head>
    <body>
        <form method = "post" name = "user_details" id ="user_details" onsubmit = "return validateForm()" action = "<?=$_SERVER['PHP_SELF']?>">
            <table align = "center">
            <tr>
            <td>
                <div id = "form-errors">
                    <?php
                        session_start();
                        if(!empty($_SESSION['form_errors'])){
                            echo " " . $_SESSION['form_errors'];
                            unset($_SESSION['form_erros']);
                        }
                    ?>
                </div>
            </td>
            </tr>
                <tr>
                    <td><input type="text" name="first_name" required placeholder = "First Name" /> </td>
                </tr>
                <tr>
                    <td><input type="text" name="last_name" placeholder = "Last Name" /> </td>
                </tr>
                <tr>
                    <td><input type="text" name="city_name" placeholder = "City" /> </td>
                </tr>
                <tr>
                    <td><input type="text" name="username" placeholder = "Username" /> </td>
                </tr>
                <tr>
                    <td><input type="password" name="password" placeholder = "Password" /> </td>
                </tr>
                <tr>
                    <td><button type="submit" name="btn_save"><strong>SAVE</strong></button></td>
                </tr>
                <tr>
                    <td><a href="login.php">Login</a></td>
                </tr>
            </table>
        </form>
        <table>
            <tr>
            <th>ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>CITY</th>
            </tr>
            <?php
                $conn = mysqli_connect("localhost", "root", "", "btc3205");
                // Check connection
                if ($conn->connect_error) 
                {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT id, first_name, last_name, user_city, username FROM user";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["first_name"] . "</td><td>"
                    . $row["last_name"]. "</td><td>" . $row["user_city"] . "</td></tr>" . "</td><td>" . $row["username"] . "</td></tr>";
                    }
                    echo "</table>";
                } 
                else { echo "0 results"; }
                $conn->close();
            ?>
</table>
    </body>
</html>