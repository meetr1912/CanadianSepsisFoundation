
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


    $stmt = $file_db->query('SELECT * FROM posts where status = 1');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    echo json_encode($data);


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