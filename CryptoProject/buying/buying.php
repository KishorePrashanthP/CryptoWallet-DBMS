<?php
session_start();
if(isset($_POST['buyorsell'])){
    $_SESSION['buyorsellname']=$_POST['buyorsell'];
    header('location:../payment/payment.php');
}
?>

<!DOCTYPE html>
<html lang="EN">
    <head>
        <title>Exchange Cryptos | CryptoWallet</title>
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
        <?php 
        $var=$_SESSION['exchange_list'];
        if(isset($_SESSION['username'])&&(isset($_SESSION['success']))){
            echo "<p class='logout_exchange'>".$var."</p>";
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
        $query="SELECT c.crank,c.cname,c.coin_name,e.price,e.no_of_coins FROM cryptocurrencies AS c INNER JOIN exchangeslist_price AS e USING (coin_name) WHERE elname='$var' ORDER BY c.crank;";
        $result=pg_query($conn,$query);
        if(!$result){
            echo "An Error Occured.\n";
            exit;
        }
        echo "<table><tr><th>#</th><th>Name</th><th>Price</th><th>Availability</th></tr>";
            while($rows=pg_fetch_assoc($result)){
                echo "<tr><td>".$rows['crank']."</td><td><form method='POST'><input class='login_submit' type='submit' name='buyorsell' value='".$rows['cname']."'></form></td><td>$".$rows['price']."</td><td>".$rows['no_of_coins']."</td></tr>";
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