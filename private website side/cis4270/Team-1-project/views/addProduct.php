<?php require('views/guitarShopAdminHeader.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<main>
<section>
    <h1 style="font-size: 40px; font-weight: bold; text-decoration: underline;">Listing Manager - Add Product</h1>


    <form id="uploadForm" action="" method="post" id="add_edit_product_form"  >
        <input type="hidden" name="ctlr" value="admin" />
        <input type="hidden" name="action" value="addProduct" />
        <?php echo csrf_token_tag(); ?>
        <label>Category:</label>
        <select name="categoryId">
        <?php foreach ($vm->categories as $category) { 
            if ($category->id == 1) {
                $selected = 'selected';
            } else {
                $selected = '';
            } ?>
            <option value="<?php echo $category->id; ?>" <?php
                      echo $selected ?>>
                <?php echo $category->name; ?>
            </option>
        <?php } ?>
        </select><br>

        <label>Name:</label>
        <input type="text" name="name"><br>

        <label>List Price:</label>
        <input type="text" name="price"><br>

        <label>Discount Percent:</label>
        <input type="text" name="discountPercent"><br>
        
        <label>Image File</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
        <input type="file" id="imageFile" name="imageFile" onchange="processFileUpload()" ><br>
        <!-- <input type="submit" value="Upload"> -->
        <p id="responseParagraph"></p>
		<p id="responseParagraph2"></p>
   


        <label>Description:</label>
        <textarea name="description" 
                  rows="10"></textarea><br>
        <br>
        <label>&nbsp;</label>
        <input type="submit" id="submitButton" value="Submit">
        
    </form>
    
    
    </div>
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
       
		disableButton();
		
      } else {
        // Handle the successful response
        
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
</section>
</main>
<?php require('views/guitarShopFooter.php');