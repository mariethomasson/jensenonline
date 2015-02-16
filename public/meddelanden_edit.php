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
                <i>Fält markerade med en * är obligatoriska.</i>
                <br><br>


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
            $class = $posts['class'];
            $headline = $posts['headline'];
            $content = $posts['content'];
           
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }
  
$classErr = $headlineErr = $contentErr = '';

    if(isset($_POST['edit'])) {
            $class = $_POST['class'];
            $headline = $_POST['headline'];
            $content = $_POST['content'];
            $id = $_POST['id'];
     
        if (empty($class)) {
			$classErr = "Klass krävs";
		}
        
        if (empty($headline)) {
			$headlineErr = "Rubrik krävs";
		}
        
        if (empty($content)) {
			$contentErr = "Text krävs";
		}
        
        if(strlen($headline) > 80){
            $headlineErr = "Rubriken får inte vara längre än 80 tecken";
        }
        
        if (empty($classErr) && empty($headlineErr) && empty($contentErr)) {
    
        try{  
            $query = "UPDATE posts ";
            $query .= "SET class = :class, headline = :headline, content = :content ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'class'=>$class,
                    'headline'=>$headline, 
                    'content'=>$content, 
                    'id'=>$id
                    ));

                if ($result) {
                 echo "<i>Meddelandet är ändrat</i><br><br>";
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
                    <td><h3>Rubrik:</h3></td>
                </tr>
                <tr>
                    <td><span class="error"> * <?php echo $headlineErr; ?></span><input type="text-field" id="headline" name="headline" class='span6' value="<?php echo $headline;?>"/>
                    </td>
                </tr>
                <tr>
                    <td><h3>Klass:</h3><span class="error"> * <?php echo $classErr; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="class" id="class" >
                            <option value="">-- Välj --</option>
                            <option value="CBK14">CBK14</option>
                            <option value="IPK14">IPK14</option>
                            <option value="PTK14">PTK14</option>
                            <option value="WUK14">WUK14</option>
                            <option value="Jensen">Jensen</option>
                    </td>
                </tr>
                <tr>
                    <td><h3>Text:</h3>
                    </td>
                </tr>
                <tr>
                    <td><span class="error"> * <?php echo $contentErr; ?></span><textarea id="content" name="content" class="form-control span9" rows="20" ><?php echo htmlspecialchars($content);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><input type='hidden' name='id' value="<?php echo $id ;?>" />
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Spara ändring" name="edit" class="button btn btn-success btn-large"/>
                    </td>
                </tr>
            </table>
        </form>
        <i><a href="meddelanden.php">Tillbaks till meddelanden</a></i>
    </div> <!--span 9-->
</div> <!--row-->    
            
            </div> <!--container-->
        </div> <!--main-inner-->
    </div> <!--main-->
        
</main>
    
<?php
include("layout/footer.php");
?>
    
<script src="js/analyticstracking.js"></script>