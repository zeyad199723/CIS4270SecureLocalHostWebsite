<?php
// Form upload functions

// Configuration

// Use MAX_FILE_SIZE in your form but don't trust it.
// Check it again in your application
$max_file_size = 1048576; // 1 MB expressed in bytes

// Where to store uploaded files?
// Choose a directory outside of the public path, unless the file 
// should be publicly visible/accessible.
// Examples:
//   job application => private
//   website profile photo => public
// Of course, when outside the public path, you need PHP code that can
// access those files. The browser can't access them directly.
$upload_path = "C:\Apache\htdocs\Team-1-Project\picturesuploaded";

// Define allowed filetypes to check against during validations
$allowed_mime_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
$allowed_extensions = ['png', 'gif', 'jpg', 'jpeg'];

$check_is_image = true;
$check_for_php = true;

upload_file('imageFile');

// Provides plain-text error messages for file upload errors.
function file_upload_error($error_integer) {
	$upload_errors = array(
		// http://php.net/manual/en/features.file-upload.errors.php
		UPLOAD_ERR_OK 				=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);
	return $upload_errors[$error_integer];
}

// Sanitizes a file name to ensure it is harmless
function sanitize_file_name($filename) {
	// Remove characters that could alter file path.
	// I disallowed spaces because they cause other headaches.
	// "." is allowed (e.g. "photo.jpg") but ".." is not.
	$filename = preg_replace("/([^A-Za-z0-9_\-\.]|[\.]{2})/", "", $filename);
	// basename() ensures a file name and not a path
	$filename = basename($filename);
	return $filename;
}

// Returns the file permissions in octal format.
function file_permissions($file) {
	// fileperms returns a numeric value
	$numeric_perms = fileperms($file);
	// but we are used to seeing the octal value
	$octal_perms = sprintf('%o', $numeric_perms);
	return substr($octal_perms, -4);
}

// Returns the file extension of a file
function file_extension($file) {
	$path_parts = pathinfo($file);
	return $path_parts['extension'];
}

// Searches the contents of a file for a PHP embed tag
// The problem with this check is that file_get_contents() reads 
// the entire file into memory and then searches it (large, slow).
// Using fopen/fread might have better performance on large files.
function file_contains_php($file) {
	$contents = file_get_contents($file);
	$position = strpos($contents, '<?php');
	return $position !== false;
}


// Runs file being uploaded through a series of validations.
// If file passes, it is moved to a permanent upload directory
// and its execute permissions are removed.
function upload_file($field_name) {
	global $upload_path, $max_file_size, $allowed_mime_types, $allowed_extensions, $check_is_image, $check_for_php;
	
	if(isset($_FILES[$field_name])) {

		// Sanitize the provided file name.
		$file_name = sanitize_file_name($_FILES[$field_name]['name']);
		$file_extension = file_extension($file_name);
		
		// Even more secure to assign a new name of your choosing.
		// Example: 'file_536d88d9021cb.png'
		// $unique_id = uniqid('file_', true); 
		// $new_name = "{$unique_id}.{$file_extension}";
		
		$file_type = $_FILES[$field_name]['type'];
		$tmp_file = $_FILES[$field_name]['tmp_name'];
		$error = $_FILES[$field_name]['error'];
		$file_size = $_FILES[$field_name]['size'];

		// Prepend the base upload path to prevent hacking the path
		// Example: $file_name = '/etc/passwd' becomes harmless
		$file_path = $upload_path . '/' . $file_name;

		if($error > 0) {
			// Display errors caught by PHP
			echo "Error: " . file_upload_error($error);
		
		} elseif(!is_uploaded_file($tmp_file)) {
			echo "Error: Does not reference a recently uploaded file.<br />";	

		} elseif($file_size > $max_file_size) {
			// PHP already first checks php.ini upload_max_filesize, and 
			// then form MAX_FILE_SIZE if sent.
			// But MAX_FILE_SIZE can be spoofed; check it again yourself.
			echo "Error: File size is too big.<br />";

		} elseif(!in_array($file_type, $allowed_mime_types)) {
			echo "Error: Not an allowed mime type.<br />";

		} elseif(!in_array($file_extension, $allowed_extensions)) {
			// Checking file extension prevents files like 'evil.jpg.php' 
			echo "Error: Not an allowed file extension.<br />";
		
		} elseif($check_is_image && (getimagesize($tmp_file) === false)) {
			// getimagesize() returns image size details, but more importantly,
			// returns false if the file is not actually an image file.
			// You obviously would only run this check if expecting an image.
			echo "Error: Not a valid image file.<br />";

		} elseif($check_for_php && file_contains_php($tmp_file)) {
			// A valid image can still contain embedded PHP.
			echo "Error: File contains PHP code.<br />";
	
		} elseif(file_exists($file_path)) {
			// if destination file exists it will be over-written
			// by move_uploaded_file()
			echo "Error: A file with that name already exists in target location.<br />";
			// Could rename or force user to rename file.
			// Even better to store in uniquely-named subdirectories to
			// prevent conflicts.
			// For example, if the database record ID for an image is 1045: 
			// "/uploads/profile_photos/1045/uploaded_image.png"
			// Because no other profile_photo has that ID, the path is unique.

		} else {
		
			// Success!
			echo "File was uploaded without errors.<br />";
			echo "File name is '{$file_name}'.<br />";
			echo "File references an uploaded file.<br />";

			// Two ways to get the size. Should always be the same.
			echo "Uploaded file size was {$file_size} bytes.<br />";
			// filesize() is most useful when not working with uploaded files.
			$tmp_filesize = filesize($tmp_file); // always in bytes
			echo "Temp file size is {$tmp_filesize} bytes.<br />";

			echo "Temp file location: {$tmp_file}<br />";
		

			// move_uploaded_file has is_uploaded_file() built-in
			if(move_uploaded_file($tmp_file, $file_path)) {
				echo "File moved to: {$file_path}<br />";

				// remove execute file permissions from the file
				if(chmod($file_path, 0644)) {
					echo "Execute permissions removed from file.<br />";
					$file_permissions = file_permissions($file_path);
					echo "File permissions are now '{$file_permissions}'.<br />";
				} else {
					echo "Error: Execute permissions could not be removed.<br />";
				}

			}
		}
	
	}

}

?>
