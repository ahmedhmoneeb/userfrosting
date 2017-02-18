<?php

$kaaAdmin = "a.moneeb";
$tenantAdmin = "a.moneeb2";
$tenantAdminId = "";
$tenantDeveloper = "a.moneeb3";
$tenantDeveloperId = "";
$tenantName = "DefaultTenant";
$tenantId = "";
$applicationId = "";
$applicationName = "app6";
$applicationToken = "";
$groupName = "All";
$groupId = "";
$ctlProfileSchemaId = "";
$ctlNotificationSchemaId = "";
$password = "Moneeb@098";
$SDKName = "SDK V1";
$SDKId = "";

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
$data = array("name" => $applicationName,"tenantId" => $tenantId);
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
        $applicationToken = $application["applicationToken"];
        $applicationId = $application["id"];
}
curl_close($curl);

//Create a new profile schema CTL
$curl = curl_init();
$data = "body={\"type\":\"record\",\"name\":\"ProfileSchemaV1\",\"namespace\":\"org.curpha.kaa.schemas.profile\",\"version\":1,\"fields\":[{\"name\":\"serial_num\",\"type\":{\"type\":\"string\",\"avro.java.string\":\"String\"}},{\"name\":\"end_point_type\",\"type\":{\"type\":\"enum\",\"name\":\"end_point_type\",\"symbols\":[\"access_point\",\"camera\",\"smart_home\"]}}]}&tenantId=" . $tenantId . "&applicationToken=" . $applicationToken;
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/CTL/saveSchema',
    CURLOPT_USERPWD => "$tenantDeveloper:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data
));
$resp = curl_exec($curl);
$ctlProfileSchemaInfo = json_decode($resp,true);
$ctlProfileSchemaId = $ctlProfileSchemaInfo['id'];
curl_close($curl);

//Create a new notification schema CTL
$curl = curl_init();
$data = "body={\"type\":\"record\",\"name\":\"NotificationSchemaV1\",\"namespace\":\"org.curpha.kaa.schemas.notification\",\"fields\":[{\"name\":\"message\",\"type\":{\"type\":\"string\",\"avro.java.string\":\"String\"}}],\"version\":1,\"dependencies\":[]}&tenantId=" . $tenantId . "&applicationToken=" . $applicationToken;
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/CTL/saveSchema',
    CURLOPT_USERPWD => "$tenantDeveloper:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data
));
$resp = curl_exec($curl);
$ctlNotificationSchemaInfo = json_decode($resp,true);
$ctlNotificationSchemaId = $ctlNotificationSchemaInfo['id'];
curl_close($curl);

//Create a new profie schema
$curl = curl_init();
$data = array("applicationId" => $applicationId,
                "ctlSchemaId" => $ctlProfileSchemaId,
                "name" => "PorfileSchemaV1",
                "description" => "pofile schema");
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/saveProfileSchema',
    CURLOPT_USERPWD => "$tenantDeveloper:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
));

$resp = curl_exec($curl);
curl_close($curl);

//Create a new notification schema
$curl = curl_init();
$data = array("applicationId" => $applicationId,
                "ctlSchemaId" => $ctlNotificationSchemaId,
                "name" => "NotificationSchemaV1",
                "description" => "notification schema");
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/createNotificationSchema',
    CURLOPT_USERPWD => "$tenantDeveloper:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
));

$resp = curl_exec($curl);
curl_close($curl);

//Create a new SDK profile
$curl = curl_init();
$data = array("applicationId" => $applicationId,
                "configurationSchemaVersion" => 1,
                "logSchemaVersion" => 1,
                "notificationSchemaVersion" => 2,
                "profileSchemaVersion" => 1,
                "name" => $SDKName);
$data_string = json_encode($data);
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/createSdkProfile',
    CURLOPT_USERPWD => "$tenantDeveloper:$password",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_string,
    CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
));
$resp = curl_exec($curl);
curl_close($curl);

//Get all the SDK profile in this app to get the SDK's ID
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://88.85.224.42:8080/kaaAdmin/rest/api/sdkProfiles/' . $applicationToken,
    CURLOPT_USERPWD => "$tenantDeveloper:$password"
));
$resp = curl_exec($curl);
$allSDKProfiles = json_decode($resp,true);
foreach ($allSDKProfiles as $SDKProfile)
{
    if ($SDKProfile["name"] == $SDKName)
        $SDKId = $SDKProfile["id"];
}
curl_close($curl);

//Send the info to the building server 
$curl = curl_init();
$data = array("tenantDeveloper" => $tenantDeveloper,
                "password" => $password,
                "SDKProfileId" => $SDKId);

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'localhost/curphaPhase2/downloadSDK.php',
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data
));
$resp = curl_exec($curl);
echo $resp;
curl_close($curl);
?>
