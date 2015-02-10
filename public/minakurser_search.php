<?php
    $pageTitle = "Search Course";
    $section = "search";
?>

<?php require_once("../includes/db_connect.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php include("layout/header.php"); ?>


<link href="css/pages/minprofil.css" rel="stylesheet">
    
<main> 
    
<?php
$class = $_SESSION['class'];
?>
    
<div class="main">
  <div class="main-inner">
    <div class="container">
        <div class="row">
            <div class="span12 headline"> 
                <h1>Redigera kurs</h1>
                <?php echo logged_in(); //if-satsen ersatt av en funktion ?>  
                <form action="minakurser_search.php" method="POST">
                    <input type="text" name="search_string">
                    <input type="submit" name="searchBtn" value="Sök">
                </form>
            </div> <!--span12--> 
        </div> <!--row-->            
            
<div class="row">
    <div class="span9">
        <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-group"></i>
                <h3>Kurslista <?php echo $class ?></h3>
            </div> <!-- /widget-header -->
                <div class="widget-content">
                            
<?php 
		if(isset($_POST['searchBtn'])){
			try{
				$query  = "SELECT * FROM courses WHERE course LIKE :course";			
				$ps = $db->prepare($query); //Prepared statement
						
				$result = $ps->execute(array(
					'course' => "%{$_POST['search_string']}%",
				)); 
				$users = $ps->fetchAll();
						
			} catch(Exception $exception) {
				echo "Query failed, see error message below: <br /><br />";
				echo $exception. "<br /><br />";
			}
		} else {
		
			try{
				$query  = "SELECT * FROM courses";			
				$ps = $db->prepare($query); //Prepared statement
						
				$result = $ps->execute(); // Erhåller värdet true eller false. arrayen i execute() är tilldelade värden för placeholders i SQL -> :username AND :password
				$users = $ps->fetchAll();
						
			} catch(Exception $exception) {
				echo "Query failed, see error message below: <br /><br />";
				echo $exception. "<br /><br />";
			}
		}
?>
	<table class='table table-striped table-bordered'>
		<thead>
			<th>Klass</th>
			<th>Kurs</th>
			<th>Status</th>
            <th>Start</th>
            <th>Slut</th>
            <th>Poäng</th>
            <th>Action</th>
		</thead>
		
<?php 
    
		foreach($users as $user){
			echo "<tr>";
			echo "<td>". $user['class']. "</td><td>" .$user['course'] . "</td><td>" .$user['status'] . "</td><td>". $user['startdate']. "</td><td>". $user['enddate']. "</td><td>". $user['rating']. "</td><td><a href='minakurser_edit.php?id=" .$user['id']. "'>Edit /</a><a href='minakurser_delete.php?id=" .$user['id']. "'> Delete</a></td>";

			echo "</tr>";
		}
?>
        
	</table>
                    </div> <!-- /widget-content --> 
                </div> <!-- /widget -->
            </div><!-- /span9-->
       </div><!-- /row -->       
    </div> <!-- /container --> 
  </div> <!-- /main-inner --> 
</div> <!-- /main --> 

</main>
     
<?php
include("layout/footer.php");
?>

<script src="js/analyticstracking.js"></script>