<?php
    $pageTitle = "Klasslista";
    $section = "minklass";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>

<link href="css/pages/minprofil.css" rel="stylesheet">

    <div class="main">
    <div class="account-container">
        <div class="content clearfix">
            
            <h2>Ändra användare</h2>
           <p> <?php echo logged_in();   //if-satsen ersatt av en funktion ?></p>
            <i>Fält markerade med en <span class="error">*</span> är obligatoriska.<br><br></i>

<?php

    if(isset($_GET['id'])) {
        
    try{
            $query = "SELECT * FROM users WHERE id = :id";

            $ps = $db->prepare($query);
            $result = $ps->execute(
                array(
                    'id'=>$_GET['id']
            ));

            $posts = $ps->fetch(PDO::FETCH_ASSOC); 
        
            $id = $posts['id'];    
            $lastname = $posts['lastname'];
            $firstname = $posts['firstname'];
            $class = $posts['class'];
            $email = $posts['email'];
            $mobile = $posts['mobile'];
            $skype = $posts['skype'];
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }

$emailErr = $classErr = "";
$msg = "";
  
 if(isset($_POST['update'])) {
  
            $id = $_POST['id'];    
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $class = $_POST['class'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $skype = $_POST['skype'];
     
     if (empty($_POST["class"])) {
			$classErr = "Klass krävs";
		}   
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Felaktigt e-postformat"; 
		}
	    if (empty($_POST["email"])) {
			$emailErr = "E-post krävs";
        }
     
if(empty($classErr) && empty($emailErr))
    
    try{  
            $query = "UPDATE users ";
            $query .= "SET class = :class, email = :email, mobile = :mobile, skype = :skype ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'class'=>$class, 
                    'email'=>$email, 
                    'mobile'=>$mobile,
                    'skype'=>$skype,
                    'id'=>$id
                    ));

                if ($result) {
                 echo "<i>Användare uppdaterad</i><br><br>";
                }else {
                 echo "Failed ";
                }

        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

    }

?>

    <form action="minklass_edit.php" method="POST" >
        <table>
            <tr>
                <td>Förnamn</td>
                <td class="field"><input type="text" readonly="" name="firstname"  id="firstname" value="<?php echo $firstname;?>" /></td>
            </tr>
            <tr>
                <td>Efternamn</td>
                <td class="field"><input type="text" readonly="" name="lastname" class="login username-field" id="lastname"value="<?php echo $lastname;?>" /></td>
            </tr>
            <tr>
                <td>Klass</td>
                <td class="field"><input type="text" name="class"  id="class" value="<?php echo $class;?>" /><span class="error"> * <?php echo $classErr; ?></td>
            </tr>
            <tr>
                <td>E-post</td>
                <td class="field"><input type="text" name="email" id="email" value="<?php echo $email;?>" /><span class="error"> * <?php echo $emailErr; ?></span></td>
            </tr>
            <tr>
                <td>Mobil</td>
                <td class="field"><input type="text" name="mobile" id="mobile" value="<?php echo $mobile;?>" /></td>
            </tr>
            <tr>
                <td>Skype</td>
                <td class="field"><input type="text" name="skype" id="skype" value="<?php echo $skype;?>" /></td>
            </tr>
            <tr>
                <input type='hidden' name='id' value=<?php echo $id;?> />
                <td class="login-actions"><input type="submit" name="update" value="Uppdatera" class="button btn btn-success " /></td>
            </tr>
        
        </table>

    </form>
<i><a href="minklass_search.php">Tillbaka</a></i>
    
    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->
       
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>