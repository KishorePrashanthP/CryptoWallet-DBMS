<?php
session_start();
if(empty($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('Login / Signup first!');";
    echo "window.location.replace('http://localhost/CryptoProject/login/login.php')</script>";
}
?>
<?php

if(isset($_POST['check'])){
    $answer=$_POST['answer'];
    if($_SESSION['result']==$answer){
        unset($_SESSION['result']);
        $unique_id=$_SESSION['unique_id'];
        $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
        if(!$conn){
            echo "An Error Occured.\n";
            exit;
        }
        $q1="SELECT * FROM temp_blockchain WHERE unique_id='$unique_id';";
        $r1=pg_query($conn,$q1);
        $row1=pg_fetch_assoc($r1);
        $sender=$row1['sender'];
        $receiver=$row1['receiver'];
        $no_of_coins=$row1['no_of_coins'];
        $coin_name=$row1['coin_name'];
        $q2="DELETE FROM temp_blockchain WHERE unique_id='$unique_id';";
        pg_query($conn,$q2);
        $q3="INSERT INTO blockchain (sender,receiver,no_of_coins,coin_name) VALUES ('$sender','$receiver','$no_of_coins','$coin_name');";
        pg_query($conn,$q3);
        $source="Credited";
        $q4="SELECT no_of_coins FROM user_assets WHERE coin_name='$coin_name' AND source='$source' AND username='$receiver';";
        $r4=pg_query($conn,$q4);
        $row2=pg_fetch_assoc($r4);
        $rows_coin=$row2['no_of_coins'];
        if($rows_coin>0){
            $q5="UPDATE user_assets SET no_of_coins=$rows_coin+$no_of_coins WHERE coin_name='$coin_name' AND source='$source' AND username='$receiver';";
            pg_query($conn,$q5);
        }
        else{
            $q6="INSERT INTO user_assets (username,coin_name,no_of_coins,source) VALUES ('$receiver','$coin_name','$no_of_coins','$source');";
            pg_query($conn,$q6);
        }
        $_SESSION['success_mined']="Added to Bloakchain";
        $username=$_SESSION['username'];
        $source='Mining Reward';
        $q8="SELECT no_of_coins FROM user_assets WHERE coin_name='$coin_name' AND source='$source' AND username='$username';";
        $r8=pg_query($conn,$q8);
        $rows_coin=$r8['no_of_coins'];
        if($rows_coin>0){
            $q10="UPDATE user_assets SET no_of_coins=$rows_coin+1 WHERE coin_name='$coin_name' AND source='$source' AND username='$username';";
            pg_query($conn,$q10);
        }
        else{
            $q7="INSERT INTO user_assets (username,coin_name,no_of_coins,source) VALUES ('$username','$coin_name','1','Mining Reward');";
            pg_query($conn,$q7);
        }
        header('location:../index.php');  
    }
    else{
        $_SESSION['failure_mined']="Transaction Unsuccessful";
        header('location:../index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>Miner's Transaction Pool | CryptoWallet</title>
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
            <li><a href="../transaction/transaction.php">Transaction</a></li>
            <li><a href="../temp_blockchain/MinersPool.php" class="active">Mining</a></li>
            <li class="right"><a href="../login/login.php">Log in</a></li>
        </ul>
        <div style="padding-right: 10px;"><?php 
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout'>".$_SESSION['username']."</p>";
        }
        ?>
        </div><br><br><br>
        <?php
        if(isset($_POST['filter'])){
            $_SESSION['unique_id']=$_POST['filter'];
            $num_1=rand(1,10);
            $num_2=rand(1,10);
            $_SESSION['result']=$num_1+$num_2;
            echo "<p class='sum'>".$num_1."+".$num_2."=</p>";
            echo "<form method='POST' class='login' style='margin-top:-5px;margin-bottom:35px;'><input type='number' class='login_box' name='answer' style='margin-right:20px;'><input type='submit' class='login_submit' name='check' value='CHECK'></form>";   
        }
        ?>
        <?php
        $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
        if(!$conn){
            echo "An Error occured.\n";
            exit;
        }
        $sender=$_SESSION['username'];
        $query="SELECT * FROM temp_blockchain WHERE sender <> '$sender' AND receiver <> '$sender';";
        $result=pg_query($conn,$query);
        if(!$result){
            echo "An Error occured.\n";
            exit;
        }
        echo "<table style='margin-left:330px;'><tr><th>#</th><th>Sender</th><th>Receiver</th><th>Coins</th><th>Name</th></tr>";
        while($rows=pg_fetch_assoc($result)){
            echo "<tr><td><form method='POST' action=''><button class='login_submit' type='submit' name='filter' value='".$rows['unique_id']."'>Solve</button></form></td><td>".$rows['sender']."</td><td>".$rows['receiver']."</td><td>".$rows['no_of_coins']."</td><td>".$rows['coin_name']."</td></tr>";
        }
        echo "</table>";
        pg_close($conn);
        ?>
        <br><br>
        <div class="footer">
            <p>CryptoWallet</p>
            <p>Copyright &copy 2022 Kishore Prashanth P 2020115043</p>
        </div>
    </body>
</html>
