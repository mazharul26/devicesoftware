<?php
    include_once('esp-database.php');
   
    $action = $id = $name = $gpio = $state = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = test_input($_POST["action"]);
        if ($action == "output_create") {
            $name = test_input($_POST["name"]);
            $board = test_input($_POST["board"]);
            $gpio = test_input($_POST["gpio"]);
            $state = test_input($_POST["state"]);
            $result = createOutput($name, $board, $gpio, $state);

            $result2 = getBoard($board);
            if(!$result2->fetch_assoc()) {
                createBoard($board);
            }
            echo $result;
        }
        else {
            echo "No data posted with HTTP POST.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        
     
        
         $date = date('Y-m-d H:i:s');
        // echo $date;
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $productsql = ("SELECT * FROM product_datas ORDER BY `id` DESC");
         $result = $conn->query($productsql);
        // print_r($result);
        //  die();
         $rfids = [];
        while($products = $result->fetch_assoc())
           {
               $str = $products['product_data'];
             //  print_r($str);
                if($data = strstr($str,'type=SMU'))
                {
                //   print_r($data);
                //   die();
                    $explode = (explode('&data=',$data));
                    // echo $explode['1'];
                    // echo"<br>";
                    $rfid =  $explode['1'];
                    // $rfid = 1111;
                    $rfids['rfid'] = $rfid; 
                    $door =  $explode['2'];  
                    $lock =  $explode['3'];
                  
                    $employee = ("SELECT * FROM rfid_employee_infos where rfid='".$rfid."' AND status= 1");
                        $employees = $conn->query($employee);
                        $employee = $employees->fetch_assoc();
                        
                        if($employee)
                        {
                           //echo"ok";
                          // echo($door);
                            //   $id = ($employee['id']);
                              
                            //   if($id)
                            //   {
                                  
                                  
                                  $d = [ 'access' => 1, 'status' => 200 ];
                                  
                                    header('Content-Type: application/json; charset=utf-8');
                                      //  echo json_encode($d);
                                    
                                   // die();
                            //   }
                              
                            
                           
                             if($door==0 AND $lock==0 )
                             {
                              echo "ok";
                              employeelogsdoorAndLockOpen($rfid,'220001');  
                             }elseif($door==1 AND $lock==1){
                               //  echo"Door Lock";
                                employeelogsdoorAndLockClosed('7424810','220001');
                             }
                             
                             die();
                     
                        }
                        else
                        {
                            $d = [ 'access' => 0, 'status' => 200 ];
                                  
                                    header('Content-Type: application/json; charset=utf-8');
                                       echo json_encode($d);
                                    
                                    die();
                        }
                        
                        die();
                        
                           
                           
                             
                    
                 
                }
             
              
              
           }
           
           
          echo($rfids['rfid']);
           
           die();
       
           
        
          $chipid = test_input($_GET["chipid"]);
          $productData = $_SERVER['QUERY_STRING'];
          
        //   var_dump($chipid);
        
        $action = test_input($_GET["action"]);
        if (($action == "outputs_state") and ($chipid != null)) {
            
            $result = getProductByChipId($chipid);
            $rows = [];
            
            if($result){
                 while ($row = $result->fetch_assoc()) {
                    $rows['chipid'] = $row['chipid'];
                    $rows['active'] = $row['active'];
                    // $rows['id'] = $row['id'];
                }
                
            }
            
            // $fResult = json_encode($rows);
            
            if(count($rows)){ 
                
                // echo $rows[0]; 
                
                //update product
                
                // echo $rows['chipid'];
                
                // $productId = $rows['id'];
                
                if($rows['active'] == 1){
                    updateProductTime($chipid);
                   createProductData($chipid, $productData);
                }
                
                // echo $productId;
                
                
                
                
                
            } else { 
                // echo 'no';
                //create product
                
                createProduct($chipid);
                createProductData($chipid, $productData);
                
                echo 'New product added with chipId ' . $chipid;
                
            }
            

            exit;
            
            
            
            
            
            
            $chipid = test_input($_GET["chipid"]);
            $result = getAllOutputStates($chipid);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $rows[$row["gpio"]] = $row["state"];
                }
            }
            echo json_encode($rows);
            $result = getBoard($chipid);
            if($result->fetch_assoc()) {
                updateLastBoardTime($chipid);
            }
        }
        else if ($action == "output_update") {
            $id = test_input($_GET["id"]);
            $state = test_input($_GET["state"]);
            $result = updateOutput($id, $state);
            echo $result;
        }
        else if ($action == "output_delete") {
            $id = test_input($_GET["id"]);
            $board = getOutputBoardById($id);
            if ($row = $board->fetch_assoc()) {
                $board_id = $row["board"];
            }
            $result = deleteOutput($id);
            $result2 = getAllOutputStates($board_id);
            if(!$result2->fetch_assoc()) {
                deleteBoard($board_id);
            }
            echo $result;
        }
        else {
            echo "Invalid HTTP request.";
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
