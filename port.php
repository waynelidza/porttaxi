<?php 

	$dbhost= "localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="taxiport";


	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
   
    $resultArray = array();
    $respArray = array();
    
    switch($_POST['value']) 
    {




        CASE 'insertCellDetails':
                if(!$result = $conn->prepare("CALL insert_cellDetails(?,?,?,?,?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL insert_cellDetails(?,?,?,?,?,?)");
                if(!$result->bind_param("ssisii",$_POST['serialNo'],$_POST['lastUsed'],$_POST['userID'], $_POST['cellphone'],$_POST['cCount'], $_POST['spID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                break;  
                      ///////////////////////////////////////////////////// Updating balance ///////////////////////////////////////////////////////////////
                
            
                CASE 'updateUser':
                if(!$result = $conn->prepare("CALL proc_update(?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_update(?,?)");
                if(!$result->bind_param("si",$_POST['myPassword'],$_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
               
                break; 

            CASE 'retrievetblPromo':
                
                if(!$result = $dbconn->prepare("CALL proc_RetrievePromo()"))
                {
                    echo $dbconn->error;
                }
               $result = $dbconn->prepare("CALL proc_RetrievePromo()");
               
                if(!$result->execute())
                {
                    echo $dbconn->error;
                }
                
                $result->bind_result($promoID, $promoDescription, $spID, $promoAmount, $promoStart, $promoEnd);  
                       
                while($result->fetch())
                {
                    array_push($resultArray, array(
                        '$promoID'=>$promoID,
                        '$$promoDescription'=>$promoDescription,
                        '$spID'=>$spID,
                        '$promoAmount'=>$promoAmount,
                        '$promoStart'=>$promoStart,
                        '$promoEnd'=>$promoEnd
                    ));
                }
                
                echo json_encode($resultArray);
               
                $result->close();
                mysqli_close($dbconn);
                break;
            
            
                CASE 'balanced':
                if(!$result = $conn->prepare(""))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("");
                if(!$result->bind_param("i",$_POST['balance']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                break;  



                CASE 'retrieveDetails':
                
                if(!$result = $conn->prepare("CALL proc_RetrieveDetails(?)"))
                {
                    echo $conn->error;
                }
               $result = $conn->prepare("CALL proc_RetrieveDetails(?)");
               if(!$result->bind_param("i",$_POST['accountNr']))
                {
                    echo $conn->error;
                }
               
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                
                $result->bind_result($transID, $transAmount, $promoID, $username, $bankID, $accountNr);  
                       
                while($result->fetch())
                {
                    array_push($resultArray, array(
                        '$transID'=>$transID,
                        '$transAmount'=>$transAmount,
                        '$promoID'=>$promoID,
                        '$username'=>$username,
                        '$bankID'=>$bankID,
                        '$accountNr'=>$accountNr
                    ));
                }
                
                echo json_encode($resultArray);
               
                $result->close();
                break;

    CASE 'retrievePromo':
                if(!$result = $conn->prepare("CALL retrieve_promos_by_sp(?)"))
                {
                    echo $conn->error;
                }
                
                $result = $conn->prepare("CALL retrieve_promos_by_sp(?)");
                
                if(!$result->bind_param("s",$_POST['spID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                
                $result->bind_result($spName,$promoDescription,$promoAmount);  
                       
                while($result->fetch())
                {
                    array_push($resultArray, array(
                    '$spName'=>$spName,
                    'promoDescription'=>$promoDescription,
                    'promoAmount'=>$promoAmount
                    ));
                }
                echo json_encode($resultArray);
                $result->close();
                break;


                CASE 'registercomutter':
                if(!$result = $conn->prepare("CALL registercomutter(?,?,?,?,?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL insert_new_user(?,?,?,?,?,?)");
                if(!$result->bind_param("ssisss",$_POST['firstname'],$_POST['surname'],$_POST['bankID'],$_POST['myPassword'],$_POST['email'],$_POST['cellphone']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                break;  


                /////////////////////////////////////////insert transaction//////////////////////////////////////

            CASE 'insertTrans':
                if(!$result = $conn->prepare("CALL insert_transaction(?,?,?,?,?,?,?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL insert_transaction(?,?,?,?,?,?,?,?)");
                if(!$result->bind_param("sisiisii",$_POST['transAmount'],$_POST['promoID'],$_POST['username'], $_POST['bankID'],$_POST['accountNr'], $_POST['transTime'],$_POST['savedAmount'],$_POST['transBalance']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                break;  

                ///////////////////////////////////////////////////////////////// LOGIN  ///////////////////////////////////////////////////////////////////////////////////
                CASE 'login':
                if(!$result = $conn->prepare("CALL proc_login(?,?)"))
                {
	                echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_login(?,?)");

                if(!$result->bind_param("ss",$_POST['email'],$_POST['myPassword']))
                {
                    echo $conn->error;
                }
                  
                if(!$result->execute())
                {
                    echo $conn->error;
                }   
                $result->bind_result($userID, $firstname, $surname, $idNO, $address, $accountNr, $username, $myPassword, $email ,$bankID, $cellphone);         
                while($result->fetch())
                {
	                array_push($resultArray, array(
	                'userID'=>$userID,
	                'firstname'=>$firstname,
	                'surname'=>$surname,
	                'idNO'=>$idNO,
	                'address'=>$address,
	                'accountNr'=>$accountNr,
	                'username'=>$username,
	                'myPassword'=>$myPassword,
	                'email'=>$email,
	                'bankID'=>$bankID,
	                'cellphone'=>$cellphone,
	                ));
                }

                if($email == $_POST['email'] && $myPassword == $_POST['myPassword']){
                    $_SESSION['uid'] = $userID;
                } else {
                    echo "   Incorrect details.";
                }
                //echo json_encode($resultArray);

// sent objs to factry
                array_push($respArray,array('userID'=>$userID,'email' => $email,'username' => $username, 'firstname'=>$firstname,'surname'=>$surname, 'bankID' =>$bankID));
                echo json_encode($respArray);
                $result->close();

                break;  
            ////////////////////////////////////////////////////// LIST USERS TO HOME //////////////////////////////////////////////////////
                 CASE 'userlist':
                if(!$result = $conn->prepare("CALL proc_userList(?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_userList(?)");
                if(!$result->bind_param("i",$_POST['userID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                $result->bind_result($userID, $firstname, $surname, $idNO, $address, $accountNr, $username, $myPassword, $email ,$bankID, $cellphone);         
                while($result->fetch())
                {
                    array_push($resultArray, array(
                    'userID'=>$userID,
                    'firstname'=>$firstname,
                    'surname'=>$surname,
                    'idNO'=>$idNO,
                    'address'=>$address,
                    'accountNr'=>$accountNr,
                    'username'=>$username,
                    'myPassword'=>$myPassword,
                    'email'=>$email,
                    'bankID'=>$bankID,
                    'cellphone'=>$cellphone,
                    ));
                }
                echo json_encode($resultArray);
                break;


                CASE 'translist':
                if(!$result = $conn->prepare("CALL proc_transList(?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_transList(?)");
                if(!$result->bind_param("i",$_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                $result->bind_result($transID, $transAmount, $promoID, $username, $bankID, $accountNr, $transTime, $savedAmount, $transBalance);         
                while($result->fetch())
                {
                    array_push($resultArray, array(
                    '$transID'=>$transID,
                        '$transAmount'=>$transAmount,
                        '$promoID'=>$promoID,
                        '$username'=>$username,
                        '$bankID'=>$bankID,
                        '$accountNr'=>$accountNr,
                        '$transTime' => $transTime,
                        '$savedAmount'=> $savedAmount,
                         '$transBalance' =>  $transBalance
                    ));
                }
                echo json_encode($resultArray);
                break;


                ///////////////////////////////////////////////////// Account Login In ///////////////////////////////////////////////////////////////
                CASE 'registerAccount':
                if(!$result = $conn->prepare("CALL proc_account_log(?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_account_log(?,?)");
                if(!$result->bind_param("ss",$_POST['accountNr'],$_POST['bankPassword']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                $result->bind_result($bankID, $bankName, $accountNr, $bankPassword, $firstname, $surname, $idNo, $cellphone, $othercellphone ,$email, $address, $balance);         
                while($result->fetch())
                {
                    array_push($resultArray, array(
                    'bankID'=>$bankID,
                    'bankName'=>$bankName,
                    'accountNr'=>$accountNr,
                    'bankPassword'=>$bankPassword,
                    'firstname'=>$firstname,
                    'surname'=>$surname,
                    'idNo'=>$idNo,
                    'cellphone'=>$cellphone,
                    'othercellphone'=>$othercellphone,
                    'email'=>$email,
                    'address'=>$address,
                    'balance' => $balance,

                    ));
                }
                echo json_encode($resultArray);

                break; 

          
                 ///////////////////////////////////////////////////// Updating balance ///////////////////////////////////////////////////////////////
                CASE 'updateBalance':
                if(!$result = $conn->prepare("CALL proc_updateCalc(?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_updateCalc(?,?)");
                if(!$result->bind_param("ii",$_POST['balance'], $_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
               
                break; 
                
                /////////////////////////////////////updatePassword//////////
                CASE 'updatePassword':

                if(!$result = $conn->prepare("CALL proc_updatePassword(?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_updatePassword(?,?)");
                if(!$result->bind_param("si",$_POST['email'], $_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
               
                break; 


             ///////////////////////////////////////////////////// Updating trans ///////////////////////////////////////////////////////////////
                CASE 'updateTrans':
                if(!$result = $conn->prepare("CALL proc_updateTransAmount(?,?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_updateTransAmount(?,?)");
                if(!$result->bind_param("ii",$_POST['transAmount'], $_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
               
                break;

                ////////////////////////////////////////////////////// LIST account holders TO HOME //////////////////////////////////////////////////////
                 CASE 'accountList':
                 
                if(!$result = $conn->prepare("CALL proc_account_list(?)"))
                {
                    echo $conn->error;
                }
                $result = $conn->prepare("CALL proc_account_list(?)");
                if(!$result->bind_param("i",$_POST['bankID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                $result->bind_result($bankID, $bankName, $accountNr, $bankPassword, $firstname, $surname, $idNo, $cellphone, $othercellphone ,$email, $address, $balance);         
                while($result->fetch())
                {
                    array_push($resultArray, array(
                    'bankID'=>$bankID,
                    'bankName'=>$bankName,
                    'accountNr'=>$accountNr,
                    'bankPassword'=>$bankPassword,
                    'firstname'=>$firstname,
                    'surname'=>$surname,
                    'idNo'=>$idNo,
                    'cellphone'=>$cellphone,
                    'othercellphone'=>$othercellphone,
                    'email'=>$email,
                    'address'=>$address,
                    'balance' =>$balance,
                    ));
                }
                echo json_encode($resultArray);

                break; 
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                
    //             /////////////////////////////////////////////////////////////// INSERT PROMO ////////////////////////////////////////////////////////////////////////////////    
    //             CASE 'insertPromo':
    //             if(!$result = $conn->prepare("CALL insert_promotion(?,?,?,?,?)"))
    //             {
    //                 echo $conn->error;
    //             }
    //             $result = $conn->prepare("CALL insert_promotion(?,?,?,?,?)");
    //             if(!$result->bind_param("sssss",$_GET['promoDescription'],$_GET['spID'],$_GET['promoAmount'],$_GET['promoStart'],$_GET['promoEnd']))
    //             {
    //                 echo $conn->error;
    //             }
    //             if(!$result->execute())
    //             {
    //                 echo $conn->error;
    //             }
    //             break;
    //             /////////////////////////////////////////////////////////// RETRIEVE PROMO BY SP ////////////////////////////////////////////////////////////////////////////
				CASE 'retrievePromo':
                if(!$result = $conn->prepare("CALL proc_retrieveSPpromo(?)"))
                {
                    echo $conn->error;
                }
                
                $result = $conn->prepare("CALL proc_retrieveSPpromo(?)");
                
                if(!$result->bind_param("i",$_POST['spID']))
                {
                    echo $conn->error;
                }
                if(!$result->execute())
                {
                    echo $conn->error;
                }
                
                $result->bind_result($spName,$promoDescription,$promoAmount);  
                       
                while($result->fetch())
                {
	                array_push($resultArray, array(
                     '$spID'=>$spID,
	                '$spName'=>$spName,
	                'promoDescription'=>$promoDescription,
	                'promoAmount'=>$promoAmount
	                ));
                }
                echo json_encode($resultArray);
                $result->close();
                break;


    //             //////////////////////////////////////  REGISTER OR INSERT BANK DETAILS  ////////////////////////////////////////////////////////////////////////////////////
    //             CASE 'insertBankDetails':
    //             if(!$result = $conn->prepare("CALL proc_insertBankDetails(?,?,?,?,?,?,?,?,?,?)"))
    //             {
    //                  echo $conn->error;
    //             }
    //             $result = $conn->prepare("CALL proc_insertBankDetails(?,?,?,?,?,?,?,?,?,?)");
                
    //             if(!$result->bind_param("ssssssssss",$_GET['bankName'],$_GET['accountNr'],$_GET['bankPassword'],$_GET['firstname'],$_GET['surname'],$_GET['idNo'],$_GET['cellphone'],$_GET['othercellphone'],$_GET['email'],$_GET['address']))
    //             {
    //                 echo $conn->error;
    //             }
    //             if(!$result->execute())
    //             {
    //                 echo $conn->error;
    //             }   
    //             break;
    //             //////////////////////////////////////// REGISTER USER  /////////////////////////////////////////////////////////////////////////////////////////////////////
    //             CASE 'register':
    //             if(!$result = $conn->prepare("CALL insert_new_user(?,?,?,?)"))
    //             {
    //                 echo $conn->error;
    //             }
    //             $result = $conn->prepare("CALL insert_new_user(?,?,?,?)");
    //             if(!$result->bind_param("ssss",$_POST['firstname'],$_POST['surname'],$_POST['username'],$_POST['cellphone']))
    //             {
    //                 echo $conn->error;
    //             }
    //             if(!$result->execute())
    //             {
    //                 echo $conn->error;
    //             }
    //             break;  
    //             ///////////////////////////////////////////////////////////////// INSERT TO SERVICE PROVIDER ///////////////////////////////////////////////////////////////
    //             CASE 'insertServiceProvider':
    //             if(!$result = $conn->prepare("CALL proc_insert_service_provider(?)"))
    //             {
    //                 echo $conn->error;
    //             }
    //             $result = $conn->prepare("CALL proc_insert_service_provider(?)");
    //             if(!$result->bind_param("s",$_GET['spName']))
    //             {
    //                 echo $conn->error;
    //             }
    //             if(!$result->execute())
    //             {
    //                 echo $conn->error;
    //             }
    //             break;
    }

?>

