<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');

class customerDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function getCustomers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailinglist');
        $customers = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new customer object, and add it to the array.
                $customer = new Customer($row['customerName'], $row['phoneNumber'], $row['emailAddress'], $row['referrer']);
                $customer->setCustomerID($row['_id']);
				$customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
        $result->free();
        return false;
    }
    
	public function getID()
    {
        $result = $this->mysqli->query('SELECT * FROM mailinglist');
        $ID = array();
        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['_id'];
                $ID[] = $id;
            }
            $result->free();
            return $ID;
        }
        $result->free();
        return false;
	}
	
    public function getCustomer($_id){
        $query = 'SELECT * FROM mailinglist WHERE _id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $customer = new customer($temp['customerName'], $temp['phoneNumber'], $temp['emailAddress'], $temp['referrer']);
			$customer->setCustomerID($temp['_id']);
            $result->free();
            return $customer;
        }
        $result->free();
        return false;
    }
	
	public function addCustomer($customer){
        if(!$this->mysqli->connect_errno){ 
            $query = 'INSERT INTO mailinglist(customerName, phoneNumber, emailAddress, referrer)VALUES (?,?,?,?)'; 
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ssss', 
                    $customer->getCustomerName(), 
                    $customer->getPhoneNumber(), 
                    $customer->getEmailAddress().
					$customer->getReferrer());
            $stmt->execute();
			
            if($stmt->error){
                return $stmt->error;
            } else {
                return 'customer added to mailinglist!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
	
    public function deleteCustomer($_id){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailinglist WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $_id);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
	    public function updateCustomer($userID,$name,$phone,$email,$referrer){
        if (!$this->mysqli->connect_errno) {
            $query = 'UPDATE mailingList SET customerName=?,phoneNumber=?,emailAddress=?, referrer=? WHERE _ID=?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ssssi', $name, $phone, $email, $referrer,$userID);
            $stmt->execute();
            
            if ($stmt->error) {
                return $stmt->error;
            } else {
                return ' Update successful';
            }
        } else {
            return 'Error.';
        }


    }

}

?>
