<?php

//All the important variables in the file :
$userName = $_GET["user_name"];
$tenantName = $userName . "_tenant";
$tenantAdmin = $userName . "_tenant_admin";
$tenantDeveloper = $userName . "_tenant_developer";
$tenantAdminEmail = $userName . "@AdminEmail.com";
$tenantDevEmail = $userName . "@DevEmail.com";
$password = "lolpassword"; //This password will be used for both the admin/developer accounts.


//Create a new Tenant for this user and gets the new tenant's ID :
$curl = curl_init();
$data = array("name" => $tenantName);                                                                    
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/tenant',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));
$resp = curl_exec($curl);
echo $resp;
$tenantInfo = json_decode($resp, true);
$tenantId =  $tenantInfo["id"];
curl_close($curl);


//Creates an Admin for the new tenant and gets his temp password
$curl = curl_init();
$data = array(
  "username" => $tenantAdmin,
  "tenantId" => $tenantId,
  "authority" => "TENANT_ADMIN",
  "mail" => $tenantAdminEmail,
  "tempPassword" => "testing");
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/user',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));
$resp = curl_exec($curl);
echo $resp;
$adminInfo = json_decode($resp, true);
$adminPass =  $adminInfo["tempPassword"];
curl_close($curl);


//Change the admin's password from the temp password to the permanent password
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/auth/changePassword?username=' . $tenantAdmin . '&oldPassword=' . $adminPass . '&newPassword=lolpassword',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST"
    ));
$resp = curl_exec($curl);
echo $resp;
curl_close($curl);


//Creates a developer account for the new tenant and gets his temp password
$curl = curl_init();
$data = array(
  "username" => $tenantDeveloper,
  "tenantId" => $tenantId,
  "authority" => "TENANT_DEVELOPER",
  "mail" => $tenantDevEmail,
  "tempPassword" => "testing");
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/user',
    CURLOPT_USERPWD => $tenantAdmin . ":lolpassword",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));
$resp = curl_exec($curl);
echo $resp;
$devInfo = json_decode($resp, true);
$devPass =  $devInfo["tempPassword"];
curl_close($curl);


//Change the developer's password from the temp password to the permanent password
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/auth/changePassword?username=' . $tenantDeveloper . '&oldPassword=' . $devPass . '&newPassword=lolpassword',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST"
    ));
$resp = curl_exec($curl);
echo $resp;
curl_close($curl);

?>
