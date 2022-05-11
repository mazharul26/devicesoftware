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
        
        // var_dump($_SERVER['QUERY_STRING']);
        
        // $a = $_SERVER['QUERY_STRING'];
        
        // // $arrayData = explode('&',$a);
        // $arrayData = json_encode($a);
        // $arrayData = json_decode($arrayData);
        // print_r($arrayData);
        // // echo $a;
        
        
        // exit;
        
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
                
                echo 'New product added with chipId' . $chipid;
                
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
      
      // post method data received
      
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $action = test_input($_POST["action"]);
              $chipid = test_input($_POST["chipid"]);
              $productData = $_SERVER['QUERY_STRING'];
              $productData = file_get_contents('php://input');
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
                          if(count($rows)){ 
                           
                                if($rows['active'] == 1){
                                    updateProductTime($chipid);
                                   createProductData($chipid, $productData);
                                }
                           }
                           else{ 
                                      
                                createProduct($chipid);
                                createProductData($chipid, $productData);
                                
                                echo 'New product added with chipId' . $chipid;
                                        
                            }
            

                    exit;
                    
                }
            
       }
    

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
