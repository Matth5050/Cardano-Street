<?php

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->select_db("xxxxx");

$sql = "SELECT * FROM ispos";
$result = $conn->query($sql);


$result_metadata = $conn->query("SELECT * FROM cardano_metadata");
$row_metadata = $result_metadata->fetch_assoc();


function relativeTime($time) {

  $d[0] = array(1,"seconds");
  $d[1] = array(60,"minutes");
  $d[2] = array(3600,"hours");
  $d[3] = array(86400,"days");
  $d[4] = array(604800,"week");
  $d[5] = array(2592000,"month");
  $d[6] = array(31104000,"year");

  $w = array();

  $return = "";
  $now = time();
  $diff = ($now-$time);
  $secondsLeft = $diff;

  for($i=6;$i>-1;$i--)
  {
       $w[$i] = intval($secondsLeft/$d[$i][0]);
       $secondsLeft -= ($w[$i]*$d[$i][0]);
       if($w[$i]!=0)
       {
          $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
       }

  }

  $return .= ($diff>0)?"ago":"left";
  return $return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Source+Code+Pro:wght@200;311&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <title>Cardano Street</title>
</head>
<body>
    
  
   <h1 class="title"><a href="/">The Cardano Watch </a></h1>
   
   <div class="epoch-bar">
    <ul>
     <li>Epoch <?php echo $row_metadata['epoch'];?> ends in: <?php echo relativeTime($row_metadata['end_time']); ?></li>
    </ul>
    </div>
  
  <div class="tab-bar">
    <ul>
     <li><a href="/">ISPOs</a></li>
     <li><a href="/other-projects.php">Other Cardano Projects</a></li>
     <li><a href="/learn-ispo/learn-ispo.html">Learn about ISPOs</a></li>
     <li><a href="/learn-cardano/learn-cardano.html">Learn about Cardano</a></li>
     <li><a href="/about/about.html">About</a></li>
    </ul>
  </div>

    <div class="table">
    <table class ="ISPO-table"> 
        <thead>
          <tr>
           <th>Project</th>
           <th>Description</th>
           <th>Opening Epoch</th>
           <th>Closing Epoch</th>
           <th></th>
          </tr>
       </thead>
       <tbody>
        <?php
        while($row = $result->fetch_assoc()) {
           
            $image = '';
            if (strpos($row['community_link'], 'discord.gg') !== false || strpos($row['community_link'], 'discord.com') !== false) {
                $image = 'discord';
            }
            if (strpos($row['community_link'], 'twitter.com') !== false) {
                $image = 'twitter';
            }
            if (strpos($row['community_link'], 'reddit.com') !== false) {
                $image = 'reddit';
            }
        ?>
            <tr>
            <td><a href="<?php echo $row['ispo_link']; ?>"><?php echo $row['name']; ?></a></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['start_epoch'] ?? '-'; ?></td>
            <td><?php echo $row['closing_epoch'] ?? '-'; ?></td>
            <td><a class="<?php echo $image; ?>" href="<?php echo $row['community_link']; ?>"><ion-icon id="<?php echo $image; ?>" name = "logo-<?php echo $image; ?>"></ion-icon></a></td>
            </tr>
        <?php } ?>

        </tbody>
      </table>
    </div>

  

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>