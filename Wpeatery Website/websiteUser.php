<?php
   class websiteUser{
    
    /* Host address for the database */
    protected static $DB_HOST = "localhost";
    /* Database username */
    protected static $DB_USERNAME = "wp_eatery";
    /* Database password */
    protected static $DB_PASSWORD = "password";
    /* Name of database */
    protected static $DB_DATABASE = "wp_eatery";
    
    private $AdminID;
    private $username;
    private $password;
    private $Lastlogin;
    private $dbError; 
    private $authenticated = false;
    private $mysqli;
    
    //create a function to connect database
    function __construct() {
        $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, 
                self::$DB_PASSWORD, self::$DB_DATABASE);
        if($this->mysqli->errno){
            $this->dbError = true;
        }else{
            $this->dbError = false;
        }
    }
    //use username and password to update the last login date
    public function authenticate($username,$password){
        $loginquery = "SELECT * from adminusers WHERE username=? and password=?";
        $stmt = $this->mysqli->prepare($loginquery);
        $stmt->bind_param('ss', $username,$password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows==1){
            $temp = $result->fetch_assoc();
            $this->AdminID = $temp['AdminID'];
            $this->authenticated = true;
            $this->username = $username;
            $this->password = $password;
        }
            $stmt->free_result();
    }
    
    public function isAuthenticated(){
        return $this->authenticated;
    }
    
    public function hasDbError(){
        return $this->dbError;
    }
    
    public function getUsername(){
        return $this->username;
    }
    
    public function getID(){
      return $this->AdminID;
    }
    
    public function getDate(){
      return $this->Lastlogin;
    }
    
    
   }
   
?>