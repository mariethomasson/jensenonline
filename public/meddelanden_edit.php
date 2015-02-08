<?php
    $pageTitle = "Redigera Meddelande";
    $section = "redigera_meddelanden";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>


<link href="css/pages/meddelanden.css" rel="stylesheet">

<main> 
    
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12 headline">
                        <h2>Redigera Meddelande</h2>
                        <?php echo logged_in(); ?>
                    </div> <!--span12-->
                </div> <!--row-->


<?php 

 if(isset($_GET['id'])) {
        
    try{
            $query = "SELECT * FROM posts WHERE id = :id";

            $ps = $db->prepare($query);
            $result = $ps->execute(
                array(
                    'id'=>$_GET['id']
            ));

            $posts = $ps->fetch(PDO::FETCH_ASSOC); 
        
            $id = $posts['id'];    
            $headline = $posts['headline'];
            $content = $posts['content'];
           
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }
  
$headlineErr = $contentErr = '';

if(isset($_POST['edit'])) {
  
            $headline= $_POST['headline'];
            $content = $_POST['content'];
            $id = $_POST['id'];
     
     if (empty($headline)) {
			$headlineErr = "Headline is required";
		}
        
        if (empty($content)) {
			$contentErr = "Content is required";
		}
        
        if(strlen($headline) > 80){
            $headlineErr = "The headline can't be longer than 80 characters";
        }
        
        if (empty($headlineErr) && empty($contentErr)) {
    
        try{  
            $query = "UPDATE posts ";
            $query .= "SET headline = :headline, content = :content ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'headline'=>$headline, 
                    'content'=>$content, 
                    'id'=>$id
                    ));

                if ($result) {
                 echo "Post updated";
                }else {
                 echo "Failed ";
                }

        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

    }

  } 
?>               
                <div class="row">
                    <div class="span9">
                    <form action="meddelanden_edit.php" method="POST">
	                   <table>
	                       <tr>
		                      <td>Headline:</td> 
		                      <td><input type="text-field" id="headline" name="headline" class='span6' value="<?php echo $headline;?>"/><span class="error"> * <?php echo $headlineErr; ?></span></td>
	                       </tr>
        	               <tr>
		                      <td>Content:</td> 
		                      <td><textarea id="content" name="content" class="form-control span9" rows="20" ><?php echo htmlspecialchars($content);?></textarea><span class="error"> * <?php echo $contentErr; ?></span</td>
	                       </tr>
	                       <tr>
                               <td><input type='hidden' name='id' value="<?php echo $id ;?>" /></td>    
                               <td><input type="submit" value="Edit" name="edit" class="button btn btn-success btn-large"/></td>
	                       </tr>
	                   </table>
                    </form>
                </div> <!--span 9-->
                </div> <!--row-->    
            
            </div> <!--container-->
        </div> <!--main-inner-->
    </div> <!--main-->
        
</main>
    
<?php
include("layout/footer.php");
?>