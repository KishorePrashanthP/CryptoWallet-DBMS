<?php
session_start();
if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['success']);
    header("location: index.php");
}
if(!(empty($_SESSION['success_bought']))){
    echo "<script type='text/javascript'>alert('".$_SESSION['no_of_coins'].$_SESSION['coin_name']. " successfully purchased from ".$_SESSION['exchange_list']."')</script>";
    unset($_SESSION['success_bought']);
    unset($_SESSION['no_of_coins']);
    unset($_SESSION['coin_name']);
    unset($_SESSION['exchange_list']);
}
if(!(empty($_SESSION['failure_bought']))){
    echo "<script type='text/javascript'>alert('Insufficient Coins')</script>";
    unset($_SESSION['failure_bought']);
}
if(!(empty($_SESSION['sell_success']))){
    echo "<script type='text/javascript'>alert('Exchanged (sold) successfully')</script>";
    unset($_SESSION['sell_success']);
}
if(!(empty($_SESSION['sell_failure']))){
    echo "<script type='text/javascript'>alert('Exchange was unsuccessfully')</script>";
    unset($_SESSION['sell_failure']);
}
if(!(empty($_SESSION['transfer_success']))){
    echo "<script type='text/javascript'>alert('Your transaction will be processed after some time')</script>";
    unset($_SESSION['transfer_success']);
}
if(!(empty($_SESSION['transfer_failure']))){
    echo "<script type='text/javascript'>alert('Your transaction is declined')</script>";
    unset($_SESSION['transfer_failure']);
}
if(!(empty($_SESSION['success_mined']))){
    echo "<script type='text/javascript'>alert('Transaction added to Blockchain')</script>";
    unset($_SESSION['success_mined']);
}
if(!(empty($_SESSION['failure_mined']))){
    echo "<script type='text/javascript'>alert('Invalid Poof of work')</script>";
    unset($_SESSION['failure_mined']);
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>CryptoWallet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <meta name="author" content="Kishore Prashanth P(2020115043)">
        <link rel="stylesheet" href="../CryptoProject/CSS/styles.css">
        <link rel="icon" type="image/png" href="../CryptoProject/images/dogecoin.png">
    </head>
    <body>
        <div class="header">
            <p>CryptoWallet</p>
        </div>
        <ul class="topnav">
            <li><a class="active" href="../CryptoProject/index.php">Home</a></li>
            <li><a href="../CryptoProject/exchangeslist/exchangeslist.php">Exchanges</a></li>
            <li><a href="../CryptoProject/usercoins/usercoins.php">Wallet</a></li>
            <li><a href="../CryptoProject/transaction/transaction.php">Transaction</a></li>
            <li><a href="../CryptoProject/temp_blockchain/MinersPool.php">Mining</a></li>
            <li class="right"><a href="../CryptoProject/login/login.php">Log in</a></li>
        </ul>
        <div style="padding-right: 10px;"><?php 
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout'>".$_SESSION['username']."/<a href='"."index.php?logout='1'"."'"." class='a_logout'>Logout</a></p>";
        }
        ?>
        </div><br><br><br>
        <?php
            $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
            if(!$conn){
                echo "An Error occured.\n";
                exit;
            }
            $query="SELECT * FROM cryptocurrencies ORDER BY crank";
            $result=pg_query($conn,$query);
            if(!$result){
                echo "An Error occured.\n";
                exit;
            }
            echo "<table style='margin-left:330px;'><tr><th>#</th><th>Name</th><th>Price</th><th>24h %</th><th>7d %</th></tr>";
            while($rows=pg_fetch_assoc($result)){
                echo "<tr><td>".$rows['crank']."</td><td>".$rows['cname']."    ".$rows['coin_name']."</td><td>$".$rows['price']."</td><td>".$rows['_24hr']."%</td><td>".$rows['_7d']."%</td></tr>";
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