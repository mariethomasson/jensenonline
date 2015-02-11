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
                    <td>Headline:</td>
                    <td><input type="text-field" id="headline" name="headline" class='span6' value="<?php echo $headline; ?>"/><span class="error"> * <?php echo $headlineErr; ?></span></td>
                </tr>
                <tr>
                    <th><label for="class">Klass: </label></th>
                    <td>
                    <select name="class" id="class" >
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
                    <td>Content:</td>
                    <td><textarea id="content" name="content" class="form-control span9" rows="20" value="<?php echo $content; ?>"></textarea><span class="error"> * <?php echo $contentErr; ?></span</td>
                </tr>
                <tr>
                    <td><input type="submit" value="Submit" name="submit" class="button btn btn-success btn-large"/></td>
                    <td><input type="reset" value="Reset" name="reset" class="button btn btn-success btn-large" /></td>
	           </tr>
	       </table>
        </form>
    </div> <!--span 9-->
</div> <!--row-->    


    <div class="row">
        <div class="span9">

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