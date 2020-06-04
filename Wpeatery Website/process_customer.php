<?php
require_once('dao/customerDAO.php');

 if(isset($_GET['action'])){   
	if($_GET['action'] == "delete"){
        if(isset($_GET['_id'])){
            $customerDAO = new customerDAO();
            $success = $customerDAO->deleteCustomer($_GET['_id']);
            echo $success;
            if($success){
                header('Location:mailinglist.php?deleted=true');
            } else {
                header('Location:maillinglist.php');
            }
        }
    }
	//excute update action for edit_customer.php
    if($_GET['action']=="update"){
        if(isset($_POST['customerId'])&& 
            isset($_POST['customerName']) &&
            isset($_POST['phone'])) 
             {
 
        $customerDAO = new customerDAO();
        $result = $customerDAO->updateCustomer($_POST['customerId'], 
                $_POST['customerName'], $_POST['phone'],$_POST['email'],$_POST['referral']);
        $name = $_POST['customerName'];
        if($result > 0){
             header('Location:edit_customer.php?recordsUpdated='.$result.'&customerName=' . $_POST['customerName']);
            } else {
                header('Location:mailinglist.php?updated=true');
            }
        } else {
            header('Location:edit_customer.php?missingFields=true&customerID=' . $_POST['customerId']);
        }
    } 
     
}

?>
