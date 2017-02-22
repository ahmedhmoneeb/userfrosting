<?php

$tenantDeveloper = $_POST['tenantDeveloper'];
$password = $_POST['password'];
$SDKProfileId = $_POST['SDKProfileId'];
$fileName = "thisisSDK.tar.gz";
$endPointKeyHash = $_POST['endPointKeyHash'];

//Download the SDK
$output = shell_exec('rm ' . $fileName);
$command = 'curl -v -o ' . $fileName . ' -S -u ' . $tenantDeveloper . ':' . $password . ' -X POST "http://88.85.224.42:8080/kaaAdmin/rest/api/sdk?sdkProfileId='.$SDKProfileId.'&targetPlatform=C" | python -mjson.tool';
echo $command;
$output = shell_exec($command);
echo$output;

$command = "mkdir tmp/" . $tenantDeveloper;
shell_exec($command);

$command = "cp files/*.* tmp/" . $tenantDeveloper;
shell_exec($command);

$command = "mv thisisSDK* tmp/" . $tenantDeveloper;
shell_exec($command);

$command = "cd tmp/" . $tenantDeveloper . "/; ./integrate.sh";
shell_exec($command);

$command = "mv /var/www/html/downloads/kaaSDK.ipk /var/www/html/downloads/" . $tenantDeveloper . ".ipk";
shell_exec($command);

?>
