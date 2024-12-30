<!DOCTYPE html>
<html>

<head>
  <title>jQuery TE | Downloaded Demo | v.1.4.0</title>

  <link type="text/css" rel="stylesheet" href="demo.css">
  <link type="text/css" rel="stylesheet" href="jquery-te-1.4.0.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script type="text/javascript" src="jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="jquery-te-1.4.0.min.js" charset="utf-8"></script>
  <style>
body {
  font-family: 'lato', sans-serif;
}

.container {
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 10px;
  padding-right: 10px;
}

h2 {
  font-size: 26px;
  margin: 20px 0;
  text-align: center;
}
h2 small {
  font-size: 0.5em;
}

.responsive-table li {
  border-radius: 3px;
  padding: 25px 30px;
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
}
.responsive-table .table-header {
  background-color: #95A5A6;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}
.responsive-table .table-row {
  background-color: #ffffff;
  box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
}
.responsive-table .col-1 {
  flex-basis: 10%;
}
.responsive-table .col-2 {
  flex-basis: 40%;
}
.responsive-table .col-3 {
  flex-basis: 25%;
}
.responsive-table .col-4 {
  flex-basis: 25%;
}
@media all and (max-width: 767px) {
  .responsive-table .table-header {
    display: none;
  }
  .responsive-table li {
    display: block;
  }
  .responsive-table .col {
    flex-basis: 100%;
  }
  .responsive-table .col {
    display: flex;
    padding: 10px 0;
  }
  .responsive-table .col:before {
    color: #6C7A89;
    padding-right: 10px;
    content: attr(data-label);
    flex-basis: 50%;
    text-align: right;
  }
}

    </style>
</head>

<body>
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
   ?>
   
    <div class='container'>
  <h2> Manage responses</h2>
  <ul class='responsive-table'>
    <li class='table-header'>
      <div class='col col-1'>ID</div>
      <div class='col col-2'>Story Title</div>
      <div class='col col-3'>Edit</div>
      <div class='col col-4'>Delete</div>
      <div class='col col-4'>Visible(Published / Non visible)</div>
    </li>
  <?php
   foreach($result as $row) {
    $status = $row['status'] == 1 ? "Published" : "Non visible"; 
    echo "
    
    <li class='table-row'>
      <div class='col col-1' data-label='Job Id'>".$row['id']."</div>
      <div class='col col-2' data-label='Customer Name'>".$row['title']."</div>
      <div class='col col-3' data-label='Amount'><a href='edit.php?edit=true&id=".$row['id']."'>Edit</a></div>
      <div class='col col-4' data-label='Payment Status'><a href='delete.php?delete=true&id=".$row['id']."'>Delete</a></div>
      <div class='col col-4' data-label='Payment Status'>".$status."</div>
    </li>
 
    
    ";

   }

   echo" </ul>
   </div>
       ";
   


 
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

  <hr>

</body>

</html>