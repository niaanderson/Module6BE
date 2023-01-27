<?php
   $databaseConnection = mysqli_connect( "localhost", "root", "root", "spotifyNotes");
 
   if ( mysqli_connect_errno() ){
       exit("Database connection failed");
   }
   
   // Temporary Id
   $userId = 1;

   //About To Delete
   if(isset($_GET['postDeleteId'])){
    $postDeleteId= mysqli_real_escape_string($databaseConnection, $_GET['postDeleteId']);

    $sql = "DELETE FROM posts ";
    $sql .= "WHERE id='" . $postDeleteId . "'";

    $postDeletionSuccessful = mysqli_query($databaseConnection, $sql);

    if($postDeletionSuccessful){
        //echo("Post successfully deleted");
        header("Location: thirdPage.php");
        exit();
    } else{
        echo(mysqli_error($databaseConnection));

        if($databaseConnection){
            mysqli_close($databaseConnection);
        }

        exit();
    }
   }
    //About To Edit
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPostClicked'])){
        $postToEdit = mysqli_real_escape_string($databaseConnection, $_GET['postToEdit']);
        $updatedPost = mysqli_real_escape_string($databaseConnection, $_POST['updatedPost']);

        $sql = "UPDATE posts SET ";
        $sql .= "postContent='" . $updatedPost . "' ";
        $sql .= "WHERE id='" . $postToEdit . "'";

        $postUpdateSuccessful = mysqli_query($databaseConnection, $sql);

        if($postUpdateSuccessful){
            header("Location: thirdPage.php");
            exit();
        } else{
            echo(mysqli_error($databaseConnection));

            if($databaseConnection){
                mysqli_close($databaseConnection);
            }

            exit();
        }
    }

    //About To Post
   if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postButtonClicked'])){
    $postContent = mysqli_real_escape_string($databaseConnection, $_POST['postContent']);
    $sql = "INSERT INTO posts";
    $sql .= "( postContent, userid)";
    $sql .= "VALUES ( ";
    $sql .= "'" . $postContent . "', ";
    $sql .= "'" . $userId . "'";
    $sql .= ")";

    $postInsertionSuccessful = mysqli_query($databaseConnection, $sql);

    if($postInsertionSuccessful){
        //echo("Post successfully inserted");
    } else{
        echo(mysqli_error($databaseConnection));

        if($databaseConnection){
            mysqli_close($databaseConnection);
        }

        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en-US">
 
   <head>
       <title>
           Review
       </title>
       <link rel="stylesheet" href="Resources/CSS/style.css">
       <script src="https://kit.fontawesome.com/ebcddd1c6e.js" crossorigin="anonymous"></script>
   </head>
 
   <body>
       <!--Header-->
       <section class="header">
           <img src="Resources/Images/spotifyLogoHeader.png">
           <h1>Spotify</h1>
           <section class="navBar">
               <ul>
                   <a href="index.html"><li>1. Spotify Notes Home</li></a>
                   <a href="secondPage.html"><li>3. Read More On Spotify Notes</li></a>
                   <a href="thirdPage.php"><li>4. Review</li></a>
               </ul>
           </section>
       </section>
       <!--Main Container--> 
       <section class="mainContainer4">
            <h1>Leave A Review!</h1>
           <form action="thirdPage.php" method="post" >
               <textarea name="postContent" ></textarea>
               <input type="submit" value="Post" name="postButtonClicked">
           </form>
           <?php
               $sql = "SELECT * FROM posts";
               $allPosts = mysqli_query ($databaseConnection, $sql);
               while ($currentPost = mysqli_fetch_assoc($allPosts)){
           ?>
               <article>
                   <?php echo ($currentPost ['date']); ?> ;
                   <?php echo ($currentPost ['postContent']); ?> by
                   <?php
                       $sql = "SELECT * FROM users ";
                       $sql .= "WHERE id ='" . $currentPost['userId'] . "'";
 
                       $userOfPost = mysqli_query($databaseConnection, $sql);
                       $userOfPost = mysqli_fetch_assoc($userOfPost);
                   ?>
                   <?php echo($userOfPost ['nickname']); ?>
                   <?php
                       if($userOfPost['id'] == $userId){
                   ?>
                   <a href = "<?php echo ("thirdPage.php?postDeleteId=" . urlencode($currentPost['id'])); ?>">Delete</a>
                   <a href = "<?php echo ("thirdPage.php?postEditId=" . urlencode($currentPost['id'])); ?>">Edit</a>
                   <?php   
                       }
                    ?>
                </article>
                <?php
                  //ABOUT TO EDIT
                  if(isset($_GET['postEditId']) && $currentPost ['id'] == $_GET['postEditId']){
                      $postEditId = mysqli_real_escape_string($databaseConnection, $_GET['postEditId']);
                      
                      $sql = "SELECT * FROM posts ";
                      $sql .= "WHERE id= '" . $postEditId . "'";

                      $postToEdit = mysqli_query($databaseConnection, $sql);
                      $postToEdit = mysqli_fetch_assoc($postToEdit);
              ?>
              <form action="<?php echo("thirdPage.php?postToEdit=" . urlencode($postToEdit['id'])); ?>" method="POST">
                  <textarea name="updatedPost"><?php echo($postToEdit['postContent']); ?></textarea>
                  <input type="submit" value="Edit post" name="editPostClicked">
              </form>
              <?php
                   }
               ?>
            <?php
                }
            ?>
       </section>
       <!--Footer--> 
       <section class="footer">
           <h3>Creative Property Of Nia Anderson</h3>
           <section class="footerSocials">
               <ul>
                   <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                   <li><a href="#"><i class="fa-brands fa-square-github"></i></a></li>
               </ul>
           </section>
       </section>
   </body>
</html>

<?php
    // 5.Close the database connection
   if( $databaseConnection){
    mysqli_close($databaseConnection);
}
?>