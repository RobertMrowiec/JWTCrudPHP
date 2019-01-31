<?php
    function uploadFile ($file, $name) {
        header("Content-Type: multipart/form-data; charset=UTF-8");
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
        
        $target_dir = "uploads/";
        $target_file = $target_dir.basename($file[$name]['name']);
        $target_type= explode('/', $file[$name]['type'])[1];
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $filename = 'file-'.time().'.'.$target_type;
        // Check if image file is a actual image or fake image
        $check = getimagesize($file[$name]["tmp_name"]);
        if($check !== false) {
            
            if ($file[$name]["size"] > 5000000) {
                // return 'Sorry, your file is too large';
                return json_encode([
                    'message' => "Sorry, your file is too large.",
                    'status' => false
                ]);
            }

            if(move_uploaded_file($file[$name]["tmp_name"], SITE_ROOT.'/'.'uploads/'.$filename)){
                return json_encode([
                    'message' => "The file ". basename( $file[$name]['name']). " has been uploaded.",
                    'status' => true,
                    'filename' => $filename
                ]);
            } else {
                // return 'Sorry, there was an error uploading your file';
                return json_encode([
                    'message' => "Sorry, there was an error uploading your file.",
                    'status' => false
                ]);
            }
            
        } else {
            return json_encode([
                'message' => "File is fake.",
                'status' => false
            ]);
            // return 'File is fake';
        }
    }
?>