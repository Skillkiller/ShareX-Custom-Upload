<?php
error_reporting(E_ERROR);

include 'UUID.php';

$tokens = array("token1", "token2"); //Tokens go here
$sharexdir = ""; //File directory
 
//Check for token
if(isset($_POST['secret']))
{
    //Checks if token is valid
    if(in_array($_POST['secret'], $tokens))
    {
        //Prepares for upload
        $filename = UUID::v4();
        $target_file = $_FILES["sharex"]["name"];
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        
        //Accepts and moves to directory
        if (move_uploaded_file($_FILES["sharex"]["tmp_name"], $sharexdir.$filename.'.'.$fileType))
        {
            //Sends info to client
            $json->status = "OK";
            $json->errormsg = "";
            $json->url = $filename . '.' . $fileType;
        }
            else
        {
            //Warning
           echo 'File upload failed - CHMOD/Folder doesn\'t exist?';
        }  
    }
    else
    {
        //Invalid key
        echo 'Invalid Secret Key';
    }
}
else
{
    //Warning if no uploaded data
    echo 'No post data recieved';
}
//Sends json
echo(json_encode($json));
?>
