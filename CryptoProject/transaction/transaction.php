<?php
session_start();
if(empty($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('Login / Signup first!');";
    echo "window.location.replace('http://localhost/CryptoProject/login/login.php')</script>";
}
$receiver_Err1=$receiver_Err2=$noErr="";
if(isset($_POST['send'])){
    if(empty($_POST['to'])){
        $receiver_Err1="Enter Receiver's Username";
    }
    $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
    if(!$conn){
        echo "An Error occured.\n";
        exit;
    }
    $sender=$_SESSION['username'];
    $receivername=$_POST['to'];
    $query1="SELECT * FROM user_details WHERE username='$receivername';";
    $result1=pg_query($conn,$query1);
    if(pg_num_rows($result1)!=1){
        $receiver_Err2="Enter valid Receiver's Username";
    }
    $coin=$_POST['coin'];
    if(empty($_POST['no'])){
        $noErr="Enter number of coins";
    }
    else{
        $no=$_POST['no'];
    }
    if($receiver_Err1=="" && $receiver_Err2=="" && $noErr==""){
        $query2="SELECT * FROM user_assets WHERE username='$sender' AND coin_name='$coin';";
        $result2=pg_query($conn,$query2);
        if(pg_num_rows($result2)==1){
            $rows2=pg_fetch_assoc($result2);
            if($rows2['no_of_coins']>=$no){
                $query3="INSERT INTO temp_blockchain (sender,receiver,no_of_coins,coin_name) VALUES ('$sender','$receivername','$no','$coin');";
                pg_query($conn,$query3);
                $updated_coins=$rows2['no_of_coins']-$no;
                if($updated_coins==0){
                    $query4="DELETE FROM user_assets WHERE username='$sender' AND coin_name='$coin';";
                    pg_query($conn,$query4);
                }
                else{
                    $query5="UPDATE user_assets SET no_of_coins=$updated_coins WHERE username='$sender' AND coin_name='$coin';";
                    pg_query($conn,$query5);
                }
                $_SESSION['transfer_success']="Success Message";
                header('location:../index.php');
            }
            else{
                $_SESSION['transfer_failure']="Failure Message";
                header('location:../index.php');
            }
        }
        else{
            $_SESSION['transfer_failure']="Failure Message";
            header('location:../index.php');

        }
    }
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>Transaction Page | CryptoWallet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <meta name="author" content="Kishore Prashanth P(2020115043)">
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
            <li><a href="../transaction/transaction.php" class="active">Transaction</a></li>
            <li><a href="../temp_blockchain/MinersPool.php">Mining</a></li>
            <li class="right"><a href="../login/login.php">Log in</a></li>
        </ul>
        <div style="padding-right: 10px;"><?php 
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout'>".$_SESSION['username']."</p>";
        }
        ?>
        </div><br>
        <div class="login">
            <form method="POST">
                <label for="from" class="login_text">Sender:</label>
                <input type="text" name="from" class="login_box" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><br><br>
                <label for="to" class="login_text">Receiver:</label>
                <input type="text" name="to" class="login_box"><br>
                <?php echo $receiver_Err1 ?><?php echo $receiver_Err2 ?><br>
                <label for="coin" class="login_text">Coins:</label>
                <select name="coin" class="login_box">
                <option value="BTC">BTC</option>
                <option value="ETH">ETH</option>
                <option value="BNB">BNB</option>
                <option value="USDT">USDT</option>
                <option value="SOL">SOL</option>
                <option value="ADA">ADA</option>
                <option value="XRP">XRP</option>
                <option value="DOT">DOT</option>
                <option value="SHIB">SHIB</option>
                <option value="DOGE">DOGE</option>
                </select><br><br>
                <label for="no" class="login_text">Number of Coins:</label>
                <input type="number" name="no" min="1" value="1" class="login_box"><br><br>
                <input type="submit" name="send" value="SEND" class="login_submit">
            </form>
        </div>
        <br><br>
        <div class="footer">
            <p>CryptoWallet</p>
            <p>Copyright &copy 2022 Kishore Prashanth P 2020115043</p>
        </div>
    </body>
</html>
