<?php
    include_once 'DBConnector.php';
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location:login.php");
    }
    
    function fetchUserApiKey()
    {
        $dbcon = new DBConnector();
        $user = $_SESSION['username'];
        $myquery = mysqli_query($dbcon->conn, "SELECT * FROM user WHERE username='$user'");
        $user_array = $myquery->fetch_assoc();
        $uid = $user_array['id'];
        $good = mysqli_query($dbcon->conn, "SELECT * FROM api_keys WHERE user_id = '$uid' ORDER BY `api_keys`.`id` DESC") or die(mysqli_error($dbcon->conn));
        $key = $good->fetch_assoc();
        return $key['api_key'];
    }
    
     ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>private page</title>
        <link rel="stylesheet" type="text/css" href="validate.css">
        <script src="jquery-3.5.1.js"></script>
        <script type="text/javascript" src="validate.js"></script>
        <script type="text/javascript" src="apikey.js"></script>
        <!--bootstrap js -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!--bootstrap css -->
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.min.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.min.css.map">
    </head>
    <body>
        <p align="right"><a href="logout.php">Logout</a></p>
        <hr>
        <h3>Here, we will create an API that will allow Users/Developer to order items from external sytems</h3>
        <hr>
        <h4>We now put this feature of allowing users to generate API key. Click the button to generate API key</h4>
        <button class="btn btn-primary" id="api-key-btn">Generate API Key</button> <br><br>
        <strong>Your API key:</strong>(Note that if your API key is already in use by already running application, generating a new key will stop the application from functioning)<br>
        <textarea cols="100" rows="2" id="api-key" readonly><?php echo fetchUserApiKey(); ?></textarea>
        <h3>Service description:</h3>
        We have a service/API that allows external applications to order food and also pull all order status by using order id. Let's do it
        <hr>
    </body>
    </html>