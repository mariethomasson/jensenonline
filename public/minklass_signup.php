<?php
    $pageTitle = "Min klass";
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
        <h2>Lägg till användare</h2>
        <p> <?php echo logged_in();   //if-satsen ersatt av en funktion ?></p>
    
    <i>Fält markerade med en <span class="error">*</span> är obligatoriska.</i>

<?php
    $title = $class = $firstname = $lastname = $address = $postnumber = $postaddress = $email = $phone = $mobile = $username = $password = $re_password = "" ;
	$titleErr = $classErr = $firstErr = $lastErr = $emailErr = $userErr = $passErr = $rePassErr = "";
$msg = "";

//Om användaren trycker på "Sign up"-knappen
if(isset($_POST["submit"])){								
	
		$title        = trim($_POST["title"]);
        $class        = trim($_POST["class"]);
        $firstname    = trim($_POST["firstname"]);	
		$lastname     = trim($_POST["lastname"]);
		$address      = trim($_POST["address"]);	
		$postnumber   = trim($_POST["postnumber"]);
        $postaddress  = trim($_POST["postaddress"]);	
		$email 	      = trim($_POST["email"]);
		$phone        = trim($_POST["phone"]);	
		$mobile       = trim($_POST["mobile"]);
        $username     = trim($_POST["username"]);
		$password     = trim($_POST["password"]);
        $re_password  = trim($_POST["re_password"]);
	
		if (empty($_POST["title"])) {
			$titleErr = "Titel krävs";
		}
        if (empty($_POST["class"])) {
			$classErr = "Klass krävs";
		}
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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Felaktigt e-postformat"; 
		}
	    if (empty($_POST["email"])) {
			$emailErr = "E-post krävs";
	    }
        if (!preg_match("/^[A-Za-z0-9]*$/",$username)) {
			$userErr = "Endast bokstäver och siffror tillåts"; 
		}
        if (empty($_POST["username"])) {
			$userErr = "Användarnamn krävs";
	    }
        if (!preg_match("/^[A-Za-z0-9]*$/",$password)) {
			$passErr = "Endast bokstäver och siffror tillåts"; 
		}
	    if (empty($_POST["password"])) {
			$passErr = "Lösenord krävs";
	    }
        if (empty($_POST["re_password"])) {
			$rePassErr = "Upprepa lösenordet";
	    } 
        if($re_password!=$password) {
            $rePassErr = "Lösenorden stämmer inte överens";
        }
    
        try{

            $query = "SELECT * ";
            $query .= "FROM users ";
            $query .= "WHERE email = :email ";
            $query .= "OR username = :username ";

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array(
                    'email'=>$email,
                    'username'=>$username
                ));
            $result = $ps->fetch(PDO::FETCH_ASSOC);

                if($email){	
                    if ($result ['email']== $email) {
                        $_SESSION['email'] = $result['email'];
                        $emailErr = "Denna e-post finns redan, vänligen välj en ny.<br /><br />";
                    } 
                } 
                if($username){	
                    if ($result ['username']== $username) {
                        $_SESSION['username'] = $result['username'];
                        $userErr = "Detta användarnamn finns redan, vänligen välj ett nytt.<br /><br />";
                    } 
                } 
                
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

	    
        if(empty($titleErr) && empty($classErr) && empty($firstErr) && empty($lastErr) && empty($emailErr) && empty($userErr) && empty($passErr) && empty($rePassErr)){
                 
		try{
        require_once("../includes/db_connect.php");
            /*
            //här gör vi hashade passwords
            $options = [
			'cost' => 12,			
            ];

            $hashedPass = password_hash($password, PASSWORD_BCRYPT, $options); 
            //slut hash 
            */
            $query = "INSERT INTO users (title, class, firstname, lastname, address, postnumber, postaddress, email, phone, mobile, username, password) ";
            $query .= "VALUES (:title, :class, :firstname, :lastname, :address, :postnumber, :postaddress, :email, :phone, :mobile, :username, :password) ";

            $ps = $db->prepare($query); //prepared statement
            $result = $ps->execute(array(
                'title'=>$title,
                'class'=>$class,
                'firstname'=>$firstname,
                'lastname'=>$lastname, 
                'address'=>$address,
                'postnumber'=>$postnumber,
                'postaddress'=>$postaddress,
                'email'=>$email, 
                'phone'=>$phone,
                'mobile'=>$mobile,
                'username'=>$username,
                'password'=>$password,//tidigare $hashedPass
            ));

                if ($result) {
                    $_SESSION['msg'] = "<br><i>Ny användare tillagd</i>";
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
<form action="minklass_signup.php" method="POST" >
        <table>
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
                <td>Klass</label></td>
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
                <td>Förnamn </td>
                <td><input type="text" name="firstname" value="<?php echo $firstname; ?>"/><span class="error"> * <?php echo $firstErr; ?></span></td>
            </tr>
            <tr>
                <td>Efternamn </td>
                <td><input type="text" name="lastname" value="<?php echo $lastname; ?>"/><span class="error"> * <?php echo $lastErr; ?></span></td>
            </tr>
            <tr>
                <td>Adress </td>
                <td><input type="text" name="address" value="<?php echo $address; ?>"/></td>
            </tr>
            <tr>
                <td>Postnummer </td>
                <td><input type="text" name="postnumber" value="<?php echo $postnumber; ?>" /></td>
            </tr>
            <tr>
                <td>Postadress </td>
                <td><input type="text" name="postaddress" value="<?php echo $postaddress; ?>" /></td>
            </tr>
            <tr>
                <td>E-post </td>
                <td><input type="email" name="email" value="<?php echo $email; ?>"/><span class="error"> * <?php echo $emailErr; ?></span></td>
            </tr>
            <tr>
                <td>Telefon </td>
                <td><input type="text" name="phone" value="<?php echo $phone; ?>"/></td>
            </tr>
            <tr>
                <td>Mobil </td>
                <td><input type="text" name="mobile" value="<?php echo $mobile; ?>"/></td>
            </tr>
            <tr>
                <td>Användarnamn </td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"/><span class="error"> * <?php echo $userErr; ?></span></td>
            </tr>
            <tr>
                <td>Lösenord </td>
                <td><input type="password" name="password" value="<?php echo $password; ?>" /><span class="error"> * <?php echo $passErr; ?></span></td>
            </tr>
            <tr>
			<td>Upprepa lösenord</td>
			<td><input type="password" name="re_password" /><span class="error"> * <?php echo $rePassErr; ?></span></td>
		</tr>

<?php echo $_SESSION['msg']; ?><br /><br />
            
            <tr>
                <td><input type="submit" name="submit" value="Lägg till" class="button btn btn-success "/></td>
            </tr>
            
        </table>
    </form>            
       <i><a href="minklass.php">Tillbaka till klasslistan</a></i>

    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->

</main>
     
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>