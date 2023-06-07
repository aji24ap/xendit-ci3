<!DOCTYPE html>
<html>
   <head>
      <title id="info-my">Pembayaran System</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <style>
         body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
        }
      </style>
   </head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <div class="container">
            <a class="navbar-brand" href="#">Test Pembayaran System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link" href="<?php echo base_url().'Payment'; ?>">Tambah Transaksi</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="<?php echo base_url().'Payment/data_transaksi'; ?>">Data Transaksi</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <?php if ($this->session->flashdata('error')) : ?>
      <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
      <?php endif; ?>
      <div class="container">
         <h1 class="mt-5">Xendit Test Pembayaran</h1>
         <?php foreach($payments as $t){ ?>
         <form method="post" action="<?php echo site_url('payment/bayar_ulang'); ?>" class="mt-4">
            <div class="mb-3">
               <label for="external_id" class="form-label">External ID:</label>
               <input type="text" name="external_id" class="form-control" value="<?php echo $t->external_id ?>" readonly>
            </div>
            <div class="mb-3">
               <label for="amount" class="form-label">Harga:</label>
               <input type="number" name="amount" class="form-control" value="<?php echo $t->amount ?>" readonly>
            </div>
            <div class="mb-3">
               <label for="payer_email" class="form-label">Email:</label>
               <input type="email" name="payer_email" class="form-control" value="<?php echo $t->payer_email ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Test Bayar</button>
            <?php } ?>
         </form>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.9/sweetalert2.all.min.js" integrity="sha512-WjATfZfsXsso7OWo2YzqeVvqhQbj41pURxSgRdt8uHZ3Q2s+awJU8ITuEZwRKR8TnLmMuc+RuADtKsseE05Rww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="<?php echo base_url().'assets/'; ?>javascript/alert.js"></script>
   </body>
</html>