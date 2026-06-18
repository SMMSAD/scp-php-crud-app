<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/scp-styling.css?<?php echo time(); ?>" rel="stylesheet">
  </head>
  
  <body class="container">
      <?php

            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                // write a prepared statement to insert data
                $insert = $connection->prepare("insert into scp(subject, class, description, containment, image) values(?,?,?,?,?)");
                $insert->bind_param("sssss", 
                    $_POST['subject'],
                    $_POST['class'], 
                    $_POST['description'], 
                    $_POST['containment'], 
                    $_POST['image']);
                
                if($insert->execute()) {
                    
                } else {
                    echo "<div class='alert alert-danger p-3 m-3'>Error: {$insert->error}</div>";
                }
                
                // Show success message
                echo "<div class='alert alert-success p-3 m-3'>Record successfully created</div>";

                
            }
      
      ?>
    <h1>Create a new record.</h1>
    <br>
    <p><a href="index.php" class="btr-btn">Back to index page.</a></p>
    <div class="midground-box"> <!-- p-3 bg-light border shadow -->
        <form method="post" action="create.php" class="midground-box">
            <label>Enter Subject ID:</label>
            <br>
            <input type="text" name="subject" placeholder="subject ID..." class="form-control" required>
            <br><br>
            
            <label>Enter Class:</label>
            <br>
            <input type="text" name="class" placeholder="class..." class="form-control">
            <br><br>
            
            <label>Enter Description:</label>
            <br>
            <textarea name="description" class="form-control">Enter description:</textarea>
            <br><br>
            
            <label>Enter Special Containment Procedures:</label>
            <br>
            <textarea name="containment" class="form-control">Enter containment:</textarea>
            <br><br>
            
            <label>Enter Image path/URL:</label>
            <br>
            <input type="text" name="image" placeholder="images/name_of_image.png or URL of image" class="form-control">
            <br><br>
            
            <input type="submit" name="submit" value="Create Record" class="btr-btn whtblk">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>