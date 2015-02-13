<?php
    $pageTitle = "Meddelanden";
    $section = "meddelanden";
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
                        <h2>Meddelanden</h2>
                        <?php echo logged_in(); ?>
                    </div> <!--span12-->
                </div> <!--row-->
                <i>Fält markerade med en * är obligatoriska.</i>
                <br><br>


<?php 
$errors = add_post();
$headlineErr = $errors[0];
$contentErr = $errors[1];
$classErr = $errors[2];
$headline = $content = $class = '';
?>
               
<div class="row">
    <div class="span9">
        <form action="meddelanden_signup.php" method="POST">
            <table>
                <tr>
                    <td><h3>Klass:</h3><span class="error"> * <?php echo $classErr; ?></span></td>
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
                    <td><h3>Rubrik:</h3></td>
                </tr>
                <tr>
                    <td><span class="error"> * <?php echo $headlineErr; ?></span><input type="text" id="headline" name="headline" class="span6" size="100" value="<?php echo $headline; ?>"/></td>
                </tr>

                <tr>
                    <td><h3>Text:</h3></td>
                </tr>
                <tr>
                    <td><span class="error"> * <?php echo $contentErr; ?></span><textarea id="content" name="content" class="form-control span9" rows="10" value="<?php echo $content; ?>"></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Posta inlägg" name="submit" class="button btn btn-success btn-large"/></td>
	           </tr>
	       </table>
        </form>
    </div> <!--span 9-->
</div> <!--row-->    


    <div class="row">
        <div class="span9" class="mit_mess">

                <?php echo show_all_posts_admin();?>           

        </div> <!--container-->
    </div> <!--main-inner-->
</div> <!--main-->
        
<?php delete_post();?> 

</main>
    
<?php
include("layout/footer.php");
?>
            
<script src="js/analyticstracking.js"></script>