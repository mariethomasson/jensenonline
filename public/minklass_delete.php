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
            
            <h2>Radera användare</h2>
           <p> <?php echo logged_in();   //if-satsen ersatt av en funktion ?></p>     


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
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    }

    if (isset($_POST['delete'])){
     
            $id = $_POST['id'];    
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $class = $_POST['class'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
    
    try{
        $query = "DELETE FROM users ";
        $query .= "WHERE id = :id";

        $ps = $db->prepare($query); 
        $result = $ps->execute(
            array(
                'id'=>$id 
            ));
        
            if ($result) {
                echo "User deleted";
                header("Location: minklass.php?deleted=true");

        }else {
             echo "Delete failed! <br /><br />";
        }

    } catch(Exception $exception) {
        echo "Query failed, see error message below: <br /><br />";
        echo $exception. "<br /> <br />";
    }
    
}

?>

    <form action="minklass_delete.php" method="POST" >
        <table class="table">
            <tr class= "login-fields">
                <td>Förnamn: </td>
                <td class="field"><input type="text" readonly="" name="firstname"  id="firstname" value="<?php echo $firstname;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Efternamn: </td>
                <td class="field"><input type="text" readonly="" name="lastname" class="login username-field" id="lastname"value="<?php echo $lastname;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Klass: </td>
                <td class="field"><input type="text" name="class"  id="class" value="<?php echo $class;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Email: </td>
                <td class="field"><input type="text" name="email" id="email" value="<?php echo $email;?>" /></td>
            </tr>
            <tr class= "login-fields">
                <td>Mobil: </td>
                <td class="field"><input type="text" name="mobile" id="mobile" value="<?php echo $mobile;?>" /></td>
            </tr>
            <tr>
                <input type='hidden' name='id' value=<?php echo $id;?> />
                <td class="login-actions"><input type="submit" name="delete" value="Radera" class="button btn btn-success btn-large" /></td>
            </tr>
        
        </table>
 
    </form>
<a href="minklass_search.php">Tillbaka</a>
    
    </div> <!-- class content clearfix -->
 </div> <!--class container --> 
</div> <!-- class main-->
       
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>