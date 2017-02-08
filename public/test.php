<?php

// Get cURL resource
$curl = curl_init();


//$username = $_GET["user"];
//$password = $_GET["password"];

$userName = $_GET["user_name"];

$tenantName = $userName . "_tenant";
$tenantAdmin = $userName . "_tenant_admin";
$tenantDeveloper = $userName . "_tenant_developer";
$tenantAdminEmail = $userName . "@AdminEmail.com";
$tenantDevEmail = $userName . "@DevEmail.com";
$password = "lolpassword";

$data = array("name" => $tenantName);                                                                    
$data_string = json_encode($data);


// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/tenant',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
echo $resp;
$tenantInfo = json_decode($resp, true);
$tenantId =  $tenantInfo["id"];



/**
if (!curl_errno($curl))
{
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
    {
     header("Location: index.html");   
    }

}
**/

$data = array(
  "username" => $tenantAdmin,
  "tenantId" => $tenantId,
  "authority" => "TENANT_ADMIN",
  "mail" => $tenantAdminEmail,
  "tempPassword" => "testing"
);                                                                    
$data_string = json_encode($data);

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/user',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
echo $resp;
$adminInfo = json_decode($resp, true);
$adminPass =  $adminInfo["tempPassword"];

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/auth/changePassword?username=' . $tenantAdmin . '&oldPassword=' . $adminPass . '&newPassword=lolpassword',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST"
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
echo $resp;





$data = array(
  "username" => $tenantDeveloper,
  "tenantId" => $tenantId,
  "authority" => "TENANT_DEVELOPER",
  "mail" => $tenantDevEmail,
  "tempPassword" => "testing"
);                                                                    
$data_string = json_encode($data);

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/user',
    CURLOPT_USERPWD => $tenantAdmin . ":lolpassword",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
echo $resp;
$devInfo = json_decode($resp, true);
$devPass =  $devInfo["tempPassword"];

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/auth/changePassword?username=' . $tenantDeveloper . '&oldPassword=' . $devPass . '&newPassword=lolpassword',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST"
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
echo $resp;

/**
$data = array(
  "username" => $tenantDeveloper,
  "tenantId" => $tenantId,
  "authority" => "TENANT_DEVELOPER",
  "firstName" => $userName,
  "lastName" => $userName,
  "mail" => $tenantEmail,
  "tempPassword" => "testing"
);                                                                    
$data_string = json_encode($data);

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/user',
    CURLOPT_USERPWD => "$username:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_string) )
    ));

// Send the request & save response to $resp
$resp = curl_exec($curl);
**/
//$respDecoded = json_decode($resp,true);

//print_r($respDecoded);

/**
echo "<table border=2>";

for ( $i = 0 ; $i < count($respDecoded["endpointProfilesBody"]) ; $i++)
{
$endpointData = $respDecoded["endpointProfilesBody"][$i];
//print_r($endpointData);

$epKey = $endpointData["endpointKeyHash"];
$clientSideProfile = $endpointData["clientSideProfile"];
$clientSideProfile = json_decode($clientSideProfile,true);
$serialNumber = $clientSideProfile["serial_num"];
$epType = $clientSideProfile["end_point_type"];

print <<<HTML
<tr>
    <td><img src="access_point.png" style="width:100;height:100;"></td>
    <td>
        <p>EndPoint KeyHash : $epKey</p>
        <p>EndPoint Serial Number : $serialNumber</p>
        <p>EndPoint Type : $epType</p>
    </td>
</tr>
HTML;

}

echo "</table>";
**/
// Close request to clear up some resources
curl_close($curl);
?>
