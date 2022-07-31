<?php
session_start();
if(empty($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('Login / Signup first!');";
    echo "window.location.replace('http://localhost/CryptoProject/login/login.php')</script>";
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>User Coins | CryptoWallet</title>
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
            <li><a href="../usercoins/usercoins.php" class="active">Wallet</a></li>
            <li><a href="../transaction/transaction.php">Transaction</a></li>
            <li><a href="../temp_blockchain/MinersPool.php">Mining</a></li>
            <li class="right"><a href="../login/login.php">Log in</a></li>
        </ul>
        <div style="padding-right: 10px;"><?php 
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout'>".$_SESSION['username']."</p>";
        }
        ?>
        </div><br><br><br>
       <?php
       $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
       if(!$conn){
           echo "An Error occured.\n";
           exit;
       }
       $username=$_SESSION['username'];
       $query="SELECT coin_name,no_of_coins,source FROM user_assets WHERE username='$username';";
        $result=pg_query($conn,$query);
        if(!$result){
            echo "An Error occured.\n";
            exit;
        }
        echo "<table style='margin-left:330px;'><tr><th>Name</th><th>Coins</th><th>Source</th></tr>";
        while($rows=pg_fetch_assoc($result)){
            echo "<tr><td>".$rows['coin_name']."</td><td>".$rows['no_of_coins']."</td><td>".$rows['source']."</td></tr>";
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