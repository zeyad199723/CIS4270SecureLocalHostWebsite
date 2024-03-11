<?php
	require_once('FileUploadFunction.php');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<html>
	<head>
		<title>File Upload Example</title>
	</head>
	<body>
		<form id="uploadForm" action="" method="POST" enctype="multipart/form-data" >
			<p>Choose a photo for your profile picture:</p>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
			<input type="file" name="imageFile" id="imageFile"  onchange="processFileUpload()"/><br />
			<input type="submit" name="submit" value="Upload file" id="submitButton"/>
		</form>
		<p id="responseParagraph"></p>
		<p id="responseParagraph2"></p>

		<script>
			var status ;
            function processFileUpload() {
				
  // Perform the desired actions when the file input is changed
  // (e.g., validate file size, preview image, etc.)

  // Send an AJAX request to the PHP script to handle file processing
  var formData = new FormData(document.getElementById('uploadForm'));
  $.ajax({
    url: 'FileUploadFunction.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
      // Update the paragraph with the response from the PHP script
      document.getElementById('responseParagraph').innerHTML = response;
	  if (response.includes('Error: ')) {
        // Handle the error situation
        document.getElementById('responseParagraph2').innerHTML = 'An error occurred during file processing.';
		disableButton();
		
      } else {
        // Handle the successful response
        document.getElementById('responseParagraph2').innerHTML = 'File uploaded successfully.';
		enableButton();
		
      }
    }
  });
 
}

function disableButton() {
  const buttonElement = document.getElementById('submitButton');
  buttonElement.disabled = true;
}

function enableButton() {
  const buttonElement = document.getElementById('submitButton');
  buttonElement.disabled = false;
}

        </script>



<?php



// Inspect the values PHP retrieves in $_FILES
echo "<hr />";
var_dump($_FILES);
echo "<hr />";

upload_file('profile_picture');

?>
	</body>
</html>
