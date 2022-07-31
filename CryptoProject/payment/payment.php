<?php
session_start();
if(empty($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('Login / Signup first!');";
    echo "window.location.replace('http://localhost/CryptoProject/login/login.php')</script>";
}
//FORM VALIDATE
$noofcoin_Err=$cardno_Err1=$cardno_Err2="";
if(isset($_POST['pay'])){
    $platform=$_POST['platform'];
    if(empty($_POST['nocoins'])){
        $noofcoin_Err="Enter your required coins";
    }
    else{
        $nocoin=$_POST['nocoins'];
    }
    $username=$_SESSION['username'];
    $coin_name=$_POST['coin'];
    $options=$_POST['options'];
    if(empty($_POST['cardno'])){
        $cardno_Err1="Enter your card number";
    }
    elseif(strlen((string)($_POST['cardno']))!=11){
        $cardno_Err2="Enter valid 11-digit card number";
    }
    else{
        $cardno=$_POST['cardno'];
    }
    if(($cardno_Err1=="")&&($cardno_Err2=="")&&($noofcoin_Err=="")){
        $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
        if(!$conn){
            echo "An Error Occured.\n";
            exit;
        }
        $query1="SELECT coin_name FROM cryptocurrencies WHERE cname='$coin_name';";
        $result1=pg_query($conn,$query1);
        $row=pg_fetch_assoc($result1);
        $coin=$row['coin_name'];
        $sql="SELECT no_of_coins FROM exchangeslist_price WHERE coin_name='$coin' AND elname='$platform';";
        $sol=pg_query($conn,$sql);
        $col=pg_fetch_assoc($sol);
        if($col['no_of_coins']>0){
            $new_noofcoins=$col['no_of_coins']-1;
            $query="UPDATE exchangeslist_price SET no_of_coins=$new_noofcoins WHERE coin_name='$coin' AND elname='$platform';";
            pg_query($conn,$query);
            $source="Exchange Platform";
            $q="SELECT no_of_coins FROM user_assets WHERE coin_name='$coin' AND source='$source';";
            $r=pg_query($conn,$q);
            $rows=pg_fetch_assoc($r);
            $rows_coin=$rows['no_of_coins'];
            if($rows_coin>0){
                $q1="UPDATE user_assets SET no_of_coins=$rows_coin+$nocoin WHERE coin_name='$coin' AND source='$source';";
                pg_query($conn,$q1);
            }
            else{
                $query="INSERT INTO user_assets (username,coin_name,no_of_coins,source) VALUES ('$username','$coin','$nocoin','$source');";
                pg_query($conn,$query);
            }
            $_SESSION['success_bought']="Coin has been bought successfully";
            $_SESSION['no_of_coins']=$nocoin;
            $_SESSION['coin_name']=$coin;
            header('location:../index.php');
        }
        else{
            $_SESSION['failure_bought']="Transaction Unsuccessful";
            header('location:../index.php');
        }
        
    }
}
if(isset($_POST['sell_1'])){
    $platform=$_POST['platform'];
    if(empty($_POST['nocoins'])){
        $noofcoin_Err="Enter your required coins";
    }
    else{
        $nocoin=$_POST['nocoins'];
    }
    $username=$_SESSION['username'];
    $coin_name=$_POST['coin'];
    $source=$_POST['source'];
    if($noofcoin_Err==""){
        $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
        if(!$conn){
            echo "An Error Occured.\n";
            exit;
        }
        $query1="SELECT coin_name FROM cryptocurrencies WHERE cname='$coin_name';";
        $result1=pg_query($conn,$query1);
        $row=pg_fetch_assoc($result1);
        $coin=$row['coin_name'];
        $sql="SELECT no_of_coins FROM user_assets WHERE coin_name='$coin' AND username='$username' AND source='$source';";
        $sol=pg_query($conn,$sql);
        $col=pg_fetch_assoc($sol);
        if($col['no_of_coins']>=$nocoin){
            $new_noofcoins=$col['no_of_coins']-$nocoin;
            if($new_noofcoins==0){
                $qu1="DELETE FROM user_assets WHERE coin_name='$coin' AND username='$username' AND source='$source';";
                pg_query($conn,$qu1);
            }
            else{
                $qu3="UPDATE user_assets SET no_of_coins=$new_noofcoins WHERE coin_name='$coin' AND username='$username' AND source='$source';";
                pg_query($conn,$qu3);
            }
            $qu2="UPDATE exchangeslist_price SET no_of_coins=no_of_coins+$nocoin WHERE elname='$platform' AND coin_name='$coin';";
            pg_query($conn,$qu2);
            $_SESSION['sell_success']="Success";
            header('location:../index.php');
        }
        else{
            $_SESSION['sell_failure']="Failure";
            header('location:../index.php');
        }

        
    }
}
?>
<!DOCTYPE html>
<html lang='EN'>
    <head>
        <title>Payment Platform | CryptoWallet</title>
        <meta charset="UTF-8">
        <meta name="author" content="Kishore Prashanth P (2020115043)">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="../CSS/styles.css">
        <link rel="icon" type="image/png" href="../images/dogecoin.png">
    </head>
    <body>
        <div class="header">
            <p>CryptoWallet</p>
        </div>
        <ul class="topnav">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../exchangeslist/exchangeslist.php" class="active">Exchanges</a></li>
            <li><a href="../usercoins/usercoins.php">Wallet</a></li>
            <li><a href="../transaction/transaction.php">Transaction</a></li>
            <li><a href="../temp_blockchain/MinersPool.php">Mining</a></li>
            <li class="right"><a href="../login/login.php">Log in</a></li>
        </ul>
        <div style="padding-right: 10px;">
        <?php 
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout'>".$_SESSION['username']."</p>";
        }
        ?>
        </div><br><br><br>
        <form method="POST">
        <input type="submit" name="buy" value="Buy-Credit/Debit Card" class='login_submit' style="margin-right:50px;margin-left:34%;">
        <?php
        if(isset($_POST['buy'])){
            $_SESSION['buy']="ON";
        }
        ?>
        <input type="submit" name="sell" value="Sell" class='login_submit'>
        <?php
        if(isset($_POST['sell'])){
            $_SESSION['sell']="ON";
        }
        ?>
        </form><br>
        <?php
        if(!empty($_SESSION['buy'])){
            unset($_SESSION['buy']);
            echo "<div class='login_buy'><form method='POST'>
            <label for='platform' class='login_text'>Exchange Platform:</label>
            <input type='text' class='login_box' name='platform' value='".$_SESSION['exchange_list']."' readonly='readonly'><br><br>
            <label for='coin' class='login_text'>Coin:</label>
            <input type='text' class='login_box' name='coin' value='".$_SESSION['buyorsellname']."' readonly='readonly'><br><br>
            <label for='nocoins' class='login_text'>Number of Coins:</label>
            <input type='number' class='login_box' name='nocoins' min='1' value='1'><br>";
            echo $noofcoin_Err;
            echo "<br><label for='cardname' class='login_text'>Name on Card:</label>
            <input type='text' class='login_box' name='cardname' value='".$_SESSION['username']."' readonly='readonly'><br><br>
            <label for='options' class='login_text'>Select available Card:</label>
            <select name='options' class='login_box'>
            <option value='VISA'>VISA</option>
            <option value='Mastercard'>Mastercard</option>
            <option value='Discover'>Discover</option>
            <option value='Amex'>Amex</option>
            </select><br><br>
            <label for='cardno' class='login_text'>Card Number:</label>
            <input type='text' class='login_box' name='cardno'><br>";
            echo $cardno_Err1;echo $cardno_Err2;
            echo "<br><input type='submit' name='pay' value='Pay' class='login_submit'>
            </form></div>";
        }
        if(!empty($_SESSION['sell'])){
            unset($_SESSION['sell']);
            echo "<div class='login_buy'><form method='POST'>
            <label for='platform' class='login_text'>Exchange Platform:</label>
            <input type='text' class='login_box' name='platform' value='".$_SESSION['exchange_list']."' readonly='readonly'><br><br>
            <label for='coin' class='login_text'>Coin:</label>
            <input type='text' class='login_box' name='coin' value='".$_SESSION['buyorsellname']."' readonly='readonly'><br><br>
            <label for='nocoins' class='login_text'>Number of Coins:</label>";
            echo $noofcoin_Err;
            echo "<br><input type='number' class='login_box' name='nocoins' min='1' value='1'><br>";
            echo "<br><label for='source' class='login_text'>Source:</label><select name='source' class='login_box'>
            <option value='Mining Reward'>Mining Reward</option>
            <option value='Exchange Platform'>Exchange Platform</option>
            <option value='Debitted'>Debitted</option>
            </select><br>";
            echo "<br><input type='submit' name='sell_1' value='Sell' class='login_submit'>
            </form></div>";
        }
        ?>
        <br><br>
        <div class="footer">
            <p>CryptoWallet</p>
            <p>Copyright &copy 2022 Kishore Prashanth P 2020115043</p>
        </div>
    </body>
</html>