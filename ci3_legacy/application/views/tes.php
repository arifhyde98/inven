<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('assets') ?>/modules/bootstrap/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <div class="mt-5">
            <div class="row">
                <div class="col-md-6">
                <?= validation_errors() ?>
                <?= $this->session->flashdata('pesan') ?>
                    <form action="<?= base_url('superadmin/tes') ?>" method="POST">
                        <input type="text" name="barcode" class="form-control" autofocus>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>