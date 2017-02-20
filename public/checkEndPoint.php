<?php

$endPointSerialNumber = $_GET['serial_num'];

/**
$kaaAdmin = "a.moneeb";
$tenantAdmin = "a.moneeb2";
$tenantAdminId = "";
$tenantDeveloper = "a.moneeb3";
$tenantDeveloperId = "";
$tenantName = "DefaultTenant";
$tenantId = "";
$applicationId = "";
$applicationName = "defaultApp";
$applicationToken = "";
$groupName = "All";
$groupId = "";
$ctlProfileSchemaId = "";
$ctlNotificationSchemaId = "";
$password = "Moneeb@098";
**/

//User's user_name in UserFrosting
$userName = "adminCurpha";
//Tenant Info
$tenantName = $userName . "_tenant";
$tenantId = "";

//Tenant Admin Info
$tenantAdmin = $userName . "_tenant_admin";
$tenantAdminEmail = $userName . "@AdminEmail.com";
$tenantAdminId = "";

//Tenant Developer Info
$tenantDeveloper = $userName . "_tenant_developer";
$tenantDevEmail = $userName . "@DevEmail.com";
$tenantDeveloperId = "";

//Application Info
$applicationName = "access_point_app";
$applicationToken = "";

//Group Info
$groupName = "All";
$groupId = "";
$password = "lolpassword";


//Get all the tenants in the system
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/tenants',
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098"
));
$resp = curl_exec($curl);
$allTenants = json_decode($resp,true);
foreach ($allTenants as $tenant)
{
    if ($tenant["name"] == $tenantName)
        $tenantId = $tenant["id"];
}
curl_close($curl);

//Get all the admins in the tenant
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/admins/' . $tenantId,
    CURLOPT_USERPWD => "a.moneeb:Moneeb@098",
    CURLOPT_CUSTOMREQUEST => "POST"
));
$resp = curl_exec($curl);
$allAdmins = json_decode($resp,true);
foreach ($allAdmins as $admin)
{
    if ($admin["username"] == $tenantAdmin)
        $tenantAdminId = $admin["id"];
}
curl_close($curl);

//Get all the applications in the system
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/applications',
    CURLOPT_USERPWD => "$tenantAdmin:$password"
));
$resp = curl_exec($curl);
$allApplications = json_decode($resp,true);
if (sizeof($allApplications) != 0)
{
    foreach ($allApplications as $application)
    {
        if ($application["name"] == $applicationName)
            $applicationToken = $application["applicationToken"];
    }
}

curl_close($curl);

//Get all the groups in the application
if ($applicationToken != "")
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/endpointGroups/' . $applicationToken,
        CURLOPT_USERPWD => "$tenantDeveloper:$password"
    ));
    $resp = curl_exec($curl);
    $allGroups = json_decode($resp,true);
    foreach ($allGroups as $group)
    {
        if ($group["name"] == $groupName)
            $groupId = $group["id"];
    }
    curl_close($curl);
}


//Get all the endpoints in this application
if ($groupId != "")
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/endpointProfileBodyByGroupId?endpointGroupId=' . $groupId . '&limit=200&offset=0',
        CURLOPT_USERPWD => "$tenantDeveloper:$password"
    ));
    $resp = curl_exec($curl);
    $allEndPoints = json_decode($resp,true);
    $exist = 0;
    foreach ($allEndPoints["endpointProfilesBody"] as $endPoint)
    {
        if ( (json_decode($endPoint["clientSideProfile"],true)["serial_num"]) == $endPointSerialNumber )
        {
            $exist = 1;
            $endPointData = array("endpointKey" => $endPoint["endpointKeyHash"],
            			"endpointSerialNumber" => json_decode($endPoint["clientSideProfile"],true)["serial_num"],
            			"endpointType" => json_decode($endPoint["clientSideProfile"],true)["end_point_type"]);
            echo json_encode($endPointData);
        }
    }
    if($exist == 0)echo $exist;
    curl_close($curl);
}
else
{
    //echo "Doesn't Exist";
}
?>
