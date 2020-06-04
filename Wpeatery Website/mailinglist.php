<?php

require_once('header.php');
require_once('dao/customerDAO.php');
require_once('./websiteUser.php');

//setting login session
session_start();
session_regenerate_id(false);

if(isset($_SESSION['AdminID'])){
   if(!$_SESSION['websiteUser']->isAuthenticated()){
      header('Location:login.php'); 
    }
} else {
    header('Location:login.php');
}

//get customer information from customerDAO class
	$customerDAO = new customerDAO;
    $customers = $customerDAO->getCustomers();
   

   //If there has customer information then print, otherwise not.
   if($customers){
        echo '<table border=\'1\'>';
        echo '<tr><th>Customer Name</th><th>Phone Number</th><th>Email Address</th><th>Referrer</th></tr>';
        foreach($customers as $customer){
            echo '<tr>';
			echo '<td><a href=\'edit_customer.php?customerId=' . $customer->getCustomerID().'\'>' . $customer->getCustomerName() . '</a></td>';
            echo '<td>' . $customer->getPhoneNumber() . '</td>';
            echo '<td>' . $customer->getEmailAddress() . '</td>';
			echo '<td>' . $customer->getReferrer() . '</td>';
            echo '</tr>';
        }
		echo '</table>';
    } else {
		echo'<h3>'.'No date in the mailinglist'.'</h3>';
	}
		// show login session information, new added
		echo '<div>'.'SessionID: ' . session_id() .'</div>';
        echo '<div>'.'Session AdminID: ' . $_SESSION['AdminID'].'</div>';
        if($_SESSION['websiteUser']->getDate()!=null){
        echo '<div>'.'Last login date: ' . $_SESSION['websiteUser']->getDate().'</div>';
        }else{
        echo '<div>'.'The first time to log in' .'</div>';  
        }
        echo("<button onclick=\"location.href='logout.php'\">Logout!</button>");
?>
<h4><a href="contact.php" style="color:white">Back to Contact page</a></h4>

<?php include 'footer.php'; ?>

