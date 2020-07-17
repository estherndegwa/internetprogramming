<?php
include_once 'DBConnector.php';
include_once 'user.php';

if(isset($_POST['submit'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $image = $_POST['fileToUpload'];

    $user = new User($first_name, $last_name, $city, $username, $password, $image);
    if(!$user->validateForm()){
        $user->createFormErrorSessions();
        header("Refresh:5");
        die();
    }
    $res = $user->save();
    //$file_upload_response = $uploader->uploadFile();
    if($res){
        echo "Save operation was successful";
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
            .user_details{
                width:360px;
                margin:50px auto;
                font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
                border-radius:10px;
                border:2px solid #ccc;
                padding:10px 40px 25px;
                margin-top:70px; 
                }
                input[type=text], input[type=password]{
                width:99%;
                padding:10px;
                margin-top:8px;
                border:1px solid #ccc;
                padding-left:5px;
                font-size:16px;
                font-family:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif; 
                }
                input[type=submit]{
                width:100%;
                background-color:#009;
                color:#fff;
                border:2px solid #06F;
                padding:10px;
                font-size:20px;
                cursor:pointer;
                border-radius:5px;
                margin-bottom:15px; 
                }
            table {
                border-collapse: collapse;
                width: 100%;
                color: #588c7e;
                font-family: georgia;
                font-size: 10px;
                align: center;
            }
            th 
            {
                background-color: #588c7e;
                color: white;
                text-align: left;
            }
            tr:nth-child(even) {background-color: #f2f2f2};
            
            
            </style>
    
    </head>
    <body>
        <form method = "post" name = "user_details" id ="user_details" onsubmit = "return validateForm()" action = "<?=$_SERVER['PHP_SELF']?>">
                    <input type="text" name="first_name" required placeholder = "First Name"><br/><br/>
                    <input type="text" name="last_name" placeholder = "Last Name" ><br/><br/>
                    <input type="text" name="city_name" placeholder = "City" ><br/><br/>
                    <input type="text" name="username" placeholder = "Username"><br/><br/>
                    <input type="password" name="password" placeholder = "Password"><br/><br/>
                    Profile image:<input type = "file" name = "fileToUpload" id ="fileToUpload"><br/><br/>
                    <input type = "submit" value="INSERT" name = "submit">
                    <a href="login.php">Login</a><br/><br/>
                
        </form>
            <table align = "center">
            <tr>
            <td>
                <div id = "form-errors">
                    <?php
                        session_start();
                        if(!empty($_SESSION['form_errors'])){
                            echo " " . $_SESSION['form_errors'];
                            unset($_SESSION['form_errors']);
                        }
                    ?>
                </div>
            </td>
            </tr>
            </table>
                
        <table>
            <tr>
            <th>ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>CITY</th>
            <th>USER NAME</th>
            <th>PASSWORD</th>
            <th>PROFILE PIC</th>
            </tr>
            <?php
                $conn = mysqli_connect("localhost", "root", "", "btc3205");
                // Check connection
                if ($conn->connect_error) 
                {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT id, first_name, last_name, user_city, username, password, photo_id FROM user";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["first_name"] . "</td><td>"
                    . $row["last_name"]. "</td><td>" . $row["user_city"] . "</td><td>"  . $row["username"] . "</td><td>" .$row["password"]. "</td><td>" .$row["photo_id"]. "</td></tr>";
                    }
                    echo "</table>";
                } 
                else { echo "0 results"; }
                $conn->close();
            ?>
</table>
    </body>
</html>