<?php
    $pageTitle = "Min profil";
    $section = "profil";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>

<link href="css/pages/minprofil.css" rel="stylesheet">

    <div class="main">
    <div class="account-container">
        <div class="content clearfix">
            <h2>Min profil</h2>
    
           <h4>Här kan du ändra dina uppgifter</h4>
            <i>Fält markerade med en <span class="error">*</span> är obligatoriska.</i>

<?php
//php for the first form, updating profile.
$title = $class = $firstname = $lastname = $address = $postnumber = $postaddress = $email = $phone = $mobile = $username = $password = $re_password = "" ;
	$titleErr = $classErr = $firstErr = $lastErr = $emailErr = $userErr = $passErr = $rePassErr = "";
$msg = "";

    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $address = $_SESSION['address'];
    $postnumber = $_SESSION['postnumber'];
    $postaddress = $_SESSION['postaddress'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $mobile = $_SESSION['mobile'];
    $skype = $_SESSION['skype'];


    if(isset($_POST["update"])) {

        $address      = trim($_POST['address']);
        $postnumber   = trim($_POST['postnumber']);
        $postaddress  = trim($_POST['postaddress']);
        $email        = trim($_POST['email']);
        $phone        = trim($_POST['phone']);
        $mobile       = trim($_POST['mobile']);
        $skype        = trim($_POST['skype']);
        
        if (empty($_POST["email"])) {
			$emailErr = "Email is required";
	    }

    try{
        require_once("../includes/db_connect.php"); 
            $query = "UPDATE users ";
            $query .= "SET address = :address, postnumber = :postnumber, postaddress = :postaddress, email = :email, phone = :phone, mobile = :mobile, skype = :skype ";
            $query .= "WHERE id = :id"; 

            $ps = $db->prepare($query); 
            $result = $ps->execute(
                array (
                    'address'=>$address,
                    'postnumber'=>$postnumber, 
                    'postaddress'=>$postaddress,
                    'email'=>$email,
                    'phone'=>$phone,
                    'mobile'=>$mobile,
                    'skype'=>$skype,
                    'id'=>$_SESSION['id']
                    ));

                if ($result) {
                 echo "User updated";
                }else {
                 echo "Failed ";
                }

        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }

    }
?>
            
<!------START uploading an image, the full Sibar php-----> 
            
<?php 
	//checking if the form has been submitted 
	if( isset($_POST['upload']) ){
		//display $_FILES content
		echo "<pre>";
		//print_r($_FILES);
		echo "</pre>";
		/*array
		Array
			(
				[upfile] => Array
					(
						[name] => ruler.jpg
						[type] => image/jpeg
						[tmp_name] => C:\xampp\tmp\phpD9CE.tmp
						[error] => 0
						[size] => 106131
					)
			)
		*/
		  if( is_uploaded_file($_FILES['upfile']['tmp_name']) ){
                //storing file data into variables
		
                $fileName = $_FILES['upfile']['name'];           		        //this is the actual name of the file   		           
                $fileTempName = $_FILES['upfile']['tmp_name'];					//this is the temporary name of the file     
				$fileSize =  $_FILES['upfile']['size']; 						//this is the filesize
                $path = "/Applications/XAMPP/htdocs/jensen/GIT/my_jensenonline/public/uploads/";												//this is the path where you want to save the actual file 
                $newPathAndName = $path . $fileName;		//uploads/ruler.jpg					//this is the actual path and actual name of the file
				
				//you can use move_uploaded_file() to move and rename the temp file
                if( move_uploaded_file($fileTempName, $newPathAndName)  ){
                    echo "The file has been successfully uploaded<br /><br />";
					/*
					$myFile = $newPathAndName;
					$fh = fopen($myFile, 'r');
					$theData = fread($fh, $fileSize);
					fclose($fh);
					echo $theData;*/
					
                } else {
                    echo "Could not upload the file";
                }//end if move_uploaded_file
				
            }//end if is_uploaded_file
    }//end if isset upload

?>
<!------END uploading an image, the full Sibar php----->    
    
    <form action="profile.php" method="POST" >
        <table>
            <tr>
                <td>Förnamn: </td>
                <td class="field"><input type="text" readonly="" name="firstname"  id="username" value="<?php echo $firstname;?>" /></td>
            </tr>
            <tr>
                <td>Efternamn: </td>
                <td class="field"><input type="text" readonly="" name="lastname" class="login username-field" id="username"value="<?php echo $lastname;?>" /></td>
            </tr>
            <tr>
                <td>Adress: </td>
                <td class="field"><input type="text" name="address"  id="username" value="<?php echo $address;?>" /></td>
            </tr>
            <tr>
                <td>Postnummer: </td>
                <td class="field"><input type="text" name="postnumber" id="username" value="<?php echo $postnumber;?>" /></td>
            </tr>
            <tr>
                <td>Postadress: </td>
                <td class="field"><input type="text" name="postaddress" id="username" value="<?php echo $postaddress;?>" /></td>
            </tr>
            <tr>
                <td>E-post: </td>
                <td><input type="email" name="email" id="username" value="<?php echo $email;?>" /><span class="error"> * <?php echo $emailErr; ?></span></td>
            </tr>
            <tr>
                <td>Telefon: </td>
                <td class="field"><input type="text" name="phone" id="username"value="<?php echo $phone;?>" /></td>
            </tr>
            <tr>
                <td>Mobil: </td>
                <td class="field"><input type="text" name="mobile" id="username" value="<?php echo $mobile;?>" /></td>
            </tr>
            <tr>
                <td>Skype: </td>
                <td class="field"><input type="text" name="skype" id="username" value="<?php echo $skype;?>" /></td>
            </tr>
            <tr>
                
                <td class="login-actions"><input type="submit" name="update" value="Uppdatera" class="button btn btn-success btn-large" /></td>
            </tr>
        
        </table>
  
        
    </form> 
<!-- Vet inte om uppladdning av bild kan ligga i uppdateringsformuläret så gör en separat för nu -->            
    <h2>Lägg upp en bild</h2>
    <i>Storlek max 30kB och endast jpg eller gif.</i>
    <form action="profile.php" method="POST" enctype="multipart/form-data">
        
        
        <table>
            
            <tr>
                    <td class="bild">Bild:</td>
                    <td><input type="file" name="upfile" value=""/></td>
            </tr>
        
            
            <tr>
            <td><input type="submit" name="upload" value="Ladda upp" class="button btn btn-success"/></td>
            </tr>
            
        </table>
        
     </form>
<br />
<br />
        
    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->
       
<?php
include("layout/footer.php");
?>