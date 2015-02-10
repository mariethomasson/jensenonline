<?php
    $pageTitle = "Mina kurser";
    $section = "minakurser";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>

<link href="css/pages/minprofil.css" rel="stylesheet">

    <div class="main">
    <div class="account-container">
        <div class="content clearfix">
            
            <h2>Radera kurs</h2>
           <p> <?php echo logged_in();   //if-satsen ersatt av en funktion ?></p>     

<?php

    if(isset($_GET['id'])) {
        
    try{
            $query = "SELECT * FROM courses WHERE id = :id";

            $ps = $db->prepare($query);
            $result = $ps->execute(
                array(
                    'id'=>$_GET['id']
            ));

            $posts = $ps->fetch(PDO::FETCH_ASSOC); 
        
            $id = $posts['id'];    
            $class = $posts['class'];
            $course = $posts['course'];
            $status = $posts['status'];
            $startdate = $posts['startdate'];
            $enddate = $posts['enddate'];
            $rating = $posts['rating'];
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }

    if (isset($_POST['delete'])){
     
            $class = $_POST['class'];
            $course = $_POST['course'];
            $status = $_POST['status'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $id = $_POST['id'];
    
    try{
        $query = "DELETE FROM courses ";
        $query .= "WHERE id = :id";

        $ps = $db->prepare($query); 
        $result = $ps->execute(
            array(
                'id'=>$id 
            ));
        
            if ($result) {
                echo "Course deleted";
                header("Location: minakurser.php?deleted=true");

        }else {
             echo "Delete failed! <br /><br />";
        }

    } catch(Exception $exception) {
        echo "Query failed, see error message below: <br /><br />";
        echo $exception. "<br /> <br />";
    }
    
}

?>

    <form action="minakurser_delete.php" method="POST" >
        <table class="table">
            <tr class= "login-fields">
                <td>Klass: </td>
                <td class="field"><input type="text" readonly="" name="class"  id="username" value="<?php echo $class;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Kurs: </td>
                <td class="field"><input type="text" readonly="" name="course" class="login username-field" id="username"value="<?php echo $course;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Status: </td>
                <td class="field"><input type="text" name="status"  id="status" value="<?php echo $status;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Startdatum: </td>
                <td class="field"><input type="text" name="startdate" id="startdate" value="<?php echo $startdate;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Slutdatum: </td>
                <td class="field"><input type="text" name="enddate" id="enddate" value="<?php echo $enddate;?>" /></td>
            </tr>
            <tr>
                <input type='hidden' name='id' value=<?php echo $id;?> />
                <td class="login-actions"><input type="submit" name="delete" value="Radera" class="button btn btn-success btn-large" /></td>
            </tr>
        
        </table>
    </form>
    <a href="minakurser_search.php">Tillbaka</a>

    
    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->
       
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>