<?php require_once('dao/customerDAO.php');?>
<?php include 'header.php'; 
	$customerDAO = new customerDAO();
    $customer = $customerDAO->getCustomer($_GET['customerId']);
   
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edit Customer <?php echo $customer->getCustomerName()?></title>
        <script type="text/javascript">
            function confirmDelete(customerName){
                return confirm("Please confirm that you wish to delete " + customerName + ".");
            }
        </script>
    </head>
    <body>
	<h3>Edit Customer</h3>
            <form name="editEmployee" method="post" action="process_customer.php?action=update" enctype="multipart/form-data">
            <table>
                <tr>        
                    <td>Customer Id:</td>
                    <td><input type="hidden" name="customerId" id="customerId" 
                    value="<?php echo $customer->getcustomerId();?>"><?php echo $customer->getcustomerId();?> </td> 
                 </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td><input type="text" name="customerName" id="customerName"
                    value="<?php echo $customer->getCustomerName();?>"></td>
                </tr>
                <tr>
                    <td>phone Number:</td>
                    <td><input type="text" name="phone" id="phone"
                    value="<?php echo $customer->getPhoneNumber();?>"></td>
                </tr>
				<tr>
                    <td>Email Address:</td>
                    <td><input type="text" name="email" id="email"
                    value="<?php echo $customer->getEmailAddress();?>"></td>
                </tr>
				<tr>
                    <td>How did you hear<br> about us?</td>
                    <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value='newspaper' <?php echo ($customer->getReferrer()=='newspaper')?'checked':'' ?>  >   <!-- get radio default value --> 
                        Radio<input type="radio" name='referral' id='referralRadio' value='radio' <?php echo ($customer->getReferrer()=='radio')?'checked':'' ?>>
                        TV<input type='radio' name='referral' id='referralTV' value='TV' <?php echo ($customer->getReferrer()=='TV')?'checked':'' ?> >
                         Other<input type='radio' name='referral' id='referralOther' value='other' <?php echo ($customer->getReferrer()=='other')?'checked':'' ?>>
                    </td>
                </tr>
				
				
				
                <tr>
                    <td cospan="2"><a onclick="return confirmDelete('<?php echo $customer->getCustomerName();?>')" 
							href="process_customer.php?action=delete&_id=<?php echo $customer->getCustomerID();?>">DELETE <?php echo $customer->getCustomerName();?>
									</a></td>
									<td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update"></td>
                </tr>
</table>

        </form>
        <h4><a href="index.php" style="color:white">Back to main page</a></h4>
    </body>
</html>
<?php include 'footer.php' ?>