<?php
  
  
  
  $file = "tshwane";
?>

'<div class="pop hidden">
        <div class="post">
            <div class="hpht">
                <form action="home.php" method="post">
                    <img src= <?php if ($fl != ''){echo $fl;}else{echo "stikers/tt.png";}?> class="img" id="imgpht">
                    <input type="hidden" name= "himg" id="himg" value=<?php echo $fl?>>
                    <button class="btn" type="submit" name="del">
                        Delete Post
                    </button>
                    <button class="btn" type="submit" name="like">
                        Like
                    </button>
                </form>
            </div>
            <!-- post comments from the user to the database //the com-wrap holds all the comments controls-->
            <div class="com-wrap">
                <div class="form">
                    <form action="home.php" method="post">
                        <input type="hidden" name="cimg" id="cimg" value=<?php echo $fl?>>
                        <input class="hctxt" type="text" name="comment">
                        <input class="hcbtn"type="submit" value="Comment" name="com" id="com">
                        <input class="hcbtn"type="submit" value="Comment" name="coms" id="coms" visible="false">
                    </form>
                </div>
                <div class="comments" id="comments">
                    <ul>
                    <?php
                        // populate it with comments from table
                        $id = 2;
                        $sql            =   'SELECT * FROM comments WHERE filename=:filename';
                        $ex         =   $con->prepare($sql);
                        $ex->execute(['filename'=>$fl]);
                        
                        while($row = $ex->fetch(PDO::FETCH_ASSOC))
                        {                           
                            echo '<li>'.$row['comment'].'</li>';
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>'