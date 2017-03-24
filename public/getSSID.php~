 <?php

$file = "tmp/" . $_GET['username'] . "_git_repo/wireless" ;
$myfileR = fopen($file, "r") or die("Unable to open file!");

$fileContent;
while (! feof($myfileR) )
{
	$line = fgets($myfileR);
	$fileContent[] = explode(" ",$line);
}

//Change this value into the array
for ($i=0 ; $i < sizeof($fileContent) ; $i++)
{
	if($fileContent[$i][1] == "ssid")
	{
		//$fileContent[$i][2] = $hostName;
		echo $fileContent[$i][2];
	}
}

fclose($myfileR);



?> 
