<?php
echo ("DIEGO CASALLAS");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Add and Save CKEditor 5 data to MySQL database with PHP</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

  <style type="text/css">
    .ck-editor__editable {
      min-height: 250px;
    }
  </style>

</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-8 mt-5" style="margin: 0 auto;">

        <form method="post" action="">

          <div class="form-group mb-4">

            <label class="control-label col-sm-2" for="subject">Subject:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="subject" placeholder="Enter Subject" name="subject" value="">
            </div>

          </div>

          <div class="form-group mb-4">

            <label class="control-label col-sm-2" for="message">Message:</label>
            <div class="col-sm-10">
              <textarea id="editor" class="form-control editor" name="message"></textarea>
            </div>

          </div>

          <div class="form-group ">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-info" name="submit" value="Submit">
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>
  <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
  </script>
</body>

</html>