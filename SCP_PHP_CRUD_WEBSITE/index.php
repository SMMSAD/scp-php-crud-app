<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP PHP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/scp-styling.css?<?php echo time(); ?>" rel="stylesheet">
    <!--  -->
  </head>
  <body class="container">
      <?php include "connection.php"; ?>
      <header class=""> 
          <a href="index.php"><img src="images/scpLogoWhite.png" alt="scp logo" class="logo"></a>
          <br>
          <?php foreach($result as $link): ?>
              <a href="index.php?link=<?php echo $link['subject']; ?>" class=""><?php echo $link['subject']; ?></a> <!-- nav-link text-light -->
          <?php endforeach; ?>
              <br><br><a href="create.php" class="min-btn">Create a new SCP record.</a>
              
      </header>
    <br>
    <h1>SCP PHP CRUD WEB-APP</h1>
    <div>
        <?php
            
            if(isset($_GET['link']))
            {
                $subject = $_GET['link'];
                
                // prepared statement
                $stmt = $connection->prepare("select * from scp where subject = ?");
                if(!$stmt)
                {
                    echo "<p>Error in preparing SQL statement</p>";
                    exit;
                }
                $stmt->bind_param("s", $subject);
                
                if($stmt->execute())
                {
                    $result = $stmt->get_result();
                    
                    // check if a record has been retrieved
                    if($result->num_rows > 0)
                    {
                        $array = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        echo "
                            <div class='midground-box'>
                            <h2 class='card-title'>
                            <strong>ID:</strong> {$array['subject']}
                            </h2>
                            <h4>
                            <strong>Class:</strong> {$array['class']}
                            </h4>
                            <p class='text-center'>
                            <img src='{$array['image']}' alt='{$array['subject']}' class='img-fluid'>
                            </p>
                            <p><strong>Description:</strong> {$array['description']}</p>
                            <p><strong>Containment Procedures:</strong> {$array['containment']}</p>
                            <p>
                                 
                                <a href='{$update}' class='btr-btn'>Update Record</a> <br><br>
                                <a href='{$delete}' class='btr-btn dngr'>Delete Record</a>
                                
                            </p>
                            </div>
                        ";
                    }
                    else
                    {
                        echo "<p>No record found for subject: {$array['subject']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing the statement,  {$stmt->error}</p>";
                }
               
            }
            else
            {
                echo "
                    <main id='display' class='midground-box'>
                        <p>Select an entry to view details</p>
                    </main>
                    <div style='text-align: center;'> 
                        <p>Select an entry from the heading to view details.</p>
                        <p> <a href='index.php'>
                        <img src='images/scpLogoWhite.png' alt='SCP' class='' style='width: 5rem; border: 0 none;'>
                        </a> </p>
                    </div>
                ";
            }
            
            // delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("delete from scp where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Recorded Deleted...</div>";
                }
                else
                {
                     echo "<div class='alert alert-danger'>Error deleting record {$delete->error}.</div>";
                }
            }
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
