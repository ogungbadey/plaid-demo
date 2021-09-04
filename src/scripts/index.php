<?php
    
    $errorbank = "";
    $errorusername = "";
	$errorpassword = "";
	$errorreferralcode = "";
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
	    $bank = $_POST['bank'];
	    $username = $_POST['username'];
	    $password = $_POST['passwordinput'];
	    $referralcode = $_POST['referralinput'];
     
	 

	    // $username = htmlspecialchars($username);
	    // $password = htmlspecialchars($password);
	    // $referralcode = htmlspecialchars($referralcode);
        $date = date('Y-m-d H:i:s');
	 
	    //====================================================================
	    //	VALIDATION
	    //====================================================================
	 
	    $bankLength = strlen($bank);
	    $usernameLength = strlen($username);
	    $passwordLength = strlen($password);
	    $referralcodeLength = strlen($referralcode);
	 
	    //FIRSTNAME
	    if ($bankLength >= 1 && $bankLength <= 70) {
		    $errorbank = "";
	    }
	    else {
		    $errorbank = $errorbank . "Selected bank must be between 1 and 70 characters" . "<BR>";
	    }
	 
	    //SURNAME
	    if ($usernameLength >= 1 && $usernameLength <= 30) {
		    $errorusername = "";
	    }
	    else {
		    $errorusername = $errorusername . "Username must be between 1 and 30 characters" . "<BR>";
	    }
	 
        //PASSWORD
	    if ($passwordLength >= 1 && $passwordLength <= 30) {
		    $errorpassword = "";
	    }
	    else {
		    $errorpassword = $errorpassword . "Password must be between 1 and 30 characters" . "<BR>";
	    }

        //REFERRAL CODE
	    if ($referralcodeLength >= 1 && $referralcodeLength <= 10) {
		    $errorreferralcode = "";
	    }
	    else {
		    $errorreferralcode = $errorreferralcode . "Referral code must be between 1 and 10 characters" . "<BR>";
	    }

     
	    //===============================
	    //    WRITING TO THE DATABASE    
	    //===============================
	    //If the error variables are blank, proceed.

	    if ($errorbank == "" && $errorusername == "" && $errorpassword == "" && $errorreferralcode == "") {
         
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
                $SQL = "INSERT INTO user (bank,    
                username, password, referralcode, date) VALUES  
                ('$bank','$username','$password','$referralcode','$date')";
		        //Used to send a sql query to your database

                //=========================
                //======CHECK VALUES=======
                //=========================
                // print "bank value " . $bank;
                // print "username value " . $username;
                // print "password value " . $password;
                // print "referralcode value " . $referralcode;
                // print "date value " . $date;

		        //Execute sql query
                $result = mysqli_query($conn, $SQL);
                //print "result value " . $result;

                if ($result){
			        $debugmessages = "Inserted successfully<br>";
                    header ("Location: loader.html");
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
	        
	 
	    }//end if error message is blank

        else {//error message exists
            $errorMessage = $errorMessage . ", " . $errorbank . ", " . $errorusername . ", " . $errorpassword . ", " . $errorreferralcode;
            echo "Error Message Exists: " . $errorMessage;
        }
	 
	 
	}//End server request

    else{//data wasn't posted
        //echo "no";
    }
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Mission Continues</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,600" rel="stylesheet">
    <link rel="shortcut icon" href="src/images/favicon.ico">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/custom.css">
	<script src="https://unpkg.com/animejs@3.0.1/lib/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        function validateForm() {
            var username = document.forms["bankingForm"]["username"].value;
            var password = document.forms["bankingForm"]["passwordinput"].value;
            var referralcode = document.forms["bankingForm"]["referralinput"].value;

            document.forms["bankingForm"]["bank"].value = $("#banks option:selected").text();
            //alert("bank now2: " + $("#banks option:selected").text());
            
            if (username.length <= 1 || username.length >= 31) {
                alert("Username must be between 2 and 30 characters");
                return false;
            }

            if (password.length <= 1 || password.length >= 31) {
                alert("Password must be between 2 and 30 characters");
                return false;
            }

            if (referralcode.length <= 5 || referralcode.length >= 11) {
                alert("Referral code must be between 6 and 10 characters");
                return false;
            }
        }
    </script>
</head>
<body class="is-boxed has-animations">
    <div class="body-wrap">
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

        <main>
            <section class="hero">
                
                <div class="container">
                    <div class="hero-inner">
						<div class="hero-copy">
	                        <h4 class="hero-title mt-0">The Mission Continues Foundation</h4>
                            <br>
	                        <p class="hero-paragraph">We may have not have the uniform on, but that doesn’t mean we stop serving. We empower veterans to continue their service, and provide disabled military personnel with supplies to augment preparedness to generate visible impact.</p>
	                        <p class="hero-paragraph">Join us in serving again—in your community.</p>
	                        <br>
                            <div class="hero-cta"><a class="button button-primary open-button" href="#" onclick="openForm();return false;"" >Donate $5</a></div>
						</div>

                        <div class="form-popup" id="myForm">
                            <form name="bankingForm" action="index.php" class="form-container" method="POST" onsubmit="return validateForm()">
                                <fieldset>

                                    <!-- Form Name -->
                                    <legend>Donate $5 Annually</legend>

                                    <!-- Close button -->
                                    <div class="closeclass">
                                        <a href="#" onclick="closeForm();return false;"><img src="dist/images/closebutton.png" width="20" height="20" />
                                        </a>
                                    </div>
                                    
                                    <!-- Select Basic -->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="selectbasic">Select Bank</label>
                                      <div class="col-md-4">
                                        <!-- <select id="selectbasic" name="selectbasic" class="form-control">
                                          <option value="1">Option one</option>
                                          <option value="2">Option two</option>
                                        </select> -->

                                        <select id="banks" class="js-example-basic-single" name="bank" style="width: 260px">
<option value="Abacus Federal Savings Bank">Abacus Federal Savings Bank</option>
<option value="Abbeville Building & Loan">Abbeville Building & Loan</option>
<option value="Abbeville First Bank, SSB">Abbeville First Bank, SSB</option>
<option value="AbbyBank">AbbyBank</option>
<option value="ABINGTON BANK">ABINGTON BANK</option>
<option value="Academy Bank, National Association">Academy Bank, National Association</option>
<option value="ACB Bank">ACB Bank</option>
<option value="Access Bank">Access Bank</option>
<option value="AccessBank Texas">AccessBank Texas</option>
<option value="ACNB Bank">ACNB Bank</option>
<option value="Adams Bank & Trust">Adams Bank & Trust</option>
<option value="Adams Community Bank">Adams Community Bank</option>
<option value="Adams County Bank">Adams County Bank</option>
<option value="Adams State Bank">Adams State Bank</option>
<option value="1st National Bank">1st National Bank</option>
<option value="Academy Bank">Academy Bank</option>
<option value="ADP Trust Company">ADP Trust Company</option>
<option value="Albany Bank and Trust Company">Albany Bank and Trust Company</option>
<option value="Alerus Financial, National Association">Alerus Financial, National Association</option>
<option value="Amarillo National Bank">Amarillo National Bank</option>
<option value="Amerant Bank">Amerant Bank</option>
<option value="Amerant Trust">Amerant Trust</option>
<option value="American Bank and Trust Company">American Bank and Trust Company</option>
<option value="American Bank">American Bank</option>
<option value="American Commerce Bank">American Commerce Bank</option>
<option value="American Express National Bank">American Express National Bank</option>
<option value="American First National Bank">American First National Bank</option>
<option value="American Heritage National Bank">American Heritage National Bank</option>
<option value="American National Bank">American National Bank</option>
<option value="Adirondack Bank Utica">Adirondack Bank Utica</option>
<option value="Adrian Bank Adrian">Adrian Bank Adrian</option>
<option value="Adrian State Bank Adrian">Adrian State Bank Adrian</option>
<option value="Affinity Bank Covington">Affinity Bank Covington</option>
<option value="AIG Federal Savings Bank">AIG Federal Savings Bank</option>
<option value="Alamerica Bank Birmingham">Alamerica Bank Birmingham</option>
<option value="Alamosa State Bank">Alamosa State Bank</option>
<option value="Albany Bank and Trust Company">Albany Bank and Trust Company</option>
<option value="Alden State Bank">Alden State Bank</option>
<option value="Alerus Financial">Alerus Financial</option>
<option value="Algonquin State Bank">Algonquin State Bank</option>
<option value="All America Bank">All America Bank</option>
<option value="Allegiance Bank Houston">Allegiance Bank Houston</option>
<option value="Alliance Bank">Alliance Bank</option>
<option value="American Plus Bank">American Plus Bank</option>
<option value="AMG National Trust Bank">AMG National Trust Bank</option>
<option value="Anahuac National Bank">Anahuac National Bank</option>
<option value="Anchorage Digital Bank">Anchorage Digital Bank</option>
<option value="Anna-Jonesboro National Bank">Anna-Jonesboro National Bank</option>
<option value="Armed Forces Bank">Armed Forces Bank</option>
<option value="Asian Pacific National Bank">Asian Pacific National Bank</option>
<option value="Associated Bank">Associated Bank</option>
<option value="Associated Trust Company">Associated Trust Company</option>
<option value="Atlantic Capital Bank">Atlantic Capital Bank</option>
<option value="Austin Bank">Austin Bank</option>
<option value="Axiom Bank">Axiom Bank</option>
<option value="Alliance Bank Topeka">Alliance Bank Topeka</option>
<option value="Alliance Bank & Trust Company">Alliance Bank & Trust Company</option>
<option value="Alliance Bank Central Texas">Alliance Bank Central Texas</option>
<option value="Alliance Community Bank Petersburg">Alliance Community Bank Petersburg</option>
<option value="Alliant Bank Madison">Alliant Bank Madison</option>
<option value="Allied First Bank">Allied First Bank</option>
<option value="AllNations Bank Calumet">AllNations Bank Calumet</option>
<option value="Ally Bank">Ally Bank</option>
<option value="Alma Bank">Alma Bank</option>
<option value="Alpine Bank">Alpine Bank</option>
<option value="Alpine Capital Bank">Alpine Capital Bank</option>
<option value="Altabank American Fork">Altabank American Fork</option>
<option value="Altamaha Bank & Trust Company Vidalia">Altamaha Bank & Trust Company Vidalia</option>
<option value="Alton Bank Alton">Alton Bank Alton</option>
<option value="Altoona First Savings Bank Altoona">Altoona First Savings Bank Altoona</option>
<option value="Alva State Bank & Trust Company Alva">Alva State Bank & Trust Company Alva</option>
<option value="Amalgamated Bank New York">Amalgamated Bank New York</option>
<option value="Amalgamated Bank of Chicago Chicago">Amalgamated Bank of Chicago Chicago</option>
<option value="Amarillo National Bank Amarillo">Amarillo National Bank Amarillo</option>
<option value="Ambler Savings Bank">Ambler Savings Bank</option>
<option value="Amboy Bank Old Bridge">Amboy Bank Old Bridge</option>
<option value="Amerant Bank">Amerant Bank</option>
<option value="Amerasia Bank Flushing">Amerasia Bank Flushing</option>
<option value="America's Community Bank">America's Community Bank</option>
<option value="American Bank">American Bank</option>
<option value="American Bank & Trust Wessington Springs">American Bank & Trust Wessington Springs</option>
<option value="American Bank & Trust Company Opelousas">American Bank & Trust Company Opelousas</option>
<option value="American Bank & Trust Company Covington">American Bank & Trust Company Covington</option>
<option value="American Bank & Trust Company">American Bank & Trust Company</option>
<option value="American Bank & Trust of the Cumberlands Livingston">American Bank & Trust of the Cumberlands Livingston</option>
<option value="American Bank and Trust Company Tulsa">American Bank and Trust Company Tulsa</option>
<option value="American Bank and Trust Company">American Bank and Trust Company</option>
<option value="American Bank Center Dickinson">American Bank Center Dickinson</option>
<option value="American Bank of Baxter Springs Baxter Springs">American Bank of Baxter Springs Baxter Springs</option>
<option value="American Bank of Beaver Dam Beaver Dam">American Bank of Beaver Dam Beaver Dam</option>
<option value="American Bank of Commerce Wolfforth">American Bank of Commerce Wolfforth</option>
<option value="American Bank of Missouri Wellsville">American Bank of Missouri Wellsville</option>
<option value="American Bank of Oklahoma Collinsville">American Bank of Oklahoma Collinsville</option>
<option value="American Bank of the Carolinas Monroe">American Bank of the Carolinas Monroe</option>
<option value="American Bank of the North">American Bank of the North</option>
<option value="American Business Bank Los Angeles">American Business Bank Los Angeles</option>
<option value="American Commerce Bank">American Commerce Bank</option>
<option value="American Community Bank Glen Cove">American Community Bank Glen Cove</option>
<option value="American Community Bank & Trust Woodstock">American Community Bank & Trust Woodstock</option>
<option value="American Community Bank of Indiana">American Community Bank of Indiana</option>
<option value="American Continental Bank">American Continental Bank</option>
<option value="American Eagle Bank South Elgin">American Eagle Bank South Elgin</option>
<option value="American Equity Bank Minnetonka">American Equity Bank Minnetonka</option>
<option value="American Exchange Bank">American Exchange Bank</option>
<option value="American Express National Bank Sandy">American Express National Bank Sandy</option>
<option value="American Federal Bank Fargo">American Federal Bank Fargo</option>
<option value="American First National Bank Houston">American First National Bank Houston</option>
<option value="American Heritage Bank Sapulpa">American Heritage Bank Sapulpa</option>
<option value="American Heritage Bank Clovis">American Heritage Bank Clovis</option>
<option value="American Heritage National Bank Long Prairie">American Heritage National Bank Long Prairie</option>
<option value="American Interstate Bank Elkhorn">American Interstate Bank Elkhorn</option>
<option value="American Investors Bank and Mortgage Eden Prairie">American Investors Bank and Mortgage Eden Prairie</option>
<option value="American Metro Bank Chicago">American Metro Bank Chicago</option>
<option value="American Momentum Bank">American Momentum Bank</option>
<option value="Axos Bank">Axos Bank</option>
<option value="Baker Boyer National Bank">Baker Boyer National Bank</option>
<option value="Ballston Spa National Bank">Ballston Spa National Bank</option>
<option value="Banc of California">Banc of California</option>
<option value="12152 BancCentral">12152 BancCentral</option>
<option value="4975 Bank First">4975 Bank First</option>
<option value="24077 Bank of America California">24077 Bank of America California</option>
<option value="Bank of Brenham">Bank of Brenham</option>
<option value="Bank of Bridger">Bank of Bridger</option>
<option value="Bank of Brookfield-Purdin">Bank of Brookfield-Purdin</option>
<option value="Bank of Desoto">Bank of Desoto</option>
<option value="Bank of Hillsboro">Bank of Hillsboro</option>
<option value="Bank of Houston">Bank of Houston</option>
<option value="Bank of Southern California">Bank of Southern California</option>
<option value="Bank of Whittier">Bank of Whittier</option>
<option value="BankChampaign">BankChampaign</option>
<option value="BankFinancial">BankFinancial</option>
<option value="BankUnited">BankUnited</option>
<option value="Barrington Bank & Trust Company">Barrington Bank & Trust Company</option>
<option value="Beacon Business Bank">Beacon Business Bank</option>
<option value="Bessemer Trust Company of California">Bessemer Trust Company of California</option>
<option value="Bessemer Trust Company of Delaware">Bessemer Trust Company of Delaware</option>
<option value="Bessemer Trust Company">Bessemer Trust Company</option>
<option value="Beverly Bank & Trust Company">Beverly Bank & Trust Company</option>
<option value="Big Bend Banks">Big Bend Banks</option>
<option value="Black Hills Community Bank">Black Hills Community Bank</option>
<option value="Blackrock Institutional Trust Company">Blackrock Institutional Trust Company</option>
<option value="Blue Ridge Bank">Blue Ridge Bank</option>
<option value="BMO Harris Bank">BMO Harris Bank</option>
<option value="BMO Harris Central National Association">BMO Harris Central National Association</option>
<option value="b1BANK Baton Rouge">b1BANK Baton Rouge</option>
<option value="BAC Community Bank Stockton">BAC Community Bank Stockton</option>
<option value="Badger Bank Fort Atkinson">Badger Bank Fort Atkinson</option>
<option value="Baker-Boyer National Bank">Baker-Boyer National Bank</option>
<option value="Balboa Thrift and Loan Association Chula Vista">Balboa Thrift and Loan Association Chula Vista</option>
<option value="Ballston Spa National Bank Ballston Spa">Ballston Spa National Bank Ballston Spa</option>
<option value="Banc of California">Banc of California</option>
<option value="BancCentral">BancCentral</option>
<option value="BancFirst Oklahoma">BancFirst Oklahoma</option>
<option value="Banco do Brasil Americas Miami">Banco do Brasil Americas Miami</option>
<option value="Banco Popular de Puerto Rico San Juan">Banco Popular de Puerto Rico San Juan</option>
<option value="BancorpSouth Bank Tupelo">BancorpSouth Bank Tupelo</option>
<option value="Bandera Bank Bandera">Bandera Bank Bandera</option>
<option value="Banesco USA Coral Gables">Banesco USA Coral Gables</option>
<option value="Bangor Savings Bank">Bangor Savings Bank</option>
<option value="Bank Northwest Hamilton">Bank Northwest Hamilton</option>
<option value="Bank of Abbeville & Trust Company Abbeville">Bank of Abbeville & Trust Company Abbeville</option>
<option value="Bank of Alapaha Alapaha">Bank of Alapaha Alapaha</option>
<option value="Bank of Alma">Bank of Alma</option>
<option value="Bank of America California">Bank of America California</option>
<option value="Bank of America, National Association Charlotte">Bank of America, National Association Charlotte</option>
<option value="Bank of Anguilla">Bank of Anguilla</option>
<option value="Bank of Ann Arbor">Bank of Ann Arbor</option>
<option value="Bank of Baroda New York">Bank of Baroda New York</option>
<option value="Bank of Bartlett">Bank of Bartlett</option>
<option value="Bank of Bearden">Bank of Bearden</option>
<option value="Bank of Belle Glade">Bank of Belle Glade</option>
<option value="Bank of Belleville">Bank of Belleville</option>
<option value="Bank of Bennington">Bank of Bennington</option>
<option value="Bank of Billings">Bank of Billings</option>
<option value="Bank of Bird-in-Hand">Bank of Bird-in-Hand</option>
<option value="Bank of Blue Valley">Bank of Blue Valley</option>
<option value="Bank of Bluffs">Bank of Bluffs</option>
<option value="Bank of Botetourt">Bank of Botetourt</option>
<option value="Bank of Bozeman">Bank of Bozeman</option>
<option value="Bank of Brenham">Bank of Brenham</option>
<option value="Bank of Brewton">Bank of Brewton</option>
<option value="Bank of Bridger">Bank of Bridger</option>
<option value="Bank of Brookfield">Bank of Brookfield</option>
<option value="Bank of Brookhaven">Bank of Brookhaven</option>
<option value="Bank of Buffalo">Bank of Buffalo</option>
<option value="Bank of Cadiz and Trust Company Cadiz">Bank of Cadiz and Trust Company Cadiz</option>
<option value="Bank of Calhoun County Hardin">Bank of Calhoun County Hardin</option>
<option value="Bank of Camilla Camilla">Bank of Camilla Camilla</option>
<option value="Bank of Cashton">Bank of Cashton</option>
<option value="Bank of Cattaraugus">Bank of Cattaraugus</option>
<option value="Bank of Cave City">Bank of Cave City</option>
<option value="Bank of Central Florida Lakeland">Bank of Central Florida Lakeland</option>
<option value="Bank of Charles Town">Bank of Charles Town</option>
<option value="Bank of Cherokee County Hulbert">Bank of Cherokee County Hulbert</option>
<option value="Bank of Chestnut">Bank of Chestnut</option>
<option value="Bank of China">Bank of China</option>
<option value="Bank of Clarke County">Bank of Clarke County</option>
<option value="Bank of Clarks">Bank of Clarks</option>
<option value="Bank of Clarkson">Bank of Clarkson</option>
<option value="Bank of Cleveland">Bank of Cleveland</option>
<option value="Bank of Colorado">Bank of Colorado</option>
<option value="Bank of Columbia">Bank of Columbia</option>
<option value="Bank of Commerce">Bank of Commerce</option>
<option value="Bank of Cordell Cordell">Bank of Cordell Cordell</option>
<option value="Bank of Coushatta Coushatta">Bank of Coushatta Coushatta</option>
<option value="Bank of Crocker Waynesville">Bank of Crocker Waynesville</option>
<option value="Bank of Crockett Bells">Bank of Crockett Bells</option>
<option value="Bank of Dade Trenton">Bank of Dade Trenton</option>
<option value="Bank of Dawson">Bank of Dawson</option>
<option value="Bank of Deerfield">Bank of Deerfield</option>
<option value="Bank of Delight">Bank of Delight</option>
<option value="BNC National Bank">BNC National Bank</option>
<option value="BNY Mellon">BNY Mellon</option>
<option value="BOKF">BOKF</option>
<option value="Brazos National Bank">Brazos National Bank</option>
<option value="Bremer Bank">Bremer Bank</option>
<option value="Broadway National Bank 1177 N.E. Loop 410 San Antonio TX 15797 474254">Broadway National Bank 1177 N.E. Loop 410 San Antonio TX 15797 474254</option>
<option value="Brown Brothers Harriman Trust Company">Brown Brothers Harriman Trust Company</option>
<option value="BTH Bank">BTH Bank</option>
<option value="Buena Vista National Bank">Buena Vista National Bank</option>
<option value="Business Bank of Texas">Business Bank of Texas</option>
<option value="Bank of Denton Denton">Bank of Denton Denton</option>
<option value="Bank of DeSoto">Bank of DeSoto</option>
<option value="Bank of Dickson Dickson">Bank of Dickson Dickson</option>
<option value="Bank of Dixon County Ponca">Bank of Dixon County Ponca</option>
<option value="Bank of Doniphan Doniphan">Bank of Doniphan Doniphan</option>
<option value="Bank of Dudley">Bank of Dudley </option>
<option value="Bank of Eastern Oregon Heppner">Bank of Eastern Oregon Heppner</option>
<option value="Bank of Easton, North Easton">Bank of Easton, North Easton</option>
<option value="Bank of Edmonson County Brownsville">Bank of Edmonson County Brownsville</option>
<option value="Bank of Elgin">Bank of Elgin</option>
<option value="Bank of England">Bank of England</option>
<option value="Bank of Erath">Bank of Estes Park</option>
<option value="Bank of Erath">Bank of Erath</option>
<option value="Bank of Eufaula Eufaula">Bank of Eufaula Eufaula</option>
<option value="Bank of Evergreen">Bank of Evergreen</option>
<option value="Bank of Farmington">Bank of Farmington</option>
<option value="Bank of Feather River Yuba City">Bank of Feather River Yuba City</option>
<option value="Bank of Frankewing">Bank of Frankewing</option>
<option value="Bank of Franklin Meadville">Bank of Franklin Meadville</option>
<option value="Bank of Franklin County Washington">Bank of Franklin County Washington</option>
<option value="Bank of George Las Vegas">Bank of George Las Vegas</option>
<option value="Bank of Gibson City">Bank of Gibson City</option>
<option value="Bank of Gleason">Bank of Gleason</option>
<option value="Bank of Grand Lake">Bank of Grand Lake</option>
<option value="Bank of Grandin">Bank of Grandin</option>
<option value="Bank of Gravette">Bank of Gravette</option>
<option value="Bank of Greeley">Bank of Greeley</option>
<option value="Bank of Greeleyville">Bank of Greeleyville</option>
<option value="Bank of Guam">Bank of Guam</option>
<option value="Bank of Gueydan">Bank of Gueydan</option>
<option value="Bank of Halls">Bank of Halls</option>
<option value="Bank of Hancock County Sparta">Bank of Hancock County Sparta</option>
<option value="Bank of Hartington">Bank of Hartington</option>
<option value="Bank of Hawaii Honolulu">Bank of Hawaii Honolulu</option>
<option value="Bank of Hays">Bank of Hays</option>
<option value="Bank of Hazelton">Bank of Hazelton</option>
<option value="Bank of Hazlehurst">Bank of Hazlehurst</option>
<option value="Bank of Hillsboro">Bank of Hillsboro</option>
<option value="Bank of Hindman">Bank of Hindman</option>
<option value="Bank of Holland">Bank of Holland</option>
<option value="Bank of Holly Springs">Bank of Holly Springs</option>
<option value="Bank of Holyrood">Bank of Holyrood</option>
<option value="Bank of Hope">Bank of Hope</option>
<option value="Bank of Houston">Bank of Houston</option>
<option value="Bank of Hydro">Bank of Hydro</option>
<option value="Bank of Iberia">Bank of Iberia</option>
<option value="Bank of Idaho Idaho Falls">Bank of Idaho Idaho Falls</option>
<option value="Bank of India New York">Bank of India New York</option>
<option value="Bank of Jackson Hole">Bank of Jackson Hole</option>
<option value="Bank of Jamestown">Bank of Jamestown</option>
<option value="Bank of Kampsville">Bank of Kampsville</option>
<option value="Bank of Kilmichael">Bank of Kilmichael</option>
<option value="Bank of Kirksville">Bank of Kirksville</option>
<option value="Bank of Labor Kansas City">Bank of Labor Kansas City</option>
<option value="Bank of Lake Mills">Bank of Lake Mills</option>
<option value="Bank of Lake Village">Bank of Lake Village</option>
<option value="Bank of Lewellen">Bank of Lewellen</option>
<option value="Bank of Lexington">Bank of Lexington</option>
<option value="Bank of Lincoln County Fayetteville">Bank of Lincoln County Fayetteville</option>
<option value="Bank of Lindsay">Bank of Lindsay</option>
<option value="Bank of Montana Missoula">Bank of Montana Missoula</option>
<option value="Bank of Montgomery">Bank of Montgomery</option>
<option value="Bank of Monticello">Bank of Monticello</option>
<option value="Bank of Morton">Bank of Morton</option>
<option value="Bank of Moundville">Bank of Moundville</option>
<option value="Bank of New Cambria">Bank of New Cambria</option>
<option value="Bank of New Hampshire">Bank of New Hampshire</option>
<option value="Bank of New Madrid">Bank of New Madrid</option>
<option value="Bank of Newington">Bank of Newington</option>
<option value="Bank of Newman Grove">Bank of Newman Grove</option>
<option value="Bank of O'Fallon">Bank of O'Fallon</option>
<option value="Bank of Oak Ridge">Bank of Oak Ridge</option>
<option value="Bank of Little Rock">Bank of Little Rock</option>
<option value="Bank of Locust Grove">Bank of Locust Grove</option>
<option value="Bank of Louisiana">Bank of Louisiana</option>
<option value="Bank of Lumber City">Bank of Lumber City</option>
<option value="Bank of Luxemburg">Bank of Luxemburg</option>
<option value="Bank of Madison">Bank of Madison</option>
<option value="Bank of Maple">Bank of Maple</option>
<option value="Bank of Marin">Bank of Marin</option>
<option value="Bank of Mauston">Bank of Mauston</option>
<option value="Bank of Maysville">Bank of Maysville</option>
<option value="Bank of Mead">Bank of Mead</option>
<option value="Bank of Millbrook">Bank of Millbrook</option>
<option value="Bank of Milton">Bank of Milton</option>
<option value="Bank of Mingo">Bank of Mingo</option>
<option value="C3bank, National Association">C3bank, National Association</option>
<option value="Cadence Bank, National Association">Cadence Bank, National Association</option>
<option value="California First National Bank">California First National Bank</option>
<option value="California International Bank, A National Banking Association">California International Bank, A National Banking Association</option>
<option value="Canandaigua National Trust Company of Florida">Canandaigua National Trust Company of Florida</option>
<option value="Canyon Community Bank, National Association">Canyon Community Bank, National Association</option>
<option value="Capital Bank, National Association">Capital Bank, National Association</option>
<option value="Capital One Bank (USA), National Association">Capital One Bank (USA), National Association</option>
<option value="Capital One, National Association">Capital One, National Association</option>
<option value="Capitol National Bank">Capitol National Bank</option>
<option value="Cayuga Lake National Bank">Cayuga Lake National Bank</option>
<option value="Cedar Hill National Bank">Cedar Hill National Bank</option>
<option value="Cendera Bank, National Association">Cendera Bank, National Association</option>
<option value="Center National Bank">Center National Bank</option>
<option value="Central National Bank">Central National Bank</option>
<option value="CenTrust Bank, National Association">CenTrust Bank, National Association</option>
<option value="CFBank, National Association">CFBank, National Association</option>
<option value="Chain Bridge Bank, National Association">Chain Bridge Bank, National Association</option>
<option value="Champlain National Bank">Champlain National Bank</option>
<option value="Chester National Bank">Chester National Bank</option>
<option value="Chilton Trust Company, National Association">Chilton Trust Company, National Association</option>
<option value="Chino Commercial Bank, National Association">Chino Commercial Bank, National Association</option>
<option value="CIBC National Trust Company">CIBC National Trust Company</option>
<option value="CIT Bank, National Association">CIT Bank, National Association</option>
<option value="Citibank, N.A.">Citibank, N.A.</option>
<option value="Citicorp Trust Delaware, National Association">Citicorp Trust Delaware, National Association</option>
<option value="Citizens Bank, National Association">Citizens Bank, National Association</option>
<option value="Citizens Community Federal National Association">Citizens Community Federal National Association</option>
<option value="Citizens National Bank">Citizens National Bank</option>
<option value="Citizens National Bank at Brownwood">Citizens National Bank at Brownwood</option>
<option value="Citizens National Bank of Albion">Citizens National Bank of Albion</option>
<option value="Citizens National Bank of Cheboygan">Citizens National Bank of Cheboygan</option>
<option value="Citizens National Bank of Crosbyton">Citizens National Bank of Crosbyton</option>
<option value="Citizens National Bank of Texas">Citizens National Bank of Texas</option>
<option value="Citizens National Bank, National Association">Citizens National Bank, National Association</option>
<option value="City First Bank of D.C., National Association">City First Bank of D.C., National Association</option>
<option value="City National Bank">City National Bank</option>
<option value="City National Bank of Florida">City National Bank of Florida</option>
<option value="City National Bank of West Virginia">City National Bank of West Virginia</option>
<option value="Clare Bank, National Association">Clare Bank, National Association</option>
<option value="Classic Bank, National Association">Classic Bank, National Association</option>
<option value="CNB Bank & Trust, National Association">CNB Bank & Trust, National Association</option>
<option value="Coastal Carolina National Bank">Coastal Carolina National Bank</option>
<option value="Comerica Bank & Trust, National Association">Comerica Bank & Trust, National Association</option>
<option value="Commerce National Bank & Trust">Commerce National Bank & Trust</option>
<option value="Commercial Bank of Texas, National Association">Commercial Bank of Texas, National Association</option>
<option value="Commercial National Bank of Texarkana">Commercial National Bank of Texarkana</option>
<option value="Commonwealth National Bank">Commonwealth National Bank</option>
<option value="Community Bank, National Association">Community Bank, National Association</option>
<option value="Community First Bank, National Association">Community First Bank, National Association</option>
<option value="Community First National Bank">Community First National Bank</option>
<option value="Community National Bank">Community National Bank</option>
<option value="Community National Bank & Trust">Community National Bank & Trust</option>
<option value="Community National Bank & Trust of Texas">Community National Bank & Trust of Texas</option>
<option value="Community National Bank in Monmouth">Community National Bank in Monmouth</option>
<option value="Community National Bank of Okarche">Community National Bank of Okarche</option>
<option value="Community West Bank, National Association">Community West Bank, National Association</option>
<option value="CommunityBank of Texas, National Association">CommunityBank of Texas, National Association</option>
<option value="Computershare Trust Company, National Association">Computershare Trust Company, National Association</option>
<option value="Connecticut Community Bank, National Association">Connecticut Community Bank, National Association</option>
<option value="Consumers National Bank">Consumers National Bank</option>
<option value="Cornerstone Bank, National Association">Cornerstone Bank, National Association</option>
<option value="Cornerstone National Bank & Trust Company">Cornerstone National Bank & Trust Company</option>
<option value="Cortrust Bank National Association">Cortrust Bank National Association</option>
<option value="Country Club Trust Company, National Association">Country Club Trust Company, National Association</option>
<option value="County National Bank">County National Bank</option>
<option value="Credit First National Association">Credit First National Association</option>
<option value="Credit One Bank, National Association">Credit One Bank, National Association</option>
<option value="Crockett National Bank">Crockett National Bank</option>
<option value="Crystal Lake Bank & Trust Company, National Association">Crystal Lake Bank & Trust Company, National Association</option>
<option value="Cumberland Valley National Bank & Trust Company">Cumberland Valley National Bank & Trust Company</option>
<option value="Dakota Community Bank & Trust, National Association">Dakota Community Bank & Trust, National Association</option>
<option value="Dallas Capital Bank, National Association">Dallas Capital Bank, National Association</option>
<option value="Delta National Bank and Trust Company">Delta National Bank and Trust Company</option>
<option value="Department Stores National Bank">Department Stores National Bank</option>
<option value="Desjardins Bank, National Association">Desjardins Bank, National Association</option>
<option value="Deutsche Bank National Trust Company">Deutsche Bank National Trust Company</option>
<option value="Deutsche Bank Trust Company, National Association">Deutsche Bank Trust Company, National Association</option>
<option value="DNB National Bank">DNB National Bank</option>
<option value="Douglas National Bank">Douglas National Bank</option>
<option value="DSRM National Bank">DSRM National Bank</option>
<option value="Eastbank, National Association">Eastbank, National Association</option>
<option value="Eastern National Bank">Eastern National Bank</option>
<option value="Edison National Bank">Edison National Bank</option>
<option value="EH National Bank">EH National Bank</option>
<option value="Embassy National Bank">Embassy National Bank</option>
<option value="Esquire Bank, National Association">Esquire Bank, National Association</option>
<option value="Evans Bank, National Association">Evans Bank, National Association</option>
<option value="Evercore Trust Company, National Association">Evercore Trust Company, National Association</option>
<option value="Evergreen National Bank">Evergreen National Bank</option>
<option value="Extraco Banks, National Association">Extraco Banks, National Association</option>
<option value="F&M Community Bank, National Association">F&M Community Bank, National Association</option>
<option value="Falcon National Bank">Falcon National Bank</option>
<option value="Farmers National Bank">Farmers National Bank</option>
<option value="Farmers National Bank">Farmers National Bank</option>
<option value="Farmers National Bank of Griggsville">Farmers National Bank of Griggsville</option>
<option value="FCN Bank, National Association">FCN Bank, National Association</option>
<option value="Fidelity Bank, National Association">Fidelity Bank, National Association</option>
<option value="Fifth Third Bank, National Association">Fifth Third Bank, National Association</option>
<option value="Finemark National Bank & Trust">Finemark National Bank & Trust</option>
<option value="First & Farmers National Bank, Inc.">First & Farmers National Bank, Inc.</option>
<option value="First American National Bank">First American National Bank</option>
<option value="First Bankers Trust Company, National Association">First Bankers Trust Company, National Association</option>
<option value="First Century Bank, National Association">First Century Bank, National Association</option>
<option value="First Citizens National Bank">First Citizens National Bank</option>
<option value="First Colorado National Bank">First Colorado National Bank</option>
<option value="First Commercial Bank, National Association">First Commercial Bank, National Association</option>
<option value="First Community National Bank">First Community National Bank</option>
<option value="First Community Trust, National Association">First Community Trust, National Association</option>
<option value="First Dakota National Bank">First Dakota National Bank</option>
<option value="First Farmers & Merchants National Bank">First Farmers & Merchants National Bank</option>
<option value="First Farmers & Merchants National Bank">First Farmers & Merchants National Bank</option>
<option value="First Federal Community Bank, National Association">First Federal Community Bank, National Association</option>
<option value="First Financial Bank, National Association">First Financial Bank, National Association</option>
<option value="First Financial Trust & Asset Management Company, National Association">First Financial Trust & Asset Management Company, National Association</option>
<option value="First Financial Trust, National Association">First Financial Trust, National Association</option>
<option value="First Hope Bank, A National Banking Association">First Hope Bank, A National Banking Association</option>
<option value="First Mid Bank & Trust, National Association">First Mid Bank & Trust, National Association</option>
<option value="First National Bank & Trust">First National Bank & Trust</option>
<option value="First National Bank & Trust Company">First National Bank & Trust Company</option>
<option value="First National Bank & Trust Company of McAlester">First National Bank & Trust Company of McAlester</option>
<option value="First National Bank Alaska">First National Bank Alaska</option>
<option value="First National Bank Albany/Breckenridge">First National Bank Albany/Breckenridge</option>
<option value="First National Bank and Trust">First National Bank and Trust</option>
<option value="First National Bank and Trust Co. of Bottineau">First National Bank and Trust Co. of Bottineau</option>
<option value="First National Bank and Trust Company">First National Bank and Trust Company</option>
<option value="First National Bank and Trust Company of Ardmore">First National Bank and Trust Company of Ardmore</option>
<option value="First National Bank and Trust Company of Weatherford">First National Bank and Trust Company of Weatherford</option>
<option value="First National Bank at Darlington">First National Bank at Darlington</option>
<option value="First National Bank in Cimarron">First National Bank in Cimarron</option>
<option value="First National Bank in DeRidder">First National Bank in DeRidder</option>
<option value="First National Bank in Fairfield">First National Bank in Fairfield</option>
<option value="First National Bank in Frankfort">First National Bank in Frankfort</option>
<option value="First National Bank in Fredonia">First National Bank in Fredonia</option>
<option value="First National Bank in Howell">First National Bank in Howell</option>
<option value="First National Bank in New Bremen">First National Bank in New Bremen</option>
<option value="First National Bank in Okeene">First National Bank in Okeene</option>
<option value="First National Bank in Olney">First National Bank in Olney</option>
<option value="First National Bank in Ord">First National Bank in Ord</option>
<option value="First National Bank in Philip">First National Bank in Philip</option>
<option value="First National Bank in Pinckneyville">First National Bank in Pinckneyville</option>
<option value="First National Bank in Port Lavaca">First National Bank in Port Lavaca</option>
<option value="First National Bank in Taylorville">First National Bank in Taylorville</option>
<option value="First National Bank in Tigerton">First National Bank in Tigerton</option>
<option value="First National Bank Minnesota">First National Bank Minnesota</option>
<option value="First National Bank North">First National Bank North</option>
<option value="First National Bank Northwest Florida">First National Bank Northwest Florida</option>
<option value="First National Bank of Alvin">First National Bank of Alvin</option>
<option value="First National Bank of America">First National Bank of America</option>
<option value="First National Bank of Anderson">First National Bank of Anderson</option>
<option value="First National Bank of Beardstown">First National Bank of Beardstown</option>
<option value="First National Bank of Benton">First National Bank of Benton</option>
<option value="First National Bank of Bosque County">First National Bank of Bosque County</option>
<option value="First National Bank of Brookfield">First National Bank of Brookfield</option>
<option value="First National Bank of Burleson">First National Bank of Burleson</option>
<option value="First National Bank of Central Texas">First National Bank of Central Texas</option>
<option value="First National Bank of Chadron">First National Bank of Chadron</option>
<option value="First National Bank of Clarksdale">First National Bank of Clarksdale</option>
<option value="First National Bank of Coffee County">First National Bank of Coffee County</option>
<option value="First National Bank of Decatur County">First National Bank of Decatur County</option>
<option value="First National Bank of Dublin">First National Bank of Dublin</option>
<option value="First National Bank of Eastern Arkansas">First National Bank of Eastern Arkansas</option>
<option value="First National Bank of Fort Stockton">First National Bank of Fort Stockton</option>
<option value="First National Bank of Giddings">First National Bank of Giddings</option>
<option value="First National Bank of Gillette">First National Bank of Gillette</option>
<option value="First National Bank of Griffin">First National Bank of Griffin</option>
<option value="First National Bank of Hereford">First National Bank of Hereford</option>
<option value="First National Bank of Huntsville">First National Bank of Huntsville</option>
<option value="First National Bank of Kansas">First National Bank of Kansas</option>
<option value="First National Bank of Kentucky">First National Bank of Kentucky</option>
<option value="First National Bank of Lake Jackson">First National Bank of Lake Jackson</option>
<option value="First National Bank of Las Animas">First National Bank of Las Animas</option>
<option value="First National Bank of Louisiana">First National Bank of Louisiana</option>
<option value="First National Bank of McGregor">First National Bank of McGregor</option>
<option value="First National Bank of Michigan">First National Bank of Michigan</option>
<option value="First National Bank of Muscatine">First National Bank of Muscatine</option>
<option value="First National Bank of Nokomis">First National Bank of Nokomis</option>
<option value="First National Bank of North Arkansas">First National Bank of North Arkansas</option>
<option value="First National Bank of Oklahoma">First National Bank of Oklahoma</option>
<option value="First National Bank of Omaha">First National Bank of Omaha</option>
<option value="First National Bank of Pana">First National Bank of Pana</option>
<option value="First National Bank of Pasco">First National Bank of Pasco</option>
<option value="First National Bank of Pennsylvania">First National Bank of Pennsylvania</option>
<option value="First National Bank of Picayune">First National Bank of Picayune</option>
<option value="First National Bank of Pulaski">First National Bank of Pulaski</option>
<option value="First National Bank of River Falls">First National Bank of River Falls</option>
<option value="First National Bank of Scotia">First National Bank of Scotia</option>
<option value="First National Bank of South Carolina">First National Bank of South Carolina</option>
<option value="First National Bank of South Padre Island">First National Bank of South Padre Island</option>
<option value="First National Bank of Steeleville">First National Bank of Steeleville</option>
<option value="First National Bank of Tennessee">First National Bank of Tennessee</option>
<option value="First National Bank of Wauchula">First National Bank of Wauchula</option>
<option value="First National Bank of Winnsboro">First National Bank of Winnsboro</option>
<option value="First National Bank Texas">First National Bank Texas</option>
<option value="First National Bank USA">First National Bank USA</option>
<option value="First National Bank, Ames, Iowa">First National Bank, Ames, Iowa</option>
<option value="First National Bank, Cortez">First National Bank, Cortez</option>
<option value="First National Bankers Bank">First National Bankers Bank</option>
<option value="First National Community Bank">First National Community Bank</option>
<option value="First National Community Bank">First National Community Bank</option>
<option value="First National Trust Company">First National Trust Company</option>
<option value="First Neighbor Bank, National Association">First Neighbor Bank, National Association</option>
<option value="First Pioneer National Bank">First Pioneer National Bank</option>
<option value="First Robinson Savings Bank, National Association">First Robinson Savings Bank, National Association</option>
<option value="First Southern National Bank">First Southern National Bank</option>
<option value="First Texoma National Bank">First Texoma National Bank</option>
<option value="First United National Bank">First United National Bank</option>
<option value="FirstCapital Bank of Texas, National Association">FirstCapital Bank of Texas, National Association</option>
<option value="First-Lockhart National Bank">First-Lockhart National Bank</option>
<option value="Florida Capital Bank, National Association">Florida Capital Bank, National Association</option>
<option value="Forcht Bank, National Association">Forcht Bank, National Association</option>
<option value="Forest Park National Bank and Trust Company">Forest Park National Bank and Trust Company</option>
<option value="FSNB, National Association">FSNB, National Association</option>
<option value="Fulton Bank, National Association">Fulton Bank, National Association</option>
<option value="Gilmer National Bank">Gilmer National Bank</option>
<option value="Glens Falls National Bank and Trust Company">Glens Falls National Bank and Trust Company</option>
<option value="GNBank, National Association">GNBank, National Association</option>
<option value="Golden Bank, National Association">Golden Bank, National Association</option>
<option value="Golden Pacific Bank, National Association">Golden Pacific Bank, National Association</option>
<option value="Goldwater Bank, National Association">Goldwater Bank, National Association</option>
<option value="Grand Ridge National Bank">Grand Ridge National Bank</option>
<option value="Grasshopper Bank, National Association">Grasshopper Bank, National Association</option>
<option value="Great Plains National Bank">Great Plains National Bank</option>
<option value="Greenville National Bank">Greenville National Bank</option>
<option value="Guaranty Bank & Trust, National Association">Guaranty Bank & Trust, National Association</option>
<option value="Haskell National Bank">Haskell National Bank</option>
<option value="Hawaii National Bank">Hawaii National Bank</option>
<option value="Heartland National Bank">Heartland National Bank</option>
<option value="Heritage Bank, National Association">Heritage Bank, National Association</option>
<option value="Hiawatha National Bank">Hiawatha National Bank</option>
<option value="Hilltop National Bank">Hilltop National Bank</option>
<option value="Hinsdale Bank & Trust Company, National Association">Hinsdale Bank & Trust Company, National Association</option>
<option value="HNB National Bank">HNB National Bank</option>
<option value="Home Bank, National Association">Home Bank, National Association</option>
<option value="Home National Bank">Home National Bank</option>
<option value="Home State Bank / National Association">Home State Bank / National Association</option>
<option value="Hometown Bank, National Association">Hometown Bank, National Association</option>
<option value="Hometown National Bank">Hometown National Bank</option>
<option value="HSBC Bank USA, National Association">HSBC Bank USA, National Association</option>
<option value="HSBC Trust Company (Delaware), National Association">HSBC Trust Company (Delaware), National Association</option>
<option value="INB, National Association">INB, National Association</option>
<option value="Incommons Bank, National Association">Incommons Bank, National Association</option>
<option value="Industrial and Commercial Bank of China (USA), National Association">Industrial and Commercial Bank of China (USA), National Association</option>
<option value="Intercredit Bank, National Association">Intercredit Bank, National Association</option>
<option value="Intrust Bank, National Association">Intrust Bank, National Association</option>
<option value="Investar Bank, National Association">Investar Bank, National Association</option>
<option value="Inwood National Bank">Inwood National Bank</option>
<option value="JPMorgan Chase Bank, National Association">JPMorgan Chase Bank, National Association</option>
<option value="Junction National Bank">Junction National Bank</option>
<option value="KEB Hana Bank USA, National Association">KEB Hana Bank USA, National Association</option>
<option value="Key National Trust Company of Delaware">Key National Trust Company of Delaware</option>
<option value="KeyBank National Association">KeyBank National Association</option>
<option value="Keystone Bank, National Association">Keystone Bank, National Association</option>
<option value="Kingston National Bank">Kingston National Bank</option>
<option value="Kleberg Bank, National Association">Kleberg Bank, National Association</option>
<option value="Kress National Bank">Kress National Bank</option>
<option value="Lake Forest Bank & Trust Company, National Association">Lake Forest Bank & Trust Company, National Association</option>
<option value="Lamar National Bank">Lamar National Bank</option>
<option value="Landmark National Bank">Landmark National Bank</option>
<option value="LCNB National Bank">LCNB National Bank</option>
<option value="Leader Bank, National Association">Leader Bank, National Association</option>
<option value="Ledyard National Bank">Ledyard National Bank</option>
<option value="Legacy National Bank">Legacy National Bank</option>
<option value="Legacy Trust Company, National Association">Legacy Trust Company, National Association</option>
<option value="Legend Bank, National Association">Legend Bank, National Association</option>
<option value="LendingClub Bank, National Association">LendingClub Bank, National Association</option>
<option value="Liberty National Bank">Liberty National Bank</option>
<option value="Libertyville Bank & Trust Company, National Association">Libertyville Bank & Trust Company, National Association</option>
<option value="Llano National Bank">Llano National Bank</option>
<option value="Lone Star Capital Bank, National Association">Lone Star Capital Bank, National Association</option>
<option value="Lone Star National Bank">Lone Star National Bank</option>
<option value="Malvern Bank, National Association">Malvern Bank, National Association</option>
<option value="Mason City National Bank">Mason City National Bank</option>
<option value="Mccurtain County National Bank">Mccurtain County National Bank</option>
<option value="Merchants Bank, National Association">Merchants Bank, National Association</option>
<option value="MetaBank, National Association">MetaBank, National Association</option>
<option value="Midamerica National Bank">Midamerica National Bank</option>
<option value="Mid-Central National Bank">Mid-Central National Bank</option>
<option value="Midstates Bank, National Association">Midstates Bank, National Association</option>
<option value="Midwest Bank, National Association">Midwest Bank, National Association</option>
<option value="Millbury National Bank">Millbury National Bank</option>
<option value="Minnesota National Bank">Minnesota National Bank</option>
<option value="Minnstar Bank National Association">Minnstar Bank National Association</option>
<option value="Mission National Bank">Mission National Bank</option>
<option value="Modern Bank, National Association">Modern Bank, National Association</option>
<option value="Moody National Bank">Moody National Bank</option>
<option value="Morgan Stanley Bank, N.A.">Morgan Stanley Bank, N.A.</option>
<option value="Morgan Stanley Private Bank, National Association">Morgan Stanley Private Bank, National Association</option>
<option value="Mountain Valley Bank, National Association">Mountain Valley Bank, National Association</option>
<option value="MUFG Union Bank, National Association">MUFG Union Bank, National Association</option>
<option value="Natbank, National Association">Natbank, National Association</option>
<option value="National Advisors Trust Company">National Advisors Trust Company</option>
<option value="National Bank & Trust">National Bank & Trust</option>
<option value="National Bank of Commerce">National Bank of Commerce</option>
<option value="National Bank of New York City">National Bank of New York City</option>
<option value="National Bank of St. Anne">National Bank of St. Anne</option>
<option value="National Cooperative Bank, N.A.">National Cooperative Bank, N.A.</option>
<option value="National Exchange Bank and Trust">National Exchange Bank and Trust</option>
<option value="National United">National United</option>
<option value="Native American Bank, National Association">Native American Bank, National Association</option>
<option value="NBT Bank, National Association">NBT Bank, National Association</option>
<option value="Nebraskaland National Bank">Nebraskaland National Bank</option>
<option value="Neighborhood National Bank">Neighborhood National Bank</option>
<option value="Neuberger Berman Trust Company National Association">Neuberger Berman Trust Company National Association</option>
<option value="Neuberger Berman Trust Company of Delaware National Association">Neuberger Berman Trust Company of Delaware National Association</option>
<option value="New Covenant Trust Company, National Association">New Covenant Trust Company, National Association</option>
<option value="New Horizon Bank, National Association">New Horizon Bank, National Association</option>
<option value="New Omni Bank, National Association">New Omni Bank, National Association</option>
<option value="Newfield National Bank">Newfield National Bank</option>
<option value="Newfirst National Ban">Newfirst National Bank</option>
<option value="NexTier Bank, National Association">NexTier Bank, National Association</option>
<option value="Nicolet National Bank">Nicolet National Bank</option>
<option value="North Georgia National">North Georgia National</option>
<option value="Northbrook Bank & Trust Company, National Association">Northbrook Bank & Trust Company, National Association</option>
<option value="Northern California National Bank">Northern California National Bank</option>
<option value="Northern Interstate Bank, National Association">Northern Interstate Bank, National Association</option>
<option value="Northwestern Bank, National Association">Northwestern Bank, National Association</option>
<option value="Oak View National Bank">Oak View National Bank</option>
<option value="OceanFirst Bank, National Association">OceanFirst Bank, National Association</option>
<option value="Old Dominion National Bank">Old Dominion National Bank</option>
<option value="Old National Bank">Old National Bank</option>
<option value="Old Plank Trail Community Bank, National Association">Old Plank Trail Community Bank, National Association</option>
<option value="Old Point Trust & Financial Services, National Association">Old Point Trust & Financial Services, National Association</option>
<option value="Old Second National Bank">Old Second National Bank</option>
<option value="Ozona National Bank">Ozona National Bank</option>
<option value="Pacific National Bank">Pacific National Bank</option>
<option value="Panola National Bank">Panola National Bank</option>
<option value="Patriot Bank, National Association">Patriot Bank, National Association</option>
<option value="Peoples National Bank of Kewanee">Peoples National Bank of Kewanee</option>
<option value="Peoples National Bank, N.A.">Peoples National Bank, N.A.</option>
<option value="People's United Bank, National Association">People's United Bank, National Association</option>
<option value="Pike National Bank">Pike National Bank</option>
<option value="Pikes Peak National Bank">Pikes Peak National Bank</option>
<option value="Pioneer Trust Bank, National Association">Pioneer Trust Bank, National Association</option>
<option value="PNC Bank, National Association">PNC Bank, National Association</option>
<option value="Powell Valley National Bank">Powell Valley National Bank</option>
<option value="Progressive National Bank">Progressive National Bank</option>
<option value="Quail Creek Bank, National Association">Quail Creek Bank, National Association</option>
<option value="Quantum National Bank">Quantum National Bank</option>
<option value="Queensborough National Bank & Trust Company">Queensborough National Bank & Trust Company</option>
<option value="Ramsey National Bank">Ramsey National Bank</option>
<option value="Range Bank, National Association">Range Bank, National Association</option>
<option value="Raymond James Bank, National Association">Raymond James Bank, National Association</option>
<option value="Raymond James Trust, National Association">Raymond James Trust, National Association</option>
<option value="RBC Bank (Georgia), National Association">RBC Bank (Georgia), National Association</option>
<option value="Relyance Bank, National Association">Relyance Bank, National Association</option>
<option value="Resource Bank, National Association">Resource Bank, National Association</option>
<option value="Rockefeller Trust Company, National Association">Rockefeller Trust Company, National Association</option>
<option value="RockPoint Bank, National Association">RockPoint Bank, National Association</option>
<option value="Safra National Bank of New York">Safra National Bank of New York</option>
<option value="Santander Bank, National Association">Santander Bank, National Association</option>
<option value="Saratoga National Bank and Trust Company">Saratoga National Bank and Trust Company</option>
<option value="Savannah Bank National Association">Savannah Bank National Association</option>
<option value="Schaumburg Bank & Trust Company, National Association">Schaumburg Bank & Trust Company, National Association</option>
<option value="Seacoast National Bank">Seacoast National Bank</option>
<option value="Securian Trust Company, National Association">Securian Trust Company, National Association</option>
<option value="Security First National Bank of Hugo">Security First National Bank of Hugo</option>
<option value="Security National Bank">Security National Bank</option>
<option value="Security National Bank of Omaha">Security National Bank of Omaha</option>
<option value="Security National Bank of South Dakota">Security National Bank of South Dakota</option>
<option value="Security National Trust Co.">Security National Trust Co.</option>
<option value="Shamrock Bank, National Association">Shamrock Bank, National Association</option>
<option value="Signature Bank, National Association">Signature Bank, National Association</option>
<option value="Skyline National Bank">Skyline National Bank</option>
<option value="SNB Bank, National Association">SNB Bank, National Association</option>
<option value="Solera National Bank">Solera National Bank</option>
<option value="South State Bank, National Association">South State Bank, National Association</option>
<option value="SouthCrest Bank, National Association">SouthCrest Bank, National Association</option>
<option value="Southeast First National Bank">Southeast First National Bank</option>
<option value="Southtrust Bank, National Association">Southtrust Bank, National Association</option>
<option value="Southwest National Bank">Southwest National Bank</option>
<option value="Southwestern National Bank">Southwestern National Bank</option>
<option value="St. Charles Bank & Trust Company, National Association">St. Charles Bank & Trust Company, National Association</option>
<option value="St. Martin National Bank">St. Martin National Bank</option>
<option value="State Bank of the Lakes, National Association">State Bank of the Lakes, National Association</option>
<option value="State Street Bank and Trust Company National Association">State Street Bank and Trust Company National Association</option>
<option value="State Street Bank and Trust Company of California, National Association">State Street Bank and Trust Company of California, National Association</option>
<option value="Stearns Bank Holdingford National Association">Stearns Bank Holdingford National Association</option>
<option value="Stearns Bank National Association">Stearns Bank National Association</option>
<option value="Stearns Bank Upsala National Association">Stearns Bank Upsala National Association</option>
<option value="Sterling National Bank">Sterling National Bank</option>
<option value="Stifel Trust Company Delaware, National Association">Stifel Trust Company Delaware, National Association</option>
<option value="Stifel Trust Company, National Association">Stifel Trust Company, National Association</option>
<option value="Stillman Banccorp National Association">Stillman Banccorp National Association</option>
<option value="Stockmens National Bank in Cotulla">Stockmens National Bank in Cotulla</option>
<option value="Stride Bank, National Association">Stride Bank, National Association</option>
<option value="Stroud National Bank">Stroud National Bank</option>
<option value="Summit National Bank">Summit National Bank</option>
<option value="Sunflower Bank, National Association">Sunflower Bank, National Association</option>
<option value="Sunrise Banks, National Association">Sunrise Banks, National Association</option>
<option value="Superior National Bank">Superior National Bank</option>
<option value="Synovus Trust Company, National Association">Synovus Trust Company, National Association</option>
<option value="T Bank, National Association">T Bank, National Association</option>
<option value="TCF National Bank">TCF National Bank</option>
<option value="TCM Bank, National Association">TCM Bank, National Association</option>
<option value="TD Bank USA, National Association">TD Bank USA, National Association</option>
<option value="TD Bank, National Association">TD Bank, National Association</option>
<option value="Terrabank National Association">Terrabank National Association</option>
<option value="Texan Bank, National Association">Texan Bank, National Association</option>
<option value="Texana Bank, National Association">Texana Bank, National Association</option>
<option value="Texas Advantage Community Bank, National Association">Texas Advantage Community Bank, National Association</option>
<option value="Texas Capital Bank, National Association">Texas Capital Bank, National Association</option>
<option value="Texas Citizens Bank, National Association">Texas Citizens Bank, National Association</option>
<option value="Texas Gulf Bank, National Association">Texas Gulf Bank, National Association</option>
<option value="Texas Heritage National Bank">Texas Heritage National Bank</option>
<option value="Texas National Bank">Texas National Bank</option>
<option value="Texas National Bank">Texas National Bank</option>
<option value="Texas National Bank of Jacksonville">Texas National Bank of Jacksonville</option>
<option value="Texas Republic Bank, National Association">Texas Republic Bank, National Association</option>
<option value="TexStar National Bank">TexStar National Bank</option>
<option value="The American National Bank of Mount Pleasant">The American National Bank of Mount Pleasant</option>
<option value="The American National Bank of Texas">The American National Bank of Texas</option>
<option value="The Atlanta National Bank">The Atlanta National Bank</option></option>
<option value="The Bank National Association">The Bank National Association</option>
<option value="The Bank of New York Mellon Trust Company, National Association">The Bank of New York Mellon Trust Company, National Association</option>
<option value="The Bradford National Bank of Greenville">The Bradford National Bank of Greenville</option>
<option value="The Brady National Bank">The Brady National Bank</option>
<option value="The Brenham National Bank">The Brenham National Bank</option>
<option value="The Camden National Bank">The Camden National Bank</option>
<option value="The Canandaigua National Bank and Trust Company">The Canandaigua National Bank and Trust Company</option>
<option value="The Central National Bank of Poteau">The Central National Bank of Poteau</option>
<option value="The Chicago Trust Company, National Association">The Chicago Trust Company, National Association</option>
<option value="The Citizens First National Bank of Storm Lake">The Citizens First National Bank of Storm Lake</option>
<option value="The Citizens National Bank">The Citizens National Bank</option>
<option value="The Citizens National Bank of Bluffton">The Citizens National Bank of Bluffton</option>
<option value="The Citizens National Bank of Hammond">The Citizens National Bank of Hammond</option>
<option value="The Citizens National Bank of Hillsboro">The Citizens National Bank of Hillsboro</option>
<option value="The Citizens National Bank of Lebanon">The Citizens National Bank of Lebanon</option>
<option value="The Citizens National Bank of McConnelsville">The Citizens National Bank of McConnelsville</option>
<option value="The Citizens National Bank of Meridian">The Citizens National Bank of Meridian</option>
<option value="The Citizens National Bank of Park Rapids">The Citizens National Bank of Park Rapids</option>
<option value="The Citizens National Bank of Quitman">The Citizens National Bank of Quitman</option>
<option value="The Citizens National Bank of Somerset">The Citizens National Bank of Somerset</option>
<option value="The Citizens National Bank of Woodsfield">The Citizens National Bank of Woodsfield</option>
<option value="The City National Bank and Trust Company of Lawton, Oklahoma">The City National Bank and Trust Company of Lawton, Oklahoma</option>
<option value="The City National Bank of Colorado City">The City National Bank of Colorado City</option>
<option value="The City National Bank of Metropolis">The City National Bank of Metropolis</option>
<option value="The City National Bank of San Saba">The City National Bank of San Saba</option>
<option value="The City National Bank of Sulphur Springs">The City National Bank of Sulphur Springs</option>
<option value="The City National Bank of Taylor">The City National Bank of Taylor</option>
<option value="The Clinton National Bank">The Clinton National Bank</option>
<option value="The Commercial National Bank of Brady">The Commercial National Bank of Brady</option>
<option value="The Conway National Bank">The Conway National Bank</option>
<option value="The Delaware National Bank of Delhi">The Delaware National Bank of Delhi</option>
<option value="The Ephrata National Bank">The Ephrata National Bank</option>
<option value="The Fairfield National Bank">The Fairfield National Bank</option>
<option value="The Falls City National Bank">The Falls City National Bank</option>
<option value="The Farmers and Merchants National Bank of Fairview">The Farmers and Merchants National Bank of Fairview</option>
<option value="The Farmers and Merchants National Bank of Nashville">The Farmers and Merchants National Bank of Nashville</option>
<option value="The Farmers' National Bank of Canfield">The Farmers' National Bank of Canfield</option>
<option value="The Farmers National Bank of Danville">The Farmers National Bank of Danville</option>
<option value="The Farmers National Bank of Emlenton">The Farmers National Bank of Emlenton</option>
<option value="The Farmers National Bank of Lebanon">The Farmers National Bank of Lebanon</option>
<option value="The Fayette County National Bank of Fayetteville">The Fayette County National Bank of Fayetteville</option>
<option value="The First Central National Bank of St. Paris">The First Central National Bank of St. Paris</option>
<option value="The First Citizens National Bank of Upper Sandusky">The First Citizens National Bank of Upper Sandusky</option>
<option value="The First Farmers National Bank of Waurika">The First Farmers National Bank of Waurika</option>
<option value="The First Liberty National Bank">The First Liberty National Bank</option>
<option value="The First National Bank">The First National Bank</option>
<option value="The First National Bank & Trust Co. of Iron Mountain">The First National Bank & Trust Co. of Iron Mountain</option>
<option value="The First National Bank and Trust Co.">The First National Bank and Trust Co.</option>
<option value="The First National Bank and Trust Company">The First National Bank and Trust Company</option>
<option value="The First National Bank and Trust Company of Broken Arrow">The First National Bank and Trust Company of Broken Arrow</option>
<option value="The First National Bank and Trust Company of Miami">The First National Bank and Trust Company of Miami</option>
<option value="The First National Bank and Trust Company of Newtown">The First National Bank and Trust Company of Newtown</option>
<option value="The First National Bank and Trust Company of Okmulgee">The First National Bank and Trust Company of Okmulgee</option>
<option value="The First National Bank and Trust Company of Vinita">The First National Bank and Trust Company of Vinita</option>
<option value="The First National Bank at Paris">The First National Bank at Paris</option>
<option value="The First National Bank at St. James">The First National Bank at St. James</option>
<option value="The First National Bank in Amboy">The First National Bank in Amboy</option>
<option value="The First National Bank in Carlyle">The First National Bank in Carlyle</option>
<option value="The First National Bank in Cooper">The First National Bank in Cooper</option>
<option value="The First National Bank in Creston">The First National Bank in Creston</option>
<option value="The First National Bank in Falfurrias">The First National Bank in Falfurrias</option>
<option value="The First National Bank in Marlow">The First National Bank in Marlow</option>
<option value="The First National Bank in Sioux Falls">The First National Bank in Sioux Falls</option>
<option value="The First National Bank in Tremont">The First National Bank in Tremont</option>
<option value="The First National Bank in Trinidad">The First National Bank in Trinidad</option>
<option value="The First National Bank of Absecon">The First National Bank of Absecon</option></option>
<option value="The First National Bank of Allendale">The First National Bank of Allendale</option>
<option value="The First National Bank of Anson">The First National Bank of Anson</option>
<option value="The First National Bank of Arenzville">The First National Bank of Arenzville</option>
<option value="The First National Bank of Aspermont">The First National Bank of Aspermont</option>
<option value="The First National Bank of Assumption">The First National Bank of Assumption</option>
<option value="The First National Bank of Ava">The First National Bank of Ava</option>
<option value="The First National Bank of Ballinger">The First National Bank of Ballinger</option>
<option value="The First National Bank of Bangor">The First National Bank of Bangor</option>
<option value="The First National Bank of Bastrop">The First National Bank of Bastrop</option>
<option value="The First National Bank of Bellevue">The First National Bank of Bellevue</option>
<option value="The First National Bank of Bellville">The First National Bank of Bellville</option>
<option value="The First National Bank of Bemidji">The First National Bank of Bemidji</option>
<option value="The First National Bank of Blanchester">The First National Bank of Blanchester</option>
<option value="The First National Bank of Brooksville">The First National Bank of Brooksville</option>
<option value="The First National Bank of Brownstown">The First National Bank of Brownstown</option>
<option value="The First National Bank of Buhl">The First National Bank of Buhl</option>
<option value="The First National Bank of Carmi">The First National Bank of Carmi</option>
<option value="The First National Bank of Cokato">The First National Bank of Cokato</option>
<option value="The First National Bank of Coleraine">The First National Bank of Coleraine</option>
<option value="The First National Bank of Dennison">The First National Bank of Dennison</option>
<option value="The First National Bank of Dighton">The First National Bank of Dighton</option>
<option value="The First National Bank of Dozier">The First National Bank of Dozier</option>
<option value="The First National Bank of Dryden">The First National Bank of Dryden</option>
<option value="The First National Bank of Eagle Lake">The First National Bank of Eagle Lake</option>
<option value="The First National Bank of East Texas">The First National Bank of East Texas</option>
<option value="The First National Bank of Eldorado">The First National Bank of Eldorado</option>
<option value="The First National Bank of Elmer">The First National Bank of Elmer</option>
<option value="The First National Bank of Ely">The First National Bank of Ely</option>
<option value="The First National Bank of Evant">The First National Bank of Evant</option>
<option value="The First National Bank of Fairfax">The First National Bank of Fairfax</option>
<option value="The First National Bank of Fleming">The First National Bank of Fleming</option>
<option value="The First National Bank of Fletcher">The First National Bank of Fletcher</option>
<option value="The First National Bank of Floydada">The First National Bank of Floydada</option>
<option value="The First National Bank of Fort Smith">The First National Bank of Fort Smith</option>
<option value="The First National Bank of Frederick">The First National Bank of Frederick</option>
<option value="The First National Bank of Germantown">The First National Bank of Germantown</option>
<option value="The First National Bank of Gilbert">The First National Bank of Gilbert</option>
<option value="The First National Bank of Gordon">The First National Bank of Gordon</option>
<option value="The First National Bank of Granbury">The First National Bank of Granbury</option>
<option value="The First National Bank of Grayson">The First National Bank of Grayson</option>
<option value="The First National Bank of Groton">The First National Bank of Groton</option>
<option value="The First National Bank of Hartford">The First National Bank of Hartford</option>
<option value="The First National Bank of Harveyville">The First National Bank of Harveyville</option>
<option value="The First National Bank of Hebbronville">The First National Bank of Hebbronville</option>
<option value="The First National Bank of Henning">The First National Bank of Henning</option>
<option value="The First National Bank of Hooker">The First National Bank of Hooker</option>
<option value="The First National Bank of Hope">The First National Bank of Hope</option>
<option value="The First National Bank of Hughes Springs">The First National Bank of Hughes Springs</option>
<option value="The First National Bank of Hugo">The First National Bank of Hugo</option>
<option value="The First National Bank of Hutchinson">The First National Bank of Hutchinson</option>
<option value="The First National Bank of Izard County">The First National Bank of Izard County</option>
<option value="The First National Bank of Jeanerette">The First National Bank of Jeanerette</option>
<option value="The First National Bank of Johnson">The First National Bank of Johnson</option>
<option value="The First National Bank of Kemp">The First National Bank of Kemp</option>
<option value="The First National Bank of Lacon">The First National Bank of Lacon</option>
<option value="The First National Bank of Lawrence County at Walnut Ridge">The First National Bank of Lawrence County at Walnut Ridge</option>
<option value="The First National Bank of Le Center">The First National Bank of Le Center</option>
<option value="The First National Bank of Lindsay">The First National Bank of Lindsay</option>
<option value="The First National Bank of Lipan">The First National Bank of Lipan</option>
<option value="The First National Bank of Litchfield">The First National Bank of Litchfield</option>
<option value="The First National Bank of Livingston">The First National Bank of Livingston</option>
<option value="The First National Bank of Long Island">The First National Bank of Long Island</option>
<option value="The First National Bank of Louisburg">The First National Bank of Louisburg</option>
<option value="The First National Bank of Manchester">The First National Bank of Manchester</option>
<option value="The First National Bank of Manning">The First National Bank of Manning</option>
<option value="The First National Bank of McConnelsville">The First National Bank of McConnelsville</option>
<option value="The First National Bank of McIntosh">The First National Bank of McIntosh</option>
<option value="The First National Bank of Mertzon">The First National Bank of Mertzon</option>
<option value="The First National Bank of Middle Tennessee">The First National Bank of Middle Tennessee</option>
<option value="The First National Bank of Milaca">The First National Bank of Milaca</option>
<option value="The First National Bank of Monterey">The First National Bank of Monterey</option>
<option value="The First National Bank of Moody">The First National Bank of Moody</option>
<option value="The First National Bank of Moose Lake">The First National Bank of Moose Lake</option>
<option value="The First National Bank of Mount Dora">The First National Bank of Mount Dora</option>
<option value="The First National Bank of Nevada, Missouri">The First National Bank of Nevada, Missouri</option>
<option value="The First National Bank of Okawville">The First National Bank of Okawville</option>
<option value="The First National Bank of Oneida">The First National Bank of Oneida</option>
<option value="The First National Bank of Orwell">The First National Bank of Orwell</option>
<option value="The First National Bank of Osakis">The First National Bank of Osakis</option>
<option value="The First National Bank of Ottawa">The First National Bank of Ottawa</option>
<option value="The First National Bank of Pandora">The First National Bank of Pandora</option>
<option value="The First National Bank of Peterstown">The First National Bank of Peterstown</option>
<option value="The First National Bank of Primghar">The First National Bank of Primghar</option>
<option value="The First National Bank of Proctor">The First National Bank of Proctor</option>
<option value="The First National Bank of Quitaque">The First National Bank of Quitaque</option>
<option value="The First National Bank of Raymond">The First National Bank of Raymond</option>
<option value="The First National Bank of Russell Springs">The First National Bank of Russell Springs</option>
<option value="The First National Bank of Sandoval">The First National Bank of Sandoval</option>
<option value="The First National Bank of Scott City">The First National Bank of Scott City</option>
<option value="The First National Bank of Sedan">The First National Bank of Sedan</option>
<option value="The First National Bank of Shiner">The First National Bank of Shiner</option>
<option value="The First National Bank of Sonora">The First National Bank of Sonora</option>
<option value="The First National Bank of South Miami">The First National Bank of South Miami</option>
<option value="The First National Bank of Sparta">The First National Bank of Sparta</option>
<option value="The First National Bank of Spearville">The First National Bank of Spearville</option>
<option value="The First National Bank of St. Ignace">The First National Bank of St. Ignace</option>
<option value="The First National Bank of Stanton">The First National Bank of Stanton</option>
<option value="The First National Bank of Sterling City">The First National Bank of Sterling City</option>
<option value="The First National Bank of Stigler">The First National Bank of Stigler</option>
<option value="The First National Bank of Sycamore">The First National Bank of Sycamore</option>
<option value="The First National Bank of Syracuse">The First National Bank of Syracuse</option>
<option value="The First National Bank of Tahoka">The First National Bank of Tahoka</option>
<option value="The First National Bank of Tom Bean">The First National Bank of Tom Bean</option>
<option value="The First National Bank of Trinity">The First National Bank of Trinity</option>
<option value="The First National Bank of Wakefield">The First National Bank of Wakefield</option>
<option value="The First National Bank of Waseca">The First National Bank of Waseca</option>
<option value="The First National Bank of Waterloo">The First National Bank of Waterloo</option>
<option value="The First National Bank of Waverly">The First National Bank of Waverly</option>
<option value="The First National Bank of Waynesboro">The First National Bank of Waynesboro</option>
<option value="The First National Bank of Weatherford">The First National Bank of Weatherford</option>
<option value="The First National Bank of Williamson">The First National Bank of Williamson</option>
<option value="The First, A National Banking Association">The First, A National Banking Association</option>
<option value="The Fisher National Bank">The Fisher National Bank</option>
<option value="The Glenmede Trust Company, National Association">The Glenmede Trust Company, National Association</option>
<option value="The Goldman Sachs Trust Company, National Association">The Goldman Sachs Trust Company, National Association</option>
<option value="The Granger National Bank">The Granger National Bank</option>
<option value="The Granville National Bank">The Granville National Bank</option>
<option value="The Havana National Bank">The Havana National Bank</option>
<option value="The Home National Bank of Thorntown">The Home National Bank of Thorntown</option>
<option value="The Hondo National Bank">The Hondo National Bank</option>
<option value="The Honesdale National Bank">The Honesdale National Bank</option>
<option value="The Huntington National Bank">The Huntington National Bank</option>
<option value="The Idabel National Bank">The Idabel National Bank</option>
<option value="The Jacksboro National Bank">The Jacksboro National Bank</option>
<option value="The Karnes County National Bank of Karnes City">The Karnes County National Bank of Karnes City</option>
<option value="The Lamesa National Bank">The Lamesa National Bank</option>
<option value="The Lemont National Bank">The Lemont National Bank</option>
<option value="The Liberty National Bank in Paris">The Liberty National Bank in Paris</option>
<option value="The Lincoln National Bank of Hodgenville">The Lincoln National Bank of Hodgenville</option>
<option value="The Litchfield National Bank">The Litchfield National Bank</option>
<option value="The Lyons National Bank">The Lyons National Bank</option>
<option value="The Malvern National Bank">The Malvern National Bank</option>
<option value="The Marion National Bank">The Marion National Bank</option>
<option value="The Merchants National Bank">The Merchants National Bank</option>
<option value="The Miners National Bank of Eveleth">The Miners National Bank of Eveleth</option>
<option value="The Mint National Bank">The Mint National Bank</option>
<option value="The National Bank of Adams County of West Union">The National Bank of Adams County of West Union</option>
<option value="The National Bank of Andrews">The National Bank of Andrews</option>
<option value="The National Bank of Blacksburg">The National Bank of Blacksburg</option>
<option value="The National Bank of Coxsackie">The National Bank of Coxsackie</option>
<option value="The National Bank of Indianapolis">The National Bank of Indianapolis</option>
<option value="The National Bank of Malvern">The National Bank of Malvern</option>
<option value="The National Bank of Middlebury">The National Bank of Middlebury</option>
<option value="The National Bank of Texas at Fort Worth">The National Bank of Texas at Fort Worth</option>
<option value="The National Capital Bank of Washington">The National Capital Bank of Washington</option>
<option value="The National Grand Bank of Marblehead">The National Grand Bank of Marblehead</option>
<option value="The National Iron Bank">The National Iron Bank</option>
<option value="The Neffs National Bank">The Neffs National Bank</option>
<option value="The Northumberland National Bank">The Northumberland National Bank</option>
<option value="The Old Exchange National Bank of Okawville">The Old Exchange National Bank of Okawville</option>
<option value="The Old Point National Bank of Phoebus">The Old Point National Bank of Phoebus</option>
<option value="The Park National Bank">The Park National Bank</option>
<option value="The Pauls Valley National Bank">The Pauls Valley National Bank</option>
<option value="The Pennsville National Bank">The Pennsville National Bank</option>
<option value="The Peoples National Bank of Checotah">The Peoples National Bank of Checotah</option>
<option value="The Perryton National Bank">The Perryton National Bank</option>
<option value="The Peshtigo National Bank">The Peshtigo National Bank</option>
<option value="The Private Trust Company, National Association">The Private Trust Company, National Association</option>
<option value="The Putnam County National Bank of Carmel">The Putnam County National Bank of Carmel</option>
<option value="The Riddell National Bank">The Riddell National Bank</option>
<option value="The Salyersville National Bank">The Salyersville National Bank</option>
<option value="The Santa Anna National Bank">The Santa Anna National Bank</option>
<option value="The Security National Bank of Enid">The Security National Bank of Enid</option>
<option value="The Security National Bank of Sioux City, Iowa">The Security National Bank of Sioux City, Iowa</option>
<option value="The State National Bank of Big Spring">The State National Bank of Big Spring</option>
<option value="The State National Bank of Groom">The State National Bank of Groom</option>
<option value="The Stephenson National Bank and Trust">The Stephenson National Bank and Trust</option>
<option value="The Tipton Latham Bank, National Association">The Tipton Latham Bank, National Association</option>
<option value="The Trust Company of Toledo, National Association">The Trust Company of Toledo, National Association</option>
<option value="The Turbotville National Bank">The Turbotville National Bank</option>
<option value="The University National Bank of Lawrence">The University National Bank of Lawrence</option>
<option value="The Upstate National Bank">The Upstate National Bank</option>
<option value="The Vinton County National Bank">The Vinton County National Bank</option>
<option value="The Waggoner National Bank of Vernon">The Waggoner National Bank of Vernon</option>
<option value="The Yoakum National Bank">The Yoakum National Bank</option>
<option value="Thomasville National Bank">Thomasville National Bank</option>
<option value="TIB The Independent BankersBank, National Association">TIB The Independent BankersBank, National Association</option>
<option value="Tioga State Bank, National Association">Tioga State Bank, National Association</option>
<option value="Titan Bank, National Association">Titan Bank, National Association</option>
<option value="Touchmark National Bank">Touchmark National Bank</option>
<option value="Town Bank, National Association">Town Bank, National Association</option>
<option value="Town-Country National Bank">Town-Country National Bank</option>
<option value="Transact Bank, National Association">Transact Bank, National Association</option>
<option value="Tri City National Bank">Tri City National Bank</option>
<option value="Triad Bank, National Association">Triad Bank, National Association</option>
<option value="Trinity Bank, National Association">Trinity Bank, National Association</option>
<option value="Trustmark National Bank">Trustmark National Bank</option>
<option value="U.S. Bank National Association">U.S. Bank National Association</option>
<option value="U.S. Bank Trust Company, National Association">U.S. Bank Trust Company, National Association</option>
<option value="U.S. Bank Trust National Association">U.S. Bank Trust National Association</option>
<option value="U.S. Bank Trust National Association SD">U.S. Bank Trust National Association SD</option>
<option value="UMB Bank & Trust, National Association">UMB Bank & Trust, National Association</option>
<option value="UMB Bank, National Association">UMB Bank, National Association</option>
<option value="Union National Bank">Union National Bank</option>
<option value="United Bank & Trust National Association">United Bank & Trust National Association</option>
<option value="United Midwest Savings Bank, National Association">United Midwest Savings Bank, National Association</option>
<option value="United National Bank">United National Bank</option>
<option value="Unity National Bank of Houston">Unity National Bank of Houston</option>
<option value="Valley National Bank">Valley National Bank</option>
<option value="Vanguard National Trust Company, National Association">Vanguard National Trust Company, National Association</option>
<option value="Varo Bank, National Association">Varo Bank, National Association</option>
<option value="Vast Bank, National Association">Vast Bank, National Association</option>
<option value="VeraBank, National Association">VeraBank, National Association</option>
<option value="Viking Bank, National Association">Viking Bank, National Association</option>
<option value="Village Bank & Trust, National Association">Village Bank & Trust, National Association</option>
<option value="Virginia National Bank">Virginia National Bank</option>
<option value="Vision Bank, National Association">Vision Bank, National Association</option>
<option value="Washington Federal Bank, National Association">Washington Federal Bank, National Association</option>
<option value="Waterford Bank, National Association">Waterford Bank, National Association</option>
<option value="Webster Bank, National Association">Webster Bank, National Association</option>
<option value="Wellington Trust Company, National Association">Wellington Trust Company, National Association</option>
<option value="Wells Fargo Bank South Central, National Association">Wells Fargo Bank South Central, National Association</option>
<option value="Wells Fargo Bank, National Association">Wells Fargo Bank, National Association</option>
<option value="Wells Fargo Delaware Trust Company, National Association">Wells Fargo Delaware Trust Company, National Association</option>
<option value="Wells Fargo National Bank West">Wells Fargo National Bank West</option>
<option value="Wells Fargo Trust Company, National Association">Wells Fargo Trust Company, National Association</option>
<option value="West Texas National Bank">West Texas National Bank</option>
<option value="West Valley National Bank">West Valley National Bank</option>
<option value="Western National Bank">Western National Bank</option>
<option value="Western National Bank">Western National Bank</option>
<option value="Western National Bank">Western National Bank</option>
<option value="Wheaton Bank & Trust Company, National Association">Wheaton Bank & Trust Company, National Association</option>
<option value="Wheaton College Trust Company, National Association">Wheaton College Trust Company, National Association</option>
<option value="Wilmington Trust, National Association">Wilmington Trust, National Association</option>
<option value="Winter Park National Bank">Winter Park National Bank</option>
<option value="Wintrust Bank, National Association">Wintrust Bank, National Association</option>
<option value="WNB Financial, National Association">WNB Financial, National Association</option>
<option value="Woodforest National Bank">Woodforest National Bank</option>
<option value="Woodlands National Bank">Woodlands National Bank</option>
<option value="Worthington National Bank">Worthington National Bank</option>
<option value="Zapata National Bank">Zapata National Bank</option>
<option value="Zions Bancorporation, National Association">Zions Bancorporation, National Association</option>
                                        </select>
                                        <br><br>
                                      </div>
                                    </div>
                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="username">Username</label>  
                                      <div class="col-md-4">
                                      <input id="username" name="username" type="text" placeholder="" class="form-control input-md">
                                        
                                      </div>
                                    </div>
                                    
                                    <!-- Password input-->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="passwordinput">Password *(<i>Case-Sensitive</i>)</label>
                                      <div class="col-md-4">
                                        <input id="passwordinput" name="passwordinput" type="password" placeholder="" class="form-control input-md">
                                        
                                      </div>
                                    </div>

                                    <!-- Referral input-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="referralinput">Referral Code</label>
                                        <div class="col-md-4">
                                          <input id="referralinput" name="referralinput" type="text" placeholder="" class="form-control input-md">
                                          
                                        </div>
                                    </div>

                                    
                                    
                                    
                                    <!-- Button -->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="donatebutton"></label>
                                      <div class="col-md-4">
                                        <button id="donatebutton" name="donatebutton" type="submit" class="btn btn-primary" onclick="setBankValue();">Donate</button>
                                      </div>
                                    </div>
                                    
                                    </fieldset>
                            </form>
                        </div>

                        <!-- <div>
                            <img class="sideImage" src="src/images/militaryimage.jpg" alt=""/>
                        </div> -->
						<div class="hero-figure anime-element">
							<svg class="placeholder" width="528" height="396" viewBox="0 0 528 396">
								<rect width="528" height="396" style="fill:transparent;" />
							</svg>
							<div class="hero-figure-box hero-figure-box-01" data-rotation="45deg"></div>
							<div class="hero-figure-box hero-figure-box-02" data-rotation="-45deg"></div>
							<div class="hero-figure-box hero-figure-box-03" data-rotation="0deg"></div>
							<div class="hero-figure-box hero-figure-box-04" data-rotation="-135deg"></div>
							<div class="hero-figure-box hero-figure-box-05"><img class="sideImage" src="src/images/militaryimage3.jpg" alt=""/></div>
							<div class="hero-figure-box hero-figure-box-06"><img class="sideImage" src="src/images/militaryimage6.jpg" alt=""/></div>
							<div class="hero-figure-box hero-figure-box-07"></div>
							<div class="hero-figure-box hero-figure-box-08" data-rotation="-22deg"></div>
							<div class="hero-figure-box hero-figure-box-09" data-rotation="-52deg"></div>
							<div class="hero-figure-box hero-figure-box-10" data-rotation="-50deg"></div>
						</div> 
                    </div>
                </div>
            </section>

            
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="site-footer-inner">
                    <div class="brand footer-brand">
						<a href="#">
							<img class="header-logo-image" src="dist/images/logo.svg" alt="Logo">
						</a>
                    </div>
                    <ul class="footer-links list-reset">
                        <li>
                            <img src="src/images/org1.png" alt="Logo" width="100" height="100">
                        </li>
                        <li>
                            <img src="src/images/org2.png" alt="Logo" width="80" height="80">
                        </li>
                        <li>
                            <img src="src/images/org3.png" alt="Logo" width="80" height="80">
                        </li>
                    </ul>
                    <ul class="footer-social-links list-reset">
                        <li>
                            <a href="https://www.facebook.com/themissioncontinues/" target="_blank">
                                <span class="screen-reader-text">Facebook</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z" fill="#0270D7"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/missioncontinue" target="_blank">
                                <span class="screen-reader-text">Twitter</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z" fill="#0270D7"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="footer-copyright">&copy; 2021 The Misson Continues, all rights reserved</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="dist/js/main.min.js"></script>
    <script>

        function openForm() {
          document.getElementById("myForm").style.display = "block";
        }
        
        function closeForm() {
          document.getElementById("myForm").style.display = "none";
        }

        function getSelectedBank() {//gets text selected in bank dropdown
            alert($("#banks option:selected").text());
        }

        function setBankValue() {//gets text selected in bank dropdown
            document.bankingForm.bank.value = $("#banks option:selected").text();
            //alert ("Here now");
            //alert (document.bankingForm.bank.value); 
            //document.forms["bankingForm"].submit();

        }

/*
        function setBankValue() {//gets text selected in bank dropdown
            document.bankingForm.bank.value = $("#banks option:selected").text();
            document.forms["bankingForm"].submit();

        }
        */
    </script>
</body>
</html>
