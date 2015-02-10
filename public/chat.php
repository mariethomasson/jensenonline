<?php
    $pageTitle = "Chat";
    $section = "chat";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>

<link href="css/pages/chat.css" rel="stylesheet">

<main> 
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <h2>Chat</h2>
                        <?php echo logged_in(); ?>
                    </div> <!--span12-->
                </div> <!--row-->
            </div> <!--container-->
        </div> <!--main-inner-->
    </div> <!--main-->
    
        

</main>
    
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>