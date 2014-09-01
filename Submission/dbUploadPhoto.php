<?php
include('connect.php');
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["uPhoto"]["name"]);
$extension = end($temp);

//file
$photoName=mysqli_escape_string($con, $_FILES["uPhoto"]["name"]);
$photoType=mysqli_escape_string($con, $_FILES["uPhoto"]["type"]);
$photoSize=mysqli_escape_string($con, $_FILES["uPhoto"]["size"]);

//file type check
if ((($photoType == "image/gif")
    || ($photoType == "image/jpeg")
    || ($photoType == "image/jpg")
    || ($photoType == "image/pjpeg")
    || ($photoType == "image/x-png")
    || ($photoType == "image/png"))
&& ($photoSize < 5000000) //file size under 5mb
&& in_array($extension, $allowedExts)){
    if ($_FILES["uPhoto"]["error"] > 0)  {
        echo "Return Code: " . $_FILES["uPhoto"]["error"] . "<br>";
    }
    else{
        echo "Upload: " . $photoName . "<br>";
        echo "Type: " . $photoType . "<br>";
        echo "Size: " . ($photoSize / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["uPhoto"]["tmp_name"] . "<br>"; //temp store area

    // automatic overwrite
    //   if (file_exists("" . $directory . $photoName)){
    //     echo $photoName . " already exists. ";
    // }
    // else{
    //update database
    $db_name="core"; // Database name
    $table_name="photo"; // Table name
    $url = reset((explode('?', "photoManage.php"))); //get rid of queries

    $type_id=mysqli_escape_string($con, $_POST['type_id']);
    $event_id=mysqli_escape_string($con, $_POST['event_id']);
    $directory = "images/" . $event_id . "/";
    $path=$directory . $photoName;
    $name=mysqli_escape_string($con, $_POST['photo_name']);
    $description=mysqli_escape_string($con, $_POST['description']);

    //if cover photo
    if($type_id == '1'){
        $query = "SELECT PHOTO_ID FROM core.photo WHERE photo_type_id = $type_id AND event_id = $event_id";
        $result=mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
            $row=mysqli_fetch_array($result);
            $pid=$row['PHOTO_ID'];
            $query = "UPDATE $db_name.$table_name SET PATH = '$path' WHERE photo_id = $pid";
        }
        else{
            $query = "INSERT INTO core.photo(PHOTO_TYPE_ID, EVENT_ID, PATH, NAME, DESCRIPTION) ";
            $query .= "VALUES ('$type_id', '$event_id', '$path', '$name', '$description')";    
        }
    }
    else{
        $query = "INSERT INTO core.photo(PHOTO_TYPE_ID, EVENT_ID, PATH, NAME, DESCRIPTION) ";
        $query .= "VALUES ('$type_id', '$event_id', '$path', '$name', '$description')";
    }
    echo $query;
    echo "<br>";
    if (!mysqli_query($con,$query)){
        die('Error: ' . mysqli_error($con));
        // header('Location: ' . $url . "?success=1");
    }
    else{
        //make directory
        if(!is_dir($directory) ){
            mkdir($directory);
        }
        //move file
        move_uploaded_file($_FILES["uPhoto"]["tmp_name"], $path);
        echo "Stored in: " . $path;
        header('Location: ' . $url . "?success=0");
    }
    mysqli_close($con);
    // }
}
}
else{
  echo "Invalid file";
}
?> 