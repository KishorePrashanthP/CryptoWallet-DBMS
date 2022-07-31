<?php
session_start();
//FORM VALIDATION
$username=$password="";
$nameErr=$passErr="";
$Err="";
$conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
if(!$conn){
    echo "An Error Occured.\n";
    exit;
}
if(isset($_POST['login'])){
    if(empty($_POST['username'])){
        $nameErr="Username is required";
    }
    else{
        $username=pg_escape_string($conn,check($_POST['username']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$username)){
            $nameErr="Only Letters and White space allowed for Userame";
        }
    }
    if(empty($_POST['password'])){
        $passErr="Password is required";
    }
    else{
        $password=pg_escape_string($conn,$_POST['password']);

    }
    if(($nameErr=="")&&($passErr=="")){
        $encpass=md5($password);
        $query="SELECT * FROM user_details WHERE username='$username' AND password='$encpass';";
        $result=pg_query($conn,$query);
        if(!$result){
            echo "An Error Occured.\n";
            exit;
        }
        if(pg_num_rows($result)==1){
            $_SESSION['username']=$username;
            $_SESSION['success']="Hello,You have logged in successfully";
            header('location:../index.php');
        }
        else{
            $Err="Wrong Username and Password";
        }
    }
}
function check($x){
    $x=trim($x);
    $x=stripslashes($x);
    $x=htmlspecialchars($x);
    return $x;
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>Login | CryptoWallet</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="author" content="Kishore Prashanth P (2020115043)">
        <link rel="stylesheet" href="../CSS/styles.css">
        <link rel="icon" type="image/png" href="../images/dogecoin.png">
    </head>
    <body>
        <div class="header">
            <p>CryptoWallet</p>
        </div>
        <ul class="topnav">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../exchangeslist/exchangeslist.php">Exchanges</a></li>
            <li><a href="../usercoins/usercoins.php">Wallet</a></li>
            <li><a href="../transaction/transaction.php">Transaction</a></li>
            <li><a href="../temp_blockchain/MinersPool.php">Mining</a></li>
            <li class="right"><a href="../login/login.php" class="active">Log in</a></li>
        </ul>
        <div class="login">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 style="font-size: 35px;">LOGIN</h1>
                <?php echo $Err ?><br>
                <label for="username" class="login_text">USERNAME:</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="login_box"><br>
                <?php echo $nameErr ?><br>
                <label for="password" class="login_text">PASSWORD:</label>
                <input type="password" name="password" id="password" class="login_box"><br>
                <?php echo $passErr ?><br>
                <p>New user?  <a href="../signup/signup.php" class="underline" style="text-decoration: none;color: #990011FF;">Sign Up</a></p>
                <input type="submit" value="LOGIN" name="login" class="login_submit">
            </form>
        </div>
        <br><br>
        <div class="footer">
            <p>CryptoWallet</p>
            <p>Copyright &copy 2022 Kishore Prashanth P 2020115043</p>
        </div>
    </body>
</html>