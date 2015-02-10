<?php
    $pageTitle = "Sign up";
    $section = "signup";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>


<link href="css/pages/minprofil.css" rel="stylesheet">
    
<main>   
    <div class="main">
    <div class="account-container">
        <div class="content clearfix">
        <h2>Lägg till kurs</h2>
    <i>Fält markerade med en <span class="error">*</span> är obligatoriska.</i>

<?php
    $class = $status = $course = $startdate = $enddate = $rating = "" ;
	$classErr = $statusErr = $courseErr = $startErr = $endErr = $ratingErr = "";
$msg = "";

//Om användaren trycker på "Sign up"-knappen
if(isset($_POST["submit"])){								
	
        $class        = trim($_POST["class"]);
        $status       = trim($_POST["status"]);
        $course       = trim($_POST["course"]);	
		$startdate    = trim($_POST["startdate"]);
		$enddate      = trim($_POST["enddate"]);	
		$rating       = trim($_POST["rating"]);
	
		if (empty($_POST["class"])) {
			$classErr = "Class is required";
		}
        if (empty($_POST["status"])) {
			$statusErr = "Status is required";
		}
        if (empty($_POST["course"])) {
			$courseErr = "Course is required";
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
    
        if(empty($classErr) && empty($statusErr) && empty($courseErr) && empty($startErr) && empty($endErr) && empty($ratingErr)){
                 
		try{
        require_once("../includes/db_connect.php"); 

            $query = "INSERT INTO courses (class, status, course, startdate, enddate, rating) ";
            $query .= "VALUES (:class, :status, :course, :startdate, :enddate, :rating) ";

            $ps = $db->prepare($query); //prepared statement
            $result = $ps->execute(array(
                'class'=>$class,
                'status'=>$status,
                'course'=>$course, 
                'startdate'=>$startdate,
                'enddate'=>$enddate,
                'rating'=>$rating
            ));

                if ($result) {
                    $_SESSION['msg'] = "Signup succeeded";
                //header("Location: login.php");
            }else {
                 $_SESSION['msg'] = "Signup failed";
            }

        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

    //$user = $ps->fetch(PDO::FETCH_ASSOC); //associative array
    //denna ovan failade när jag bytte header mot echo
       }else {
            $username = $password = $hashedPass =  "";
        }

	
	}
        
?>
            
<!-- Formulär --> 
<form action="minakurser_signup.php" method="POST" >
        <table>
            <tr>
                <th><label for="class">Klass: </label></th>
                <td>
                <select name="class" id="class">
                    <option value="">-- Välj --</option>
                    <option value="CBK14">CBK14</option>
                    <option value="IPK14">IPK14</option>
                    <option value="PTK14">PTK14</option>
                    <option value="WUK14">WUK14</option>
                    <option value="Jensen">Jensen</option>
                </td>
                <td><span class="error">* <?php echo $classErr; ?></span></td>
            </tr>
            <tr>
                <th><label for="status">Status: </label></th>
                <td>
                <select name="status" id="status" >
                    <option value="">-- Välj --</option>
                    <option value="Kommande">Kommande</option>
                    <option value="Pågående">Pågående</option>
                    <option value="Avslutad">Avslutad</option>
                </td>
                <td><span class="error"> * <?php echo $statusErr; ?></span></td>
            </tr>
            <tr>
                <td>Kurs </td>
                <td><input type="text" name="course" value="<?php echo $course; ?>"/><span class="error"> * <?php echo $courseErr; ?></span></td>
            </tr>
            <tr>
                <td>Startdatum </td>
                <td><input type="text" name="startdate" value="<?php echo $startdate; ?>"/><span class="error"> * <?php echo $startErr; ?></span></td>
            </tr>
            <tr>
                <td>Slutdatum </td>
                <td><input type="text" name="enddate" value="<?php echo $enddate; ?>" /><span class="error"> * <?php echo $endErr; ?></span></td>
            </tr>
            <tr>
                <td>Poäng </td>
                <td><input type="text" name="rating" value="<?php echo $rating; ?>" /><span class="error"> * <?php echo $ratingErr; ?></span></td>
            </tr>

<?php echo $_SESSION['msg']; ?><br /><br />
            
            <tr>
                <td><input type="submit" name="submit" value="Signup" /></td>
            </tr>
            
        </table>
    </form>            
       <a href="minakurser.php">Tillbaks till kurslistan</a>

    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->

</main>
     
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>