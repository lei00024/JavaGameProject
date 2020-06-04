<?php require_once('dao/customerDAO.php'); 
		require_once('dao/abstractDAO.php');?>
<!DOCTYPE html>
<html>
<?php include 'header.php' ?>

<?php
try{
            $customerDAO = new customerDAO();
			$abstractDAO = new abstractDAO();
            $hasError = false;
            $errorMessages = Array();

            if(isset($_POST['customerName']) ||
                isset($_POST['phoneNumber']) || 
                isset($_POST['emailAddress'])||
				isset($_POST['referrer'])){
            
                //We know they are set, so let's check for values
                if($_POST['customerName'] == ""){
                    $errorMessages['customerNameError'] = "Please enter a name.";
                    $hasError = true;
                }

                if($_POST['phoneNumber'] == ""){
                    $errorMessages['phoneNumberError'] = "Please enter a phoneNumber.";
                    $hasError = true;
                }
				
				//check if phone number is valid, bonus
				if (!empty($_POST["phoneNumber"]) && !preg_match("/([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$/",$_POST["phoneNumber"])){
					$errorMessages['phoneNumberError'] = "invalid phonenumber, format should be 000-000-0000";
					$hasError = true;
				}
				
				if($_POST['emailAddress'] == ""){
					$errorMessages['emailAddressError'] = "Please enter an emailAddress.";
					$hasError = true;
				}
				//check if emailAddress is valid, bonus
				if (!empty($_POST["emailAddress"]) && !preg_match("/([a-zA-Z0-9._-]+)[@]([a-zA-Z0-9-]+)[.]([a-zA-Z.]{2,5})$/",$_POST["emailAddress"])){
					$errorMessages['emailAddressError'] = "Invalid email address";
					$hasError = true;
				}
				
				//check if emailAddress is duplicate or not
				
				$email=$_POST['emailAddress'];
				$sql = "SELECT * FROM mailinglist WHERE emailAddress = '$email'";
				$result = $abstractDAO->getMysqli()->query($sql);
				if($result->num_rows >= 1){
					$errorMessages['emailAddressError'] = "Duplicate email address";
					$hasError = true;
				}
				
				if(empty($_POST['referrer'])){
					$errorMessages['referrerError'] = "Please select a referrer.";
					$hasError = true;
				}

				//if(!$hasError){
                //    $customer = new Customer($_POST['customerName'], $_POST['phoneNumber'], $_POST['emailAddress'], $_POST['referrer']);
				//	$addSuccess = $customerDAO->addCustomer($customer);
                //    echo '<h3>' . $addSuccess . '</h3>';
   			   //}
			   
				//encrpt email address with password hash.
				if(!$hasError){
					$email = $_POST['emailAddress'];
					$hash = password_hash($email, PASSWORD_DEFAULT);
					//$hash2 = password_hash($email, PASSWORD_DEFAULT);
					$customer = new customer($_POST['customerName'],$_POST['phoneNumber'],$hash,$_POST['referrer']);
					$addSuccess = $customerDAO->addCustomer($customer);
					echo '<h3>'. $addSuccess .'</h3>';
				
				//upload file to files	
				if (isset($_POST['myfile']) ){
					$path = 'files/';
					$upload_file = $path.basename($_FILES['fileUpload']['name']);

					if(move_uploaded_file($_FILES['fileUpload']['tmp_name'],$upload_file)){
                    echo "<script>alert('File uploaded successfully!');</script>";  // To show alert message when file uploaded successfully
                } else {
                    echo "<script>alert('Failed!');</script>";   // To show alert message when file upload failed.
                }
				}


		   }  

	}     
            
            
?>

            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40' >
								<?php
									if(isset($errorMessages['customerNameError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['customerNameError'] . '</span>';
									}
								?></td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40' >
								<?php
									if(isset($errorMessages['phoneNumberError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['phoneNumberError'] . '</span>';
									}
								?></td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40' >
								<?php
									if(isset($errorMessages['emailAddressError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['emailAddressError'] . '</span>';
									}
								?></td>

                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referrer" id="referrerNewspaper" value="newspaper" >
                                    Radio<input type="radio" name='referrer' id='referrerRadio' value='radio' >
                                    TV<input type='radio' name='referrer' id='referrerTV' value='TV' >
                                    Other<input type='radio' name='referrer' id='referrerOther' value='other' >
                            	<?php
									if(isset($errorMessages['referrerError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['referrerError'] . '</span>';
									}
								?></td>
							</tr>
                            <tr>
                                <td colspan='3'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;
								<input type='reset' name="btnReset" id="btnReset" value="Reset Form">&nbsp;&nbsp;
							<!--	<input type='button' name='mailinglistbtn' id="mailinglistbtn" value="Mailinglist" onclick="window.location.href='mailinglist.php'">  -->
								</td>
                            </tr>
							<tr>  <!-- file upload feature for lab12 -->
								<td>File Upload:</td>
								<td><input type="file" name="fileUpload" id="fileUpload" value="OpenFile">&nbsp;&nbsp;
								<input type='submit' name="myfile" id="myfile" value="Upload"></td>
							</tr>
                        </table>
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->
			
			

<?php

  //    if(isset($_GET['deleted'])){
  //              if($_GET['deleted'] == true){
   //                 echo '<h3>customer Deleted</h3>';
   //             }
  //          }
       
        
        }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }
?>
		
    <?php include 'footer.php'; ?>
					

	


