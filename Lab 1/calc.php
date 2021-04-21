<?php
  $result;
  if ( !isset($_POST["operation"]) || empty($_POST["operation"]) 
  || !isset($_POST["number_1"]) || (empty($_POST["number_1"]) && $_POST["number_1"] != "0") 
  || !isset($_POST["number_2"]) || (empty($_POST["number_2"]) && $_POST["number_2"] != "0")){
  	$result = "Data no entered";
  }
  else {
    $argument_1 = $_POST["number_1"];
  	$argument_2 = $_POST["number_2"];
	if (!is_numeric($_POST["number_1"]) || !is_numeric($_POST["number_2"])) 
	{
		$result = "Numbers must be entered in the fields.";
	
	} 
	else 
	{
		$operation = $_POST["operation"];
  	    switch ($operation) {
			case '+':
				$result = $argument_1 + $argument_2;  
				break;
			case '-':
  	 	    	$result = $argument_1 - $argument_2;  
  	 			break;
  	 		case '*':
  	 	    	$result = $argument_1 * $argument_2;  
  	 			break;
  	 		case '/':
  	 	    	if ($argument_2 == 0){
  	 	    		$result = "cannot be divisible by 0";
  	        	}    
  	 	    	else 
				{
  	 	    		$result = $argument_1 / $argument_2;  
  	 				break;
  	 			}	
  		}
	}
 }
?>

<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css" type="text/css" />
  <title>Lab 1 - calculate</title>
 </head>
 <body>

 <form action="calc.php" method="POST" class="calc-form">
     <input type="text" name="number_1" value=<?=isset($_POST['number_1']) ? $_POST['number_1'] : ''?>>

	 <?php if ($_SERVER["REQUEST_METHOD"] == "POST") $operation = $_POST['operation'] ?>
     <select name="operation">
  	     <option value="+" <?php if ($operation == "+") echo "selected"; ?> > + </option>
  	     <option value="-" <?php if ($operation == "-") echo "selected"; ?> > - </option>
		 <option value="*" <?php if ($operation == "*") echo "selected"; ?> > * </option>
		 <option value="/" <?php if ($operation == "/") echo "selected"; ?> > / </option>
     </select>

     <input type="text" name="number_2" value=<?=isset($_POST['number_2']) ? $_POST['number_2'] : ''?> >
     <input type="submit" value="=">
     <span><?php echo $result; ?></span>
 </form>

 </body>
</html>


