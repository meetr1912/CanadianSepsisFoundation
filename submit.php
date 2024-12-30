
<?php
 
 // Set default timezone
 date_default_timezone_set('UTC');

 try {
   /**************************************
   * Create databases and                *
   * open connections                    *
   **************************************/
  
   // Create (connect to) SQLite database in file
   $file_db = new PDO('sqlite:posts.sqlite3');
   // Set errormode to exceptions
   $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                           PDO::ERRMODE_EXCEPTION);

    

   /**************************************
   * Create tables                       *
   **************************************/
 // $file_db->exec("DROP TABLE posts");
   // Create table messages
   $file_db->exec("CREATE TABLE IF NOT EXISTS posts (
                   id INTEGER PRIMARY KEY AUTOINCREMENT, 
                   title TEXT, 
                   message TEXT, 
                   time TEXT,
                   image TEXT,
                   status INTEGER)");

   


   /**************************************
   * Set initial data                    *
   **************************************/

   /*
   // Array with some test data to insert to database             
   $posts = array(
                 array('title' => 'Hello!',
                       'message' => 'Just testing...',
                       'time' => '1327301464'),
                 array('title' => 'Hello again!',
                       'message' => 'More testing...',
                       'time' => '1339428612'),
                 array('title' => 'Hi!',
                       'message' => 'SQLite3 is cool...',
                       'time' => '1327214268')
               );

               */
   /**************************************
   * Play with databases and tables      *
   **************************************/




   if($_POST['title'] == "" || $_POST['title'] == null){
       echo "<h3>The story is not properly formatted. Please re-submit.</h3>";
       header( "refresh:3; url=display.html" );
       return;
   }            

   $target_dir = "uploads/";
   $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
   $uploadOk = 1;
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   // Check if image file is a actual image or fake image
   if(isset($_POST["submit"])) {
       $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
       if($check !== false) {
           echo "File is an image - " . $check["mime"] . ".";
           $uploadOk = 1;
       } else {
           echo "File is not an image.";
           $uploadOk = 0;
       }
   }
   // Check if file already exists
   if (file_exists($target_file) ) {
       echo "Sorry, file already exists.";
       $uploadOk = 0;
   }
   // Check file size
   if ($_FILES["fileToUpload"]["size"] > 50000000) {
       echo "Sorry, your file is too large.";
       $uploadOk = 0;
   }
   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
   && $imageFileType != "gif" ) {
       echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
       $uploadOk = 0;
   }
   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
       echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
   } else {
       if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
           echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
       } else {
           echo "Sorry, there was an error uploading your file.";
       }
   }







   // Prepare INSERT statement to SQLite3 file db
   $insert = "INSERT INTO posts (title, message, time, image, status) 
               VALUES (:title, :message, :time, :image, :status)";
   $stmt = $file_db->prepare($insert);
   


   $time = date("l jS \of F Y");
   $URL = "".$target_file."";
   $status = 0;
   $message = $_POST['textarea'];
 
   // Bind parameters to statement variables
   $stmt->bindParam(':title', $_POST['title']);
   $stmt->bindParam(':message', $message);
   $stmt->bindParam(':time', $time);
   $stmt->bindParam(':image', $URL);  
   $stmt->bindParam(':status', $status);  
   $stmt->execute();
   // Loop thru all messages and execute prepared insert statement
   /*
   foreach ($posts as $m) {
     // Set values to bound variables
     $title = $m['title'];
     $message = $m['message'];
     $time = $m['time'];
     $file = $m['image']; 
     // Execute statement
     $stmt->execute();
   }
   */

   
   // Select all data from file db messages table 
   $result = $file_db->query('SELECT * FROM posts');

   // Loop thru all data from messages table 
   // and insert it to file db
   /*
   foreach ($result as $m) {
     // Bind values directly to statement variables
     $stmt->bindValue(':id', $m['id'], SQLITE3_INTEGER);
     $stmt->bindValue(':title', $m['title'], SQLITE3_TEXT);
     $stmt->bindValue(':message', $m['message'], SQLITE3_TEXT);

     // Format unix time to timestamp
     $formatted_time = date('Y-m-d H:i:s', $m['time']);
     $stmt->bindValue(':time', $formatted_time, SQLITE3_TEXT);

     // Execute statement
     $stmt->execute();
   }
   */

   // Quote new title
   /*
   foreach($result as $row) {
     echo "<br><strong>Id: </strong>" . $row['id'] . "\n";
     echo "<br><strong>Title: </strong>" . $row['title'] . "\n";
     echo "<br><strong>Message: </strong>" . $row['message'] . "\n";
     echo "<br><strong>Time: </strong>" . $row['time'] . "\n";
     echo "<br><strong>Image: </strong>".$row['image']."\n";



     
    echo "<br><h3>Thank you for sharing your story. We will assess the story for moderation and security and add it on the website.</h3>";
    echo "\n";
   }
   */
  echo "<br><h3>Thank you for sharing your story. We will assess the story for moderation and security and add it on the website.</h3>";
  header( "refresh:3; url=display.html" );
   /**************************************
   * Drop tables                         *
   **************************************/

   // Drop table messages from file db
   //$file_db->exec("DROP TABLE posts");
   // Drop table messages from memory db
   //$memory_db->exec("DROP TABLE messages");


   /**************************************
   * Close db connections                *
   **************************************/
  // $file_db->close();
   unset($file_db);
   // Close file db connection
   $file_db = null;
   // Close memory db connection
   //$memory_db = null;
 
}
 catch(PDOException $e) {
   // Print PDOException message
   echo $e->getMessage();
 }
?>