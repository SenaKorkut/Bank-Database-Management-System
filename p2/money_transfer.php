
<?php
define('DB_SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('DB_USERNAME', 'sena.korkut');
   define('DB_PASSWORD', 'KcAWEeki');
   define('DB_DATABASE', 'sena_korkut');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
session_start();
 
?>

<!DOCTYPE html>
<html lang="en" class='welcome'>
<head>
    <meta charset="UTF-8">
    <title>Money Transfer</title>
<body>
	
  <div class='transfer'>
    <a href="customer_welcome.php" style="text-decoration: none; cursor:pointer;"><-Back</a>	
    <h2>Money Transfer</h2>
    <hr>
	<script type="text/javascript">

</script>

    <div class='container'>
      <?php

        if (isset($_POST['submitTransfer'])) {
          $fromAccount = $_POST['fromAccount'];
          $toAccount = $_POST['toAccount'];
          $amount = $_POST['amount'];
		  if(empty(trim($fromAccount)) or empty(trim($toAccount)) or empty(trim($amount))){
			echo "<script type='text/javascript'>alert('All boxes should be filled');</script>";
          } 
		  else {
		   $cid = $_SESSION['cid'];
		   $sql = mysqli_prepare($db,"SELECT * FROM owns WHERE aid ='$fromAccount'and cid = '$cid'");
           mysqli_stmt_execute($sql);
			mysqli_stmt_store_result($sql);
			if(mysqli_stmt_num_rows($sql) != 1){
				echo "<script type='text/javascript'>alert('No such account(target) has been detected');</script>";
			}
			else {
            $result = mysqli_query($db,"SELECT balance FROM account WHERE aid='$fromAccount' LIMIT 1");
            $value = mysqli_fetch_object($result);
            $balance_from = $value->balance;

            if($balance_from < $amount){
              	echo "<script type='text/javascript'>alert('Not enough money');</script>";

            } else {

			  $sql = mysqli_prepare($db,"SELECT balance FROM account WHERE aid='$toAccount' LIMIT 1");
			  mysqli_stmt_execute($sql);
			  mysqli_stmt_store_result($sql);
			  if(mysqli_stmt_num_rows($sql) != 1){
				echo "<script type='text/javascript'>alert('No such account(destination) has been detected');</script>";
			  }
			  else {
			  $sql2 = "SELECT balance FROM account WHERE aid='$toAccount' LIMIT 1";
              $result2 = mysqli_query($db, $sql2);
              $value2 = mysqli_fetch_object($result2);
              $balance_to = $value2->balance;
			  if ($fromAccount != $toAccount) {
              $balance_from -= $amount;

              
			  $balance_to += $amount;
			
			  
              $toUpdate = "UPDATE account SET balance='$balance_to' WHERE aid='$toAccount'";
			  $fromUpdate = "UPDATE account SET balance='$balance_from' WHERE aid='$fromAccount'";  

			  $sql1 = mysqli_prepare($db,$toUpdate);
			   $sql1= mysqli_stmt_execute($sql1);
			  $sql2 = mysqli_prepare($db,$fromUpdate);
			   $sql2 =  mysqli_stmt_execute($sql2);
			 
              if ( $sql1 && $sql2) {
				  echo "<script type='text/javascript'>alert('Transfer successful!');</script>";
              } else {
                echo "<script type='text/javascript'>alert('Transfer failed');</script>";
              }
			  }
			  else {
				  echo "<script type='text/javascript'>alert('Accounts are same');</script>";
			  }
			  }
			  
			}
          }
        }
		}
      ?>
    </div>

    <h3>From the account: </h3>
    <form method = "post" action = "<?php $_PHP_SELF ?>">
      <main>
        <table class='main'>
            <thead>
                <tr>
                  <th>
                    Account ID
                  </th>
                  <th>
                    Branch
                  </th>
                  <th>
                    Balance
                  </th>
                  <th>
                    Open Date
                  </th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $cid = $_SESSION['cid'];
                  $sql = "SELECT aid, branch, balance, openDate FROM owns NATURAL JOIN account WHERE cid = '$cid'";
                  $result = mysqli_query($db, $sql);

                  if($result-> num_rows > 0) {
                      while($row = mysqli_fetch_array($result)) {
                      ?>
                          <tr>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['aid']?></label>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['branch']?></label>
                              </td>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['balance']?></label>
                              </td>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['openDate']?></label>
                              </td>
                          </tr>
                      <?php
                      }
                      echo "</table>";
                  } else {
                         echo "<script type='text/javascript'>alert('There is no account.');</script>";

                  }
				  $sql = "SELECT aid, name, branch FROM account NATURAL JOIN customer NATURAL JOIN owns";
                  $result = mysqli_query($db, $sql);

                  if($result-> num_rows > 0) {
                      ?>
                          <tr>
                              <td>
                                <div class="form-group">
								<label>From Account id:</label>
								<input type="fromAccount" name="fromAccount" class="form-control" id="fromAccount">

								</div>
                              </td>
                          </tr>
                      <?php
                      echo "</table>";
                  }
              ?>
            </tbody>
        </table>
      </main><h3>To the account: </h3>
      <main>
        <table class='main'>
            <thead>
                <tr>
                  <th>
                    Account ID
                  </th>
                  <th>
                    Name
                  </th>
				   <th>
                    Branch
                  </th>
				  <th>
                    Balance
                  </th>
                </tr>
            </thead>
            <tbody>
			<?php
			$sql = "SELECT aid, name, branch,balance FROM account NATURAL JOIN customer NATURAL JOIN owns";
            $result = mysqli_query($db, $sql);
			if($result-> num_rows > 0) {
                      while($row = mysqli_fetch_array($result)) {
                      ?>
                          <tr>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['aid']?></label>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['name']?></label>
                              </td>
                              <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['branch']?></label>
                              </td>
							  <td>
                                <label for=<?php echo $row['aid']?>><?php echo $row['balance']?></label>
                              </td>
                          </tr>
                      <?php
                      }
                      echo "</table>";
                  } else {
                         echo "<script type='text/javascript'>alert('No such account(destination) detected.');</script>";
                  }
                  $sql = "SELECT aid, name, branch FROM account NATURAL JOIN customer NATURAL JOIN owns";
                  $result = mysqli_query($db, $sql);

                  if($result-> num_rows > 0) {
                      ?>
                          <tr>
                              <td>
                                <div class="form-group">
								<label>To Account id:</label>
								<input type="toAccount" name="toAccount" class="form-control" id="toAccount">

								</div>
                              </td>
                          </tr>
                      <?php
                      echo "</table>";
                  }
              ?>
            </tbody>
        </table>
      </main>

      <h3>Amount to be transfered: </h3>
      <input type="number" name="amount" id ='amount' class='form-control' min="1">
      <input type='submit' name='submitTransfer' class='submitTransfer' value='Submit'>
    </form>
  </div>
  
</body>
</html>