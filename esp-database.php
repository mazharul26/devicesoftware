<?php
  $servername = "localhost";
    
   // print_r($servername);
   //  Your Database name
    // $dbname = "cpark_db";
    $dbname = "sarbsbdrnd_rnd";
   // print_r($dbname);
    // Your Database user
    // $username = "cpark_user";
    $username = "sarbsbdrnd_rnd";    
    // Your Database user password
    // $password = "pG!6&QEeq}Od";
    $password = "4p*vzevJGw}I";
    
    // echo $password;
    
    
    function createOutput($name, $board, $gpio, $state) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO Outputs (name, board, gpio, state)
        VALUES ('" . $name . "', '" . $board . "', '" . $gpio . "', '" . $state . "')";

       if ($conn->query($sql) === TRUE) {
            return "New output created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function deleteOutput($id) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM Outputs WHERE id='". $id .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Output deleted successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function updateOutput($id, $state) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE Outputs SET state='" . $state . "' WHERE id='". $id .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Output state updated successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getAllOutputs() {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, name, board, gpio, state FROM Outputs ORDER BY board";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getAllOutputStates($chipid) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT gpio, state FROM device_items WHERE chipid='" . $chipid . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getOutputBoardById($id) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT board FROM Outputs WHERE id='" . $id . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }
    
    
      function getProductByChipId($chipId) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT chipid, active FROM products WHERE chipid='" . $chipId . "' LIMIT 1";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }
    
    
    function createProduct($chipid) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO products (chipid,live,last_connected_at, created_at) VALUES ('" . $chipid . "', 1, now(), now())";

       if ($conn->query($sql) === TRUE) {
            return "New product created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
    
    
    
    
    
    function updateProductTime($chipid) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE products SET updated_at=now(), last_connected_at=now(),live=1  WHERE chipid='". $chipid .  "'";

       if ($conn->query($sql) === TRUE) {
           
        //   $sql2 = "SELECT chipid, active FROM products WHERE chipid='" . $chipid . "' LIMIT 1";
        //     if ($result2 = $conn->query($sql2)) {
        //         return $result2;
        //     }
           
            // return "Output state updated successfully";
            return true;
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
    
    function createProductData($chipid, $productData) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
   
        
        // $sqlp = "SELECT id FROM products WHERE chipid='" . $chipid . "' LIMIT 1";
        // if ($result = $conn->query($sqlp)) {
        //     $row =  $result->fetch_assoc();
        //     $productId = $row['id'];
            
        // }
        // else {
        //     $productId = null;
        // }
        
        // echo $productId;
        // echo $productData;
        // exit;

        $sql = "INSERT INTO product_datas (chipid, product_data, created_at) VALUES ('" . $chipid . "', '" . $productData . "', now())";

       if ($conn->query($sql) === TRUE) {
           
           
           //smu check
            if($data = strstr($productData,'type=SMU'))
            {
                $explode = (explode('&data=',$data));
                // echo $explode['1'];
                // echo"<br>";
                $rfid =  $explode['1'];
                // $rfids['rfid'] = $rfid; 
                $door =  $explode['2'];  
                $lock =  $explode['3'];
                     
                //emplyee check using rfid                   
                if($rfid != 0)
                {

                   $employee = ("SELECT * FROM rfid_employee_infos where rfid='".$rfid."' AND status= 1");
                   
                   
                    $employees = $conn->query($employee);
                    $employee = $employees->fetch_assoc();
                    
                    
                    if($employee)
                    {
                    
                     
                      $d = [ 'access' => 1, 'status' => 200 ];
                      
                     header('Content-Type: application/json; charset=utf-8');
                           echo json_encode($d);
                           
                      //employee log create with access = 1, door = 0, lock = 0,
                      
                         if($door==0 and $lock == 0)
                        {
                            employeelogsdoorAndLockOpen($rfid,$chipid);
                        }elseif($door == 1 and $lock == 1)
                        {
                           employeelogsdoorAndLockClosed($rfid,$chipid); 
                        }
                      
                     
                    }
                    else
                    {
                        
                        
                        $d = [ 'access' => 0, 'status' => 200 ];
                        
                        //employee log create with access = 0, door = 1, lock = 1,
                         if($door==1 and $lock == 1)
                        {
                            employeelogsdoorAndLockClosed($rfid,$chipid);
                        }
                              
                                header('Content-Type: application/json; charset=utf-8');
                                   echo json_encode($d);
                                
                            
                    }
                    
                    die();
                }
                else{
                    $d = [ 'access' => 0, 'status' => 200 ];
                              
                                header('Content-Type: application/json; charset=utf-8');
                                   echo json_encode($d);
                }
            }
                
            return "New product data created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
    
    
     function employeelogsdoorAndLockOpen($rfid , $chipid) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $UTC = new DateTimeZone("UTC");
        $newTZ = new DateTimeZone("Asia/Dhaka");
        $date = new DateTime(date('Y-m-d H:i:s'), $UTC );
        $date->setTimezone( $newTZ );
        $date = $date->format('Y-m-d H:i:s');
       

        $sql = "INSERT INTO rfid_employee_logs (rfid_employee_id,chipid,punch_at,door_open_at,lock_open_at) VALUES ('".$rfid."','".$chipid."','".$date ."','".$date."',now())";

       if ($conn->query($sql) === TRUE) {
            return "New Employee Logs created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
     function employeelogsdoorAndLockClosed($rfid , $chipid) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $UTC = new DateTimeZone("UTC");
        $newTZ = new DateTimeZone("Asia/Dhaka");
        $date = new DateTime(date('Y-m-d H:i:s'), $UTC );
        $date->setTimezone( $newTZ );
        $date = $date->format('Y-m-d H:i:s');
       

        $sql = "INSERT INTO rfid_employee_logs (rfid_employee_id,chipid,door_closed_at,lock_closed_at) VALUES ('".$rfid."','".$chipid."','".$date ."','".$date."')";

       if ($conn->query($sql) === TRUE) {
            return "New Employee Logs created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    

    function updateLastBoardTime($board) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE Boards SET last_request=now() WHERE board='". $board .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Output state updated successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getAllBoards() {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT board, last_request FROM Boards ORDER BY board";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getBoard($board) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT board, last_request FROM Boards WHERE board='" . $board . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }
    
    
  
    
    

    function createBoard($board) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO Boards (board) VALUES ('" . $board . "')";

       if ($conn->query($sql) === TRUE) {
            return "New board created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function deleteBoard($board) {
        global $servername, $username, $password, $dbname;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM Boards WHERE board='". $board .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Board deleted successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

?>
