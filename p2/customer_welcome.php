
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
    <title>Bank System - Accounts</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
	integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" 
	crossorigin="anonymous">
		<style type="text/css">
        body{ font: 14px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>

</head>
<body>

  <h6> <style type="text/css">
        body{ font: 19px sans-serif; }
        #centerwrapper { text-align: center; margin-bottom: 10px; }
        #centerdiv { display: inline-block; }
    </style>Hi, <b><?php echo $_SESSION['name'];?></b>. Welcome to SK Bank </h6>
  <h2>Accounts</h2>
  <hr>
	<main>
    <div class='container'>
      <?php
	
        if (isset($_POST['closeAccount'])) {
          $aid = $_POST['aidToDelete'];

          $query = "SELECT * FROM account WHERE aid='$aid'";
          $check = mysqli_query($db, $query);
          if (mysqli_num_rows($check) > 0){
            $delFromOwns = "DELETE FROM owns WHERE aid='$aid'";  
            $delFromAccount = "DELETE FROM account WHERE aid='$aid'";
            mysqli_query($db, $delFromOwns);
            mysqli_query($db, $delFromAccount);
			echo "<script type='text/javascript'>alert('Closure Successful');</script>";

          }
        }
      ?>
    </div>
	<table>
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
                <th></th>
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
                          <form method = "post" action = "<?php $_PHP_SELF ?>">
                            <td><?php echo $row['aid']?></td>
                            <td><?php echo $row['branch']?></td>
                            <td><?php echo $row['balance']?></td>
                            <td><?php echo $row['openDate']?></td>
                            <td class='select'>
                                <input type="hidden" name="aidToDelete" value=<?php echo $row['aid'];?>>
                                <input type='submit' name='closeAccount' class='closeAccount' value='Close'>
                            </td>
                          </form>
                        </tr>
                    <?php
                    }
                    echo "</table>";
                } else {
                  echo "
                  <tfoot>
                    <tr>                      <th colspan='5'>
                        You dont have any accounts.
                      </th>
                    </tr>
                  </tfoot>";
                }
            ?>
        </tbody>
    </table>
  </main>
  <div class='transfer'>
    <h2>Money Transfer</h2>
    <hr>
    <a href="money_transfer.php" class="transferMoney" style="text-decoration: none; cursor:pointer;">Transfer Money</a>		
  </div>
  <div class='transfer'>
    <h2>Log Out</h2>
    <hr>
     <a href="index.php" class="logout" style="text-decoration: none; cursor:pointer;">Logout</a>				
  </div>
</body>
</html>


<div class="header">
   
  </div>