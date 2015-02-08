<?php
    $pageTitle = "Meddelanden";
    $section = "meddelanden";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>


<link href="css/pages/meddelanden.css" rel="stylesheet">

<main> 
<?php
$class = $_SESSION['class'];
$title = $_SESSION['title'];
?>   
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12 headline">
                        <h2>Meddelanden</h2>
                        <?php echo logged_in(); ?>
                  
        </div> <!--span12--> 
      </div> <!--row--> 

      <div class="row">
            <div class="span9">  
                <div class="widget widget-table action-table">
                    <div class="widget-header"> <i class="icon-group"></i>
                    <h3>Meddelanden</h3>
                    </div>
                    <!-- /widget-header -->
                        <div class="widget-content"> 
<?php
    if($title == 'Admin') {
        header("Location: meddelanden_signup.php");
    } else {
        echo show_all_posts();
}

?>
                        </div> <!-- /widget-content --> 
                </div> <!-- /widget -->
            </div> <!-- /span9—>

                </div> <!--row-->
            </div> <!--container-->
        </div> <!--main-inner-->
    </div> <!--main-->
        
<?php delete_post();?> 

</main>
    
<?php
include("layout/footer.php");
?>