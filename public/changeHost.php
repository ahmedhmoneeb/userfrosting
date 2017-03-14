 <?php
//$myfile = fopen("system", "r") or die("Unable to open file!");

//Git and Repo Info
$gitPrivateToken = "MhJVohNKvkC9kPLe-U5P";
$gitLabServerIP = "88.85.224.45";
$gitUserName = $_GET['username'] . "_git_user";
$gitUserId = "";
$gitRepoName = $_GET['username'] . "_git_repo";

$command = "mkdir tmp/ ; cd tmp/ ; git clone http://" . $gitUserName . ":lolpassword@" . $gitLabServerIP . "/" . $gitUserName ."/" . $gitRepoName .".git";
    echo $command;
    echo system($command);

$file = "tmp/" . $_GET['username'] . "_git_repo/system" ;
$myfileR = fopen($file, "r") or die("Unable to open file!");

/**
$myfile = fopen("testFile", "r") or die("Unable to open file!");
echo fgets($myfile);
echo "<br>";
echo fgets($myfile);
fclose($myfile);
**/
//print_r(parse_ini_file("system",true));

//$fileArr = file('system');
//print_r($fileArr);

//Read all the file into a multi-dimensional array, each line is an array
$fileContent;
while (! feof($myfileR) )
{
	$line = fgets($myfileR);
	$fileContent[] = explode(" ",$line);
}

//Get the value of the new hostName
if ( $_GET['hostname'] != "" ) $hostName = $_GET['hostname'] . "\n";
else $hostName = "DefaultHostName\n";

//Change this value into the array
for ($i=0 ; $i < sizeof($fileContent) ; $i++)
{
	echo "0 :" . $fileContent[$i][0];
	echo "1 :" . $fileContent[$i][1];
	if($fileContent[$i][1] == "hostname")
	{
		$fileContent[$i][2] = $hostName;
	}
}


foreach ($fileContent as $oneLine)
{
print_r($oneLine);
echo "<br>";
}
fclose($myfileR);

//Write the array back into the file into the same structure as before

$txt = "";
foreach ($fileContent as $oneLine)
{
	foreach ($oneLine as $word)
	{
		if($word == "config") $txt .= "\n" . $word;
		if($word == "option" || $word == "list") $txt .= "\t" . $word;
		if($word == "\toption" || $word == "\tlist") $txt .= $word;
		if($word != "\toption" && $word != "option" && $word != "\tlist" && $word != "list" && $word != "config" && $word != "\n" && $word != " " && $word != "")$txt .= " " . $word;
	}
}
//echo $txt;
$myfileW = fopen($file, "w") or die("Unable to open file!");
fwrite($myfileW, $txt);
fclose($myfileW);

$command = "cd tmp/ ; cd " . $gitRepoName .' ; echo Moneeb@098 | su root ; git add . ; git commit -m "svbjhf" ; git push origin master ; ';
    echo $command;
    echo system($command);
//echo implode(" ", $fileContent[0]);

?> 
