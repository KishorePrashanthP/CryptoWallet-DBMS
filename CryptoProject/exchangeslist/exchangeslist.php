<?php
session_start();
if(isset($_POST['exchangeslist_select'])){
    $_SESSION['exchange_list']=$_POST['exchangeslist_select'];
    header('location:../buying/buying.php');
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>Exchanges List | CryptoWallet</title>
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
        <?php
        $conn=pg_connect("host=localhost port=5432 dbname=CryptoProject user=postgres password=k31i05s02");
        if(!$conn){
            echo "An Error Occured.\n";
            exit;
        }
        $query="SELECT * FROM exchangeslist;";
        $result=pg_query($conn,$query);
        if(!$result){
            echo "An Error Occured.\n";
            exit;
        }
        echo "<table style='margin-left:190px;'><tr><th>#</th><th>Name</th><th>Based In</th><th>Regulated</th><th>Founded</th><th>Trading Commissions</th><th>Exchange Scores</th></tr>";
        while($rows=pg_fetch_assoc($result)){
            echo "<tr><td>".$rows['elrank']."</td><td><form method='POST'><input type='submit' name='exchangeslist_select' value='".$rows['elname']."' class='login_submit'></form></td><td>".$rows['basedin']."</td><td>".$rows['regulated']."</td><td>".$rows['founded']."</td><td>".$rows['tradecommper']."</td><td>".$rows['exchangescr']."</td></tr>";
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