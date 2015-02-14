<?php
    $pageTitle = "Mina kurser";
    $section = "minakurser";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>

<link href="css/pages/minprofil.css" rel="stylesheet">
<main>
    <div class="main">
        <div class="account-container">
            <div class="content clearfix">
            
            <h2>Ändra kurs</h2>
           <p> <?php echo logged_in();   //if-satsen ersatt av en funktion ?></p>
            <i>Fält markerade med en <span class="error">*</span> är obligatoriska.<br><br><br></i>

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

$classErr = $statusErr = $courseErr = $startErr = $endErr = $ratingErr = "";
$msg = "";

 if(isset($_POST['update'])) {
  
            $class = $_POST['class'];
            $course = $_POST['course'];
            $status = $_POST['status'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $rating = $_POST['rating'];
            $id = $_POST['id'];
     
        if (empty($_POST["status"])) {
			$statusErr = "Status is required";
		}
        if (!preg_match("/^[0-9 -]*$/",$startdate)) {
			$startErr = "Only yyyy-mm-dd format is allowed"; 
		}
        if (empty($_POST["startdate"])) {
			$startErr = "Startdate is required";
	    }
        if (!preg_match("/^[0-9 -]*$/",$enddate)) {
			$endErr = "Only yyyy-mm-dd format is allowed"; 
		}
        if (empty($_POST["enddate"])) {
			$endErr = "Enddate is required";
	    }
        /*if (!preg_match("/^[0-9]*$/",$rating)) {
			$ratingErr = "Only numbers is allowed"; 
		}*/
        if (empty($_POST["rating"])) {
			$ratingErr = "Rating is required";
	    } 
if(empty($statusErr) && empty($startErr) && empty($endErr) && empty($ratingErr))

    try{  
            $query = "UPDATE courses ";
            $query .= "SET status = :status, startdate = :startdate, enddate = :enddate, rating = :rating ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'status'=>$status, 
                    'startdate'=>$startdate, 
                    'enddate'=>$enddate,
                    'rating'=>$rating,
                    'id'=>$id
                    ));

                if ($result) {
                 echo "Course updated";
                }else {
                 echo "Failed ";
                }

        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

    }

?>

    <form action="minakurser_edit.php" method="POST" >
        <table>
            <tr>
                <td>Klass</td>
                <td><input type="text" readonly="" name="class"  id="username" value="<?php echo $class;?>" /></td>
            </tr>
            <tr>
                <td>Kurs</td>
                <td><input type="text" readonly="" name="course" class="login username-field" id="username"value="<?php echo $course;?>" /></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><input type="text" name="status"  id="status" value="<?php echo $status;?>" /><span class="error"> * <?php echo $statusErr; ?></span></td>
            </tr>
            <tr>
                <td>Startdatum</td>
                <td><input type="text" name="startdate" id="startdate" value="<?php echo $startdate;?>" /><span class="error"> * <?php echo $startErr; ?></span></td>
            </tr>
            <tr>
                <td>Slutdatum</td>
                <td><input type="text" name="enddate" id="enddate" value="<?php echo $enddate;?>" /><span class="error"> * <?php echo $endErr; ?></span></td>
            </tr>
            <tr>
                <td>Poäng</td>
                <td><input type="text" name="rating" id="rating" value="<?php echo $rating;?>" /><span class="error"> * <?php echo $ratingErr; ?></span></td>
            </tr>
            <tr>
                <input type='hidden' name='id' value=<?php echo $id;?> />
                <td class="login-actions"><input type="submit" name="update" value="Uppdatera" class="button btn btn-success btn-middle" /></td>
            </tr>
        
        </table>

    </form>

<i><a href="minakurser_search.php">Tillbaka</a></i>
    
        </div> <!-- class content clearfix -->
     </div> <!--class container --> 
    </div> <!-- class main-->
</main>
       
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>