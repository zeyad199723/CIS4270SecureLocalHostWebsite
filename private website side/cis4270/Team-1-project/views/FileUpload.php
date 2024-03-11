<?php
	require_once('views/FileUploadFunction.php');
?>

<html>
	<head>
	<title>File Upload Example</title>
	</head>
	<body>
	<form action="FileUpload.php" method="POST" enctype="multipart/form-data">
            <p>Choose a photo for your profile picture:</p>
            <input type="file" name="profile_picture" /><br />
            <input type="submit" name="submit" value="Upload file" />
</form>
		<?php

if (isset($_POST['submit'])) {
	$originalFilename = $_FILES['profile_picture']['name'];
	$targetPath = __DIR__ . "/" . $originalFilename;
  
	if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
	  echo "File uploaded successfully as " . $originalFilename;
	} else {
	  echo "Error uploading file.";
	}
  }


// Inspect the values PHP retrieves in $_FILES
echo "<hr />";
var_dump($_FILES);
echo "<hr />";

?>
	</body>
</html>
