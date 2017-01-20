<!--
Author: Jacobi Graziano
Date: 1/20/2017
Purpose: Shipping cost calculator
Related files: main.css
 -->

<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Jacobi Graziano" />
    <meta name="description" content="Shipping Calculator" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    
    <title>Shipping Calculator</title>
    <link rel="stylesheet" href="css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>

<h1>Shipping Calculator</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="shippingInputs">
    <label for="zipCode">Zip Code:</label>
    <input type="text" name="zipCode" maxlength="5" pattern=".{5,}" title="Enter your 5 digit zip code." required autofocus> 
    <br />
    <label for="weight">Weight:</label>
    <input type="number" name="weight" title="Enter the weight of the package." step=".5" required> 
    <br />
    <hr>
    <input type="submit" name="submit" value="Calculate Cost">
</form>

<?php	
	$zone;
	$cost;
	$message;
	$isValid = true;
	
	// Variables from form post
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$zipCode = clean($_POST["zipCode"]);
		$weight = clean($_POST["weight"]);
	}
	
	// Clean data before using
	function clean($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// Set zone based on zipcode provided
	switch ($zipCode) {
		case "55555":
		$zone = 4;
		break;
		
		case "55556":
		$zone = 3;
		break;
		
		case "55557":
		$zone = 9;
		break;
		
		default:
		$zone = 0;
		$isValid = false;
		$message = "Your zipcode is outside of our delivery area.";
		break;
	}
	
	// Set cost based on zone and weight
	switch ($zone) {
		case "3":
			switch ($weight) {
				case "1.0":
				$cost = 1.75;
				break;
				
				case "1.5":
				$cost = 2.25;
				break;
				
				default:
				$isValid = false;
				$message = "Your item is too heavy for delivery to your area.";
				break;
			}
		break;
		
		case "4":
		switch ($weight) {
				case "1.0":
				$cost = 1.25;
				break;
				
				case "1.5":
				$cost = 2.00;
				break;
				
				case "2.0":
				$cost = 3.25;
				break;
				
				default:
				$isValid = false;
				$message = "Your item is too heavy for delivery to your area.";
				break;
			}
		break;
		
		case "9":
		$isValid = false;
		$message = "Your zipcode is not yet in our delivery area. Check back soon!";
		break;
		
		default:	
		break;
	}
	
	// Display cost or error message when form is submitted
	if (isset($_POST["submit"])) {
		if ($isValid){
			$display = sprintf("<h3> The cost to ship to %s is $%.2f.</h3>", $zipCode, $cost);
			echo $display;
		}
		else {
			echo "<h3>" . $message . "</h3>";
		}
	}
?>
</body>
</html>