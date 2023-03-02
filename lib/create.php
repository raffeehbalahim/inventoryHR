<?php 
    include '../db/config.php';

    
    if(isset($_POST['createItem'])){
        # Create item
         if ($_POST['brand'] && $_POST['unit'] && $_POST['serialNumber'] && $_POST['purchaseDate'] && $_POST['manufacturer']) {
           
             echo $brand = $_POST['brand'];
             echo $unit = $_POST['unit'];
             echo $serialNumber = $_POST['serialNumber'];
             echo $purchaseDate = $_POST['purchaseDate'];
             echo $manufacturer = $_POST['manufacturer'];

             if(isset($_POST['bundle'])){
                $bundle = $_POST['bundle'];   
             } else {
                 $bundle = 0;   
             }
             echo $bundle;
             $createItem = "INSERT INTO peripherals (brand, unit, serial_number, purchase_date, manufacturer, set_id)
                 VALUES ('$brand', '$unit', '$serialNumber', '$purchaseDate', '$manufacturer', '$bundle')";
             if (mysqli_query($db, $createItem)) {
                 echo "Item created successfully ";
             } else {
                 echo "Item created unsuccessfully ";
             }
            
             header('location: ../index.php');
         } 
        
        // else if ($_FILES['itemFile']) {
            // echo "2";
        //     $file_extension = pathinfo($_FILES['itemFile']['name'], PATHINFO_EXTENSION);
        //     if ($file_extension == 'csv') {
        //         $file = fopen($_FILES['itemFile']['tmp_name'],"r"); 

        //         # Get first column and check column format (firstname, lastname, set)
        //         $columns = fgetcsv($file);
        //         if ($columns[0] == 'item' && $columns[1] == 'unit' && $columns[2] == 'serial' && $columns[3] == 'date' && $columns[4] == 'set') {
        //             while ($newItem = fgetcsv($file)) {
        //                 # Get each column
        //                 $item = $newItem[0];
        //                 $unit = $newItem[1];
        //                 $serial = $newItem[2];
        //                 $date = date('Y-m-d', strtotime(str_replace('/', '-', $newItem[3])));;
        //                 $set = $newItem[4];
                        
        //                 # Check if set exist in db
        //                 $check_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
        //                 $check_set_result = mysqli_query($db, $check_set);

        //                 if (mysqli_num_rows($check_set_result)) {
        //                     # Get set ID
        //                     $existSetRow = mysqli_fetch_assoc($check_set_result);
        //                     $existSetid = $existSetRow['set_id'];

        //                     $create_item = "INSERT INTO peripherals (brand, unit, serial_number, purchase_date, set_id)
        //                     VALUES ('$item', '$unit', '$serial', '$date', '$existSetid')";
        //                     mysqli_query($db, $create_item);
        //                 } else {
        //                     $create_item = "INSERT INTO peripherals (brand, unit, serial_number, purchase_date, set_id)
        //                     VALUES ('$item', '$unit', '$serial', '$date', '0')";
        //                     mysqli_query($db, $create_item);
        //                 }
        //             }
        //             header('location: ../index.php');
        //         } else {
        //             # Invalid column format       
        //             header('location: ../index.php');
        //         }
        //     } else {
        //         # If file is not csv
        //         header('location: ../index.php');
        //     }
        // }
    } else if(isset($_POST['createBundle'])){
        # Create set
        $bundle = $_POST['newBundle'];

        #Check set if exist
        $checkBundle = "SELECT * FROM set_bundle WHERE set_name = '$bundle' "; 
        $checkingBundle = mysqli_query($db, $checkBundle);

        if(mysqli_num_rows($checkingBundle)){
            header('location: ../index.php?set=' . $bundle . '');
        } else {
            $createBundle = "INSERT INTO set_bundle (set_name)
                VALUES ('$bundle')";
            mysqli_query($db, $createBundle);
            header('location: ../index.php');
        }
    } else if(isset($_POST['createEmployee'])){
        # Create employee
        if ($_POST['firstname'] && $_POST['lastname']) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];

            # Check if there is a Set chosen
            if(isset($_POST['bundle'])){
                $bundleId = $_POST['bundle'];
            } else {
                $bundleId = 0;
            }
            $createEmployee = "INSERT INTO employees (firstname, lastname, set_id)
                VALUES ('$firstname', '$lastname','$bundleId')";
            mysqli_query($db, $createEmployee);
            echo "Employee: ".$employeeId = mysqli_insert_id($db);
            
            /*if(isset($_POST['bundle'])){
                echo "Bundle: " . $bundleId = $_POST['bundle'];
                $timecreated = time();
                
                $setBundle = "INSERT INTO bundle_assignments (bundle_id, employee_id, timecreated) VALUES ('$bundleId', '$employeeId', '$timecreated')";
                mysqli_query($db, $setBundle);
            }*/

            header('location: ../employee.php');

         } else if($_FILES['empFile']){
             $file_extension = pathinfo($_FILES['empFile']['name'], PATHINFO_EXTENSION);

             if ($file_extension == 'csv') {
                 $file = fopen($_FILES['empFile']['tmp_name'],"r"); 

                 # Get first column and check column format (firstname, lastname, set)
                 $columns = fgetcsv($file);
                
                 
                 if ($columns[0] == "firstname" && $columns[1] == "lastname" && $columns[2] == "set") {
                    
                     while ($newEmployee = fgetcsv($file)) {
                         # Get each column
                         $firstname = $newEmployee[0];
                         $lastname = $newEmployee[1];
                         $set = $newEmployee[2];
                        
                         # Check if set exist in db
                         $check_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
                         $check_set_result = mysqli_query($db, $check_set);
                        
                         if (mysqli_num_rows($check_set_result)) {
                             # Get set ID
                             $existSetRow = mysqli_fetch_assoc($check_set_result);
                             $existSetid = $existSetRow['set_id'];
    
                             # Check set if assigned
                             $check_set_assigned = "SELECT * FROM employees WHERE set_id = '$existSetid' ";
                             $check_set_assigned_result = mysqli_query($db, $check_set_assigned);
    
                             if (mysqli_num_rows($check_set_assigned_result)) {
                                 # Create employee with no set
                                 $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                                 VALUES ('$firstname', '$lastname', '0')";
                                 mysqli_query($db, $create_employee);
    
                             } else {
                                 # Create employee with existing unassigned set
                                 $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                                 VALUES ('$firstname', '$lastname', '$existSetid')";
                                 mysqli_query($db, $create_employee);
                             }
                         } else {
                             # Create set
                             $create_set = "INSERT INTO set_bundle (set_name)
                             VALUES ('$set')";
                             mysqli_query($db, $create_set);
    
                             # Get new set
                             $get_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
                             $get_set_result = mysqli_query($db, $get_set);
                             $getSetRow = mysqli_fetch_assoc($get_set_result);
                             $setid = $getSetRow['set_id'];
    
                             # Create employee with new set
                             $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                             VALUES ('$firstname', '$lastname', '$setid')";
                             mysqli_query($db, $create_employee);
                         }
                     }
                     header('location: ../employee.php');
                 } else {
                     # Invalid column format
                     header('location: ../employee.php');
                 }
             } else {
                 # If file is not csv
                 header('location: ../employee.php');
             }
         } else {
             header('location: ../employee.php');
        }
        
    }
?>