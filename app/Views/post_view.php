<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

</head>

<body>
    <div class="container">

        <div class="row justify-content-md-center mb-3">
            <h1 class="mt-2 mb-3">Upload Image in Summernote with CI4</h1>
            <div class="col-md-8">
                <form action="<?= base_url('post/save'); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label>Contents</label>
                        <textarea id="summernote" name="contents" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <?php foreach ($article as $data) : ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <h1><?= $data['title']; ?></h1>
                            <p><?= $data['contents']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        // Panggil fungsi untuk meng-upload gambar
                        uploadImage(files[0]);
                    },
                    onMediaDelete: function(target) {
                        deleteImage(target[0].getAttribute('data-filename'));
                    }
                }
            });
        });

        // Fungsi untuk meng-upload gambar menggunakan AJAX
        function uploadImage(file) {
            var formData = new FormData();
            formData.append('image', file);

            $.ajax({
                url: '<?php echo base_url("post/upload_image"); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(url) {
                    // Setel URL gambar yang sudah di-upload sebagai sumber gambar pada Summernote
                    $('#summernote').summernote('insertImage', url);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " - " + errorThrown);
                }
            });
        }

        function deleteImage(filename) {
            $.ajax({
                url: '<?php echo base_url("post/delete_image"); ?>',
                type: 'POST',
                data: {
                    filename: filename
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " - " + errorThrown);
                }
            });
        }
    </script>
</body>

</html>