<?php

$kaaAdmin = "a.moneeb";
$tenantAdmin = "a.moneeb2";
$tenantAdminId = "";
$tenantDeveloper = "a.moneeb3";
$tenantDeveloperId = "";
$tenantName = "DefaultTenant";
$tenantId = "";
$applicationId = "";
$applicationName = "app5";
$applicationToken = "";
$groupName = "All";
$groupId = "";
$ctlProfileSchemaId = "";
$ctlNotificationSchemaId = "";
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
echo $resp;
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
echo $resp;
curl_close($curl);


?>
