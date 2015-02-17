<?php
	session_start();
	$_SESSION['msg'] = null;

//MARIES funktioner
    
    function logged_in() {                  //används på alla sidor 
        if(isset($_SESSION['email'])) {
            $output = "Inloggad som: " . $_SESSION['firstname']." ".$_SESSION['lastname']. ", ".$_SESSION['title']. " i klass " .$_SESSION['class'];

        }else{
            header("Location: login.php");
        }
        return $output;
    }


    function show_class($myClass) {         //används på minklass.php
        global $db;  
        try{
            $query = "SELECT * FROM users WHERE class=:class AND title='Student' ORDER BY lastname ASC";

            $ps = $db->prepare($query);
            $result = $ps->execute(
                array(
                'class' => $myClass
                ));

            $row = $ps->fetchAll(PDO::FETCH_ASSOC);
            $output = "<table class='table table-striped table-bordered'>";
            $output .= "<thead>";
            $output .= "<tr><th>Namn</th><th>Email</th><th>Mobil</th><th>Skype</th></tr>";
            $output .= "</head>"; 
            $output .= "<tbody>";
             
        foreach($row as $r){
            $output .= '<tr>';
            $output .= '<td>' . $r['lastname'] .', '. $r['firstname'] .'</td>';
            $output .= '<td>' . $r['email'] .'</td>';
            $output .= '<td>' . $r['mobile'] .'</td>';
            $output .= '<td>' . $r['skype'] .'</td>';
            }
            $output .= '</tr>';
            $output .= "</tbody>";
            $output .= '</table><br />';
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
             
        }
        return $output; 
    }


    function show_all_classes($myClass){    //används på minklass.php
        global $db; 
        try{
            $query = "SELECT * FROM users WHERE class='CBK14' OR class='IPK14' OR class='PTK14' OR class='WUK14' AND title='Student' ORDER BY class, lastname ASC";

            $ps = $db->prepare($query);
            $result = $ps->execute(array());

            $row = $ps->fetchAll(PDO::FETCH_ASSOC);
            $output = "<table class='table table-striped table-bordered'>";
            $output .= "<tr><th>Namn</th><th>Email</th><th>Mobil</th><th>Skype</th><th>Klass</th></tr>";
            
        foreach($row as $r){
            $output .= '<tr>';
            $output .= '<td>' . $r['lastname'] . ', ' . $r['firstname'] . '</td>';
            $output .= '<td>' . $r['email'] . '</td>';
            $output .= '<td>' . $r['mobile'] . '</td>';
            $output .= '<td>' . $r['skype'] . '</td>';
            $output .= '<td>' . $r['class'] . '</td>';
            }
            $output .= '</tr>';
            $output .= '</table><br />';
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
        return $output;
    }

    function show_courses($myClass) {         //används på minakurser.php
        global $db;  
        try{
            $query = "SELECT * FROM courses WHERE class=:class";

            $ps = $db->prepare($query);
            $result = $ps->execute(
                array(
                'class' => $myClass
                ));

            $row = $ps->fetchAll(PDO::FETCH_ASSOC);
            $output = "<table class='table table-striped table-bordered'>";
            $output .= "<thead>";
            $output .= "<tr><th>Kurs</th><th>Status</th><th>Datum</th><th>Poäng</th></tr>";
            $output .= "</head>"; 
            $output .= "<tbody>";
             
        foreach($row as $r){
            $output .= '<tr>';
            $output .= '<td>' . $r['course'] .'</td>';
            $output .= '<td>' . $r['status'] .'</td>';
            $output .= '<td>' . $r['startdate'] .' / '. $r['enddate'] .'</td>';
            $output .= '<td>' . $r['rating'] .'</td>';
            }
            $output .= '</tr>';
            $output .= "</tbody>";
            $output .= '</table><br />';
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
             
        }
        return $output; 
    }

    function show_all_courses($myClass){    //används på minakurser.php
        global $db; 
        try{
            $query = "SELECT * FROM courses WHERE class='CBK14' OR class='IPK14' OR class='PTK14' OR class='WUK14' OR class='Jensen'";

            $ps = $db->prepare($query);
            $result = $ps->execute(array());

            $row = $ps->fetchAll(PDO::FETCH_ASSOC);
            $output = "<table class='table table-striped table-bordered'>";
            $output .= "<tr><th>Klass</th><th>Kurs</th><th>Status</th><th>Datum</th><th>Poäng</th></tr>";
            
        foreach($row as $r){
            $output .= '<tr>';
            $output .= '<td>' . $r['class'] .'</td>';
            $output .= '<td>' . $r['course'] .'</td>';
            $output .= '<td>' . $r['status'] .'</td>';
            $output .= '<td>' . $r['startdate'] .' / '. $r['enddate'] .'</td>';
            $output .= '<td>' . $r['rating'] .'</td>';
            }
            $output .= '</tr>';
            $output .= '</table><br />';
     
        } catch(Exception $exception) {
            echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
        return $output;
    }

//VIVIANAS funktioner

//Meddelanden

//***Add

function add_post(){
    
    $headlineErr = $contentErr = $classErr = '';
    
    if(isset($_POST['submit'])){
        
        global $db;
        $headline = $_POST['headline'];
        $content = $_POST['content'];
        $class = $_POST['class'];
        
        if (empty($_POST["class"])) {
			$classErr = "Klass krävs";
		}
        
        if (empty($headline)) {
			$headlineErr = "Rubrik krävs";
		}
        
        if (empty($content)) {
			$contentErr = "Text krävs";
		}
        
        if(strlen($headline) > 80){
            $headlineErr = "Rubriken får inte vara längre än 80 tecken";
        }
        
        if (empty($classErr) &&  empty($headlineErr) && empty($contentErr)) {
        
            try{    
                $author = $_SESSION['firstname']. " " .$_SESSION['lastname'] . ", ".$_SESSION['title']. " " .$_SESSION['class'];
        
                $query = "INSERT INTO posts (headline, content, class, author) ";
                $query .= "VALUES (:headline, :content, :class, :author)";
        
                $ps = $db->prepare($query);
                $result = $ps->execute(array(
                    'headline' => $headline,
                    'class' => $class,
                    'content' => nl2br($content),
                    'author' => $author
            ));
        
            if($result){
                echo "<i>Nytt inlägg postat</i><br><br>";
            }else{
                echo "Couldn't create new post";
                }
            }catch(Exception $exception){
                echo "Query failed";
                echo $exception;
            }
        }
        
    }
    $errors = array($headlineErr, $contentErr, $classErr);  
    return $errors;
}
        

//***Edit is in meddelande_edit


//***Delete

function delete_post(){
    
    global $db;
    
        if(isset($_POST['delete'])){
        $id = $_POST['id'];
        try{        
        $query = "DELETE FROM posts ";
        $query .= "WHERE id = :id";
        $ps = $db->prepare($query);
        $result = $ps->execute(array(
            'id' => $id));
           

        }catch(Exception $exception){
        echo "Query failed, see error message below: <br /><br />";
            echo $exception. "<br /> <br />";
        }
    
 }
}
    
//***Show list

function show_all_posts($myClass) {    
    
    global $db;
    
    try{
        $id = $headline = $author = $content = $date = $class =''; 
        
        $query = "SELECT * FROM posts WHERE class=:class OR class='Jensen' ";
        $query .= "ORDER BY date DESC";
        
        $ps = $db->prepare($query);
        
        $result = $ps->execute(
            array(
            'class' => $myClass
        ));
        
        $posts = $ps->fetchAll();
        
        $output = "<ul class='news-items'>";
        
        
        $i = 0;
        foreach ($posts as $p){
            
            $id = $p['id'];

            $output .= "<li class='widget-content'>";
            $output .= "<div><p>" . $p['date'] . "</p></div>";
            $output .= "<div>Från: " . $p['author']. "</p></div>";
            $output .= "<div>Till: " . $p['class']. "</p></div>";
            $output .= "<div><h3>" . $p['headline']. "</h3></div>";
            $output .= "<div><p>" . $p['content']. "</p></div>";
            $output .= "</li>";
           
            $i++;
        }
        
        $output .= "</ul>";
        
     }catch(Exception $exception){
        echo "Query failed";
        echo $exception;
    }

    return $output;
}

function show_all_posts_admin() {    
    
    global $db;
    
    try{
        $id = $headline = $author = $content = $date = ''; 
        
        $query = "SELECT * FROM posts ";
        $query .= "ORDER BY date DESC";
        
        $ps = $db->prepare($query);
        
        $result = $ps->execute();
        
        $posts = $ps->fetchAll();
        
        $output = "<ul class='news-items'>";
        
        $i = 0;
        foreach ($posts as $p){
            
            $id = $p['id'];

            $output .= "<li class='widget-content'>";
            $output .= "<form action='meddelanden.php' method='POST'>";
            $output .= "<div><p>" . $p['date'] . "</p></div>";
            $output .= "<div>Från: " . $p['author']. "</p></div>";
            $output .= "<div>Till: " . $p['class']. "</p></div>";
            $output .= "<div><h3>" . $p['headline']. "</h3></div>";
            $output .= "<div><p>" . $p['content']. "</p></div>";
            $output .= "<div><a href='meddelanden_edit.php?id=$id'<p class='button btn btn-success' id='edit'>Ändra</p> </a>";
            $output .= "<input type='submit' value='Radera' class='button btn btn-success btn-medium' name='delete' id='delete'/>";
            $output .= "<input type='hidden' name='id' id='id' value='$id'/></div>";
             $output .= "</form>";
            $output .= "</li>";
           
            $i++;
        }
        
        $output .= "</ul>";
        
     }catch(Exception $exception){
        echo "Query failed";
        echo $exception;
    }

    return $output;
}




//SIBARS funktioner

/*	
	function redirect_to($new_location) { 
		header("Location: " . $new_location);
		exit;
	}
	
	function logged_in() {
		return isset($_SESSION["id"]);
	}
	
	function confirm_logged_in() { 
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
	
	function error_logging($user, $exception){
		$message = date('Y-m-d H:i:s'). "; Username: ". $user . "; errorMsg: " . $exception . "\n";
		$setting = 3;							
		$path = "logs/errors.txt";
			
		error_log($message, $setting, $path);
	}
	
	function find_user_by_name($user){
		global $db;
		
		try{
			$query  = "SELECT * FROM users ";
			$query .= "WHERE username = :user";
						
			$ps = $db->prepare($query);
			$result = $ps->execute([
				'user' => $user
			]);
		} catch (Exception $exception){
			error_logging($user, $exception);
			$_SESSION['msg'] = "Database query failed. Please contact admin";
		}
		return $ps->fetch();
	}
	*/
?>