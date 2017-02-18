<?php

$kaaAdmin = "a.moneeb";
$tenantAdmin = "a.moneeb2";
$tenantAdminId = "";
$tenantDeveloper = "a.moneeb3";
$tenantDeveloperId = "";
$tenantName = "DefaultTenant";
$tenantId = "";
$applicationName = "defaultApp";
$applicationToken = "";
$groupName = "All";
$groupId = "";

$password = "Moneeb@098";

//Get all the tenants in the system
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/tenants',
    CURLOPT_USERPWD => "$kaaAdmin:$password"
));
$resp = curl_exec($curl);
$allTenants = json_decode($resp,true);
foreach ($allTenants as $tenant)
{
    if ($tenant["name"] == $tenantName)
        $tenantId = $tenant["id"];
}
curl_close($curl);


//Create a new application
$curl = curl_init();
$data = array("name" => "Application 1","tenantId" => $tenantId);
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/application',
    CURLOPT_USERPWD => "$tenantAdmin:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
));

$resp = curl_exec($curl);
echo $resp;
curl_close($curl);

?>
