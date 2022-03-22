<?php

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->select_db("xxxxx");

$sql = "SELECT * FROM `other-projects`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/other-projects/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Source+Code+Pro:wght@200;311&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <title>Other Cardano Projects</title>
</head>
<body>

  <h1 class="title"><a href="/">The Cardano Watch</a></h1>

  
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
           <th>Status</th>
           <th></th>
           <th></th>
          </tr>
       </thead>
       <tbody>
       <?php
        while($row = $result->fetch_assoc()) {
           
            $image = '';
            if (strpos($row['community-links'], 'discord.gg') !== false || strpos($row['community-links'], 'discord.com') !== false) {
                $image = 'discord';
            }
            if (strpos($row['community-links'], 'twitter.com') !== false) {
                $image = 'twitter';
            }
            if (strpos($row['community-links'], 'reddit.com') !== false) {
                $image = 'reddit';
            }
        ?>
            <tr>
            <td><a href="<?php echo $row['name-links']; ?>"><?php echo $row['name']; ?></a></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['status'] ?? '-'; ?></td>
            <td><a class="<?php echo $image; ?>" href="<?php echo $row['community-links']; ?>"><ion-icon id="<?php echo $image; ?>" name="logo-<?php echo $image; ?>"></ion-icon></a></td>
            </tr>
        <?php } ?>

        </tbody>
        </table>
        </div>






<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
