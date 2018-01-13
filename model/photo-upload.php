<?php
/**
 * This file contains the logic for moving a photo to the server
 *
 * This file is to handle requestions on the front-end and decide
 * what should happen next, whether it be forwarding the user to another page,
 * back to where they where previously, or pull/push data to/from the back-end. 
 *
 * PHP version 7
 *
 * LICENSE: Infomation here. 
 *
 * @author     Jacob Laqua <jlaqua@mail.greenriver.edu>
 * @author     Dmitriy Drkhipchuk <Darkhipchuk@mail.greenriver.edu>
 * @author     Angelo Blanchard <ablanchard3@mail.greenriver.edu>
 * @version    1.0 GitHub: <https://github.com/GreenRiverSoftwareDevelopment/techies>
 * @link       http://techies.greenrivertech.net
 */

    function handleImage()
    {
        $target_dir = "images/users/";
        $target_file = $target_dir . time() . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        //errors array 
        $errors = array();
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $errors[] = "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $errors[] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 40000000) { //5MB
            $errors[] =  "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errors[] =  "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errors[] =  "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                /*echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."*/                                
                return $target_file;
            } else {
                $errors[] =  "Sorry, there was an error uploading your file.";
                return $errors;
            }
        }
    }
?>