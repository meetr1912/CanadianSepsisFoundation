
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
        $query = 'delete FROM posts where id =' . $val;
        // Select all data from file db messages table
        $result = $file_db->query($query);
        
        header( "refresh:0; url=admin.php" );
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