
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

    if (isset($_GET['id'])) {
        $val = (int) $_GET['id'];
        $query = 'SELECT * FROM posts where id =' . $val;
        // Select all data from file db messages table
        $result = $file_db->query($query);

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

        foreach ($result as $row) {
            ?>

<!DOCTYPE html>
<html>

<head>
  <title>jQuery TE | Downloaded Demo | v.1.4.0</title>

  <link type="text/css" rel="stylesheet" href="demo.css">
  <link type="text/css" rel="stylesheet" href="jquery-te-1.4.0.css">

  <script type="text/javascript" src="jquery.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="jquery-te-1.4.0.min.js" charset="utf-8"></script>
</head>

<body>

  <form action="edit.php" method="post" enctype="multipart/form-data">

    <label for="title">Title:</label><br />
    <input name="title" id="title" type="text" maxlength="150" value = "<?php echo $row['title']; ?>" />
    <div class="clear"></div>

    <label for="textarea">Story:</label><br />
    <textarea name="textarea" class="jqte-test" value = ""><?php echo $row['message']; ?></textarea>

    <div class="clear"></div>
    <img src="<?php echo $row['image']; ?>" height="20%" width="20%"/>
    <div class="clear"></div>
    <input type="radio" name="status" value="visible" > Make the story public<br>
    <input type="radio" name="status" value="disabled" checked> Keep Non Visible<br>
    <input type="hidden" name="updateID" value="<?php echo $row['id'];?>">
    <input type="submit" value="Update Status" />
  </form>

  <!------------------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------------------>


  <script>
    $('.jqte-test').jqte();

    // settings of status
    var jqteStatus = true;
    $(".status").click(function () {
      jqteStatus = jqteStatus ? false : true;
      $('.jqte-test').jqte({
        "status": jqteStatus
      })
    });
  </script>

  <!------------------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------------------>


  <hr>

</body>

</html>

    <?php
}

    } else {

        if (isset($_POST['status'])) {

            // Prepare INSERT statement to SQLite3 file db
            $insert = "UPDATE posts SET status = :status, title = :title, message = :message where id = :id";
            $stmt = $file_db->prepare($insert);

            $status = $_POST['status'] == "visible" ? 1 : 0;
// Bind parameters to statement variables
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':title', $_POST['title']);
            $stmt->bindParam(':message', $_POST['textarea']);
            $stmt->bindParam(':id', $_POST['updateID']);

            $stmt->execute();

            
            header( "refresh:0; url=admin.php" );
        }
    }

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

} catch (PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
}
?>