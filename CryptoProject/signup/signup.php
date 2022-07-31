<?php
session_start();
//FORM VALIDATION
$nameErr=$EmailErr=$passErr=$CpassErr=$nomatch=$Err1=$Err2="";
$username=$email=$password_1=$password_2="";
$conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
if(!$conn){
    echo "An Error Occured.\n";
    exit;
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST['username'])){
        $nameErr="Userame is required";
    }
    else{
        $username=pg_escape_string($conn,check($_POST['username']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$username)){
            $nameErr="Only Letters and White space allowed for Userame";
        }
    }
    if(empty($_POST['email'])){
        $EmailErr="Email is required";
    }
    else{
        $email=pg_escape_string($conn,check($_POST["email"]));
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $EmailErr="Enter valid Email ID";
        }
    }
    if(empty($_POST['password'])){
        $passErr="Password is required";
    }
    else{
        $password_1=pg_escape_string($conn,$_POST['password']);

    }
    if(empty($_POST['confirmpassword'])){
        $CpassErr="Password is required";
    }
    else{
        $password_2=pg_escape_string($conn,$_POST['confirmpassword']);

    }
    if($password_1!=$password_2){
        $nomatch="The two passwords do not match";
    }
    //Checking whether the username already exists or not
    $query="SELECT * FROM user_details WHERE username='$username' AND email='$email' LIMIT 1;";
    $result=pg_query($conn,$query);
    $ans=pg_fetch_assoc($result);
    if(!$result){
        echo "An Error Occured.\n";
        exit;
    }
    if($ans){
        if($ans['username']==$username){
            $Err1="Username already exists";
        }
        if($ans['email']==$email){
            $Err2="Email already exists";
        }
    }
    if(($nameErr=="")&&($EmailErr=="")&&($passErr=="")&&($CpassErr=="")&&($nomatch=="")&&($Err1=="")&&($Err2=="")){
        $encpass=md5($password_1);
        $query="INSERT INTO user_details (username,email,password) VALUES ('$username','$email','$encpass');";
        pg_query($conn,$query);
        $_SESSION['username']=$username;
        $_SESSION['success']="Hello,You have logged in successfully";
        header('location:../index.php');
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
        <title>Sign Up | CryptoWallet</title>
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
        <div class="signup">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 style="font-size: 35px;">SIGN UP</h1>
                <?php echo $Err1?><?php echo $Err2 ?><br>
                <label for="username" class="login_text">USERNAME:</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="login_box"><br>
                <?php echo $nameErr ?><br>
                <label for="email" class="login_text">EMAIL:</label>
                <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="login_box"><br>
                <?php echo $EmailErr ?><br>
                <label for="password" class="login_text">PASSWORD:</label>
                <input type="password" name="password" id="password" class="login_box"><br>
                <?php echo $passErr ?><br>
                <label for="confirmpassword" class="login_text">CONFIRM PASSWORD:</label>
                <input type="password" name="confirmpassword" id="confirmpassword" class="login_box"><br>
                <?php echo $CpassErr ?><br>
                <p>Already registered User?  <a href="../login/login.php" class="underline" style="text-decoration: none;color: #990011FF;">Login</a></p>
                <input type="submit" value="SIGNUP" name="login" class="login_submit"><br>
                <?php echo $nomatch ?><br>
            </form>
        </div>
        <br><br>
        <div class="footer">
            <p>CryptoWallet</p>
            <p>Copyright &copy 2022 Kishore Prashanth P 2020115043</p>
        </div>
    </body>
</html>
