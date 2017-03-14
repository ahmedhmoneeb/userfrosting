<?php

/**
$kaaAdmin = "a.moneeb";
$tenantAdmin = "a.moneeb2";
$tenantAdminId = "";
$tenantDeveloper = "a.moneeb3";
$tenantDeveloperId = "";
$tenantName = "DefaultTenant";
$tenantId = "";
$applicationName = "defaultApp";
$applicationId = "";
$applicationToken = "";
$groupName = "All";
$groupId = "";
$notificationSchemaId = "";
$notificationSchemaType = "";
$topicId = "";
$password = "Moneeb@098";
**/

//User's user_name in UserFrosting
$userName = $_POST['user_name'];
//$userName = "ahmed1234";
//Tenant Info
$tenantName = $userName . "_tenant";
$tenantId = "";

//Tenant Admin Info
$tenantAdmin = $userName . "_tenant_admin";
echo $tenantAdmin;
$tenantAdminEmail = $userName . "@AdminEmail.com";
$tenantAdminId = "";

//Tenant Developer Info
$tenantDeveloper = $userName . "_tenant_developer";
$tenantDevEmail = $userName . "@DevEmail.com";
$tenantDeveloperId = "";

$password = "lolpassword";

//Group Info
$groupName = "All";
$groupId = "";

//Application Info
$applicationName = "access_point_app";
$applicationId = "";
$applicationToken = "";


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
foreach ($allApplications as $application)
{
    if ($application["name"] == $applicationName)
        $applicationId = $application["id"];
        $applicationToken = $application["applicationToken"];
}
curl_close($curl);

//Get all the notification schemas in the system
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/notificationSchemas/' . $applicationToken,
    CURLOPT_USERPWD => "$tenantDeveloper:$password"
));
$resp = curl_exec($curl);
$allNotificationSchemas = json_decode($resp,true);
$notificationSchemaId = $allNotificationSchemas[1]["id"];
$notificationSchemaType = $allNotificationSchemas[1]["type"];
curl_close($curl);

//Get all the topics in the application
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/topics/' . $applicationToken,
    CURLOPT_USERPWD => "$tenantDeveloper:$password"
));
$resp = curl_exec($curl);
$allTopics = json_decode($resp,true);
foreach ($allTopics as $topic)
{
    if ($topic["type"] == "MANDATORY")
        $topicId = $topic["id"];
}
curl_close($curl);

//Send Notification
$file = '@' . realpath('msg.json');
$msg = $_POST['message'];
$endpointKeyHash = $_POST['endpointKeyHash'];
$output = shell_exec('rm msg.json');
$file = 'msg.json';
$current = array("message" => $msg);
// Write the contents back to the file
file_put_contents($file, json_encode($current));
$command = 'curl -v -S -u ' . $tenantDeveloper . ':' . $password . ' -F\'notification={"applicationId":"'.$applicationId.'","schemaId":"'.$notificationSchemaId . '","topicId": '.$topicId.',"type":"USER"};type=application/json\' -F\'endpointKeyHash=' . $endpointKeyHash . ';type=text/plain\' -F file=@msg.json "http://88.85.224.42:8080/kaaAdmin/rest/api/sendUnicastNotification" | python -mjson.tool';
$output = shell_exec($command);
$output = shell_exec('rm msg.json');
echo "<pre>" . $output . "</pre>";
?>
