<?php
    $pageTitle = "Min klass";
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
            $title = $posts['title'];
            $class = $posts['class'];
            $email = $posts['email'];
            $mobile = $posts['mobile'];
            $skype = $posts['skype'];
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }

$firstErr = $lastErr = $emailErr = $classErr = $titleErr = "";
$msg = "";
  
 if(isset($_POST['update'])) {
  
            $id = $_POST['id'];    
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $title = $_POST['title'];
            $class = $_POST['class'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $skype = $_POST['skype'];
     
    if (!preg_match("/^[A-Za-z åäöÅÄÖ ´`-]*$/",$firstname)) {
			$firstErr = "Endast bokstäver tillåts"; 
		}
    if (empty($_POST["firstname"])) {
			$firstErr = "Förnamn krävs";
		}
    if (!preg_match("/^[A-Za-z åäöÅÄÖ ´`-]*$/",$lastname)) {
			$lastErr = "Endast bokstäver tillåts"; 
		}
    if (empty($_POST["lastname"])) {
			$lastErr = "Efternamn krävs";
		}
    if (empty($_POST["title"])) {
			$titleErr = "Titel krävs";
        }
    if (empty($_POST["class"])) {
			$classErr = "Klass krävs";
		}   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Felaktigt e-postformat"; 
		}
     if (empty($_POST["email"])) {
			$emailErr = "E-post krävs";
        }
     
     try{

            $query = "SELECT * ";
            $query .= "FROM users ";
            $query .= "WHERE email = :email ";

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array(
                    'email'=>$email
                ));
            $result = $ps->fetch(PDO::FETCH_ASSOC);

                if($email){	
                    if ($result ['email']== $email) {
                        $_SESSION['email'] = $result['email'];
                        $emailErr = "Denna e-post finns redan, vänligen välj en ny.<br /><br />";
                    } 
                } 
                
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
     
if(empty($firstErr) && empty($lastErr) && empty($titleErr) && empty($classErr) && empty($emailErr))
    
    try{  
            $query = "UPDATE users ";
            $query .= "SET firstname = :firstname, lastname = :lastname, title = :title, class = :class, email = :email, mobile = :mobile, skype = :skype ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'title'=>$title,
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
                <td class="field"><input type="text" name="firstname"  id="firstname" value="<?php echo $firstname;?>" /><span class="error"> * <?php echo $firstErr; ?></span></td>
            </tr>
            <tr>
                <td>Efternamn</td>
                <td class="field"><input type="text" name="lastname" class="login username-field" id="lastname"value="<?php echo $lastname;?>" /><span class="error"> * <?php echo $lastErr; ?></span></td>
            </tr>
            <tr>
                <td>Titel</label></td>
                <td>
                <select name="title" id="title" >
                    <option value="">-- Välj --</option>
                    <option value="Student" <?php echo ($title == "Student") ? "selected" : ""; ?>>Elev</option>
                    <option value="Staff" <?php echo ($title == "Staff") ? "selected" : ""; ?>>Lärare</option>
                    <option value="Admin" <?php echo ($title == "Admin") ? "selected" : ""; ?>>Admin</option>
                </td>
                <td><span class="error"> * <?php echo $titleErr; ?></span></td>
            </tr>
            <tr>
                <td>Klass</td>
                <td>
                <select name="class" id="class">
                    <option value="">-- Välj --</option>
                    <option value="CBK14" <?php echo ($class == "CBK14") ? "selected" : ""; ?>>CBK14</option>
                    <option value="IPK14" <?php echo ($class == "IPK14") ? "selected" : ""; ?>>IPK14</option>
                    <option value="PTK14" <?php echo ($class == "PTK14") ? "selected" : ""; ?>>PTK14</option>
                    <option value="WUK14" <?php echo ($class == "WUK14") ? "selected" : ""; ?>>WUK14</option>
                    <option value="Jensen" <?php echo ($class == "Jensen") ? "selected" : ""; ?>>Jensen</option>
                </td>
                <td><span class="error">* <?php echo $classErr; ?></span></td>
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