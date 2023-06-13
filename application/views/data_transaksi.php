<!DOCTYPE html>
<html>
   <head>
      <title id="info-my">Data Transaksi</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>datatables/dataTables.bootstrap5.min.css">
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
      <div class="container">
         <h1 class="mt-5" >Data Transaksi</h1>
         <table id="bayar" class="table table-striped mt-4">
            <thead>
               <tr>
                  <th>No</th>
                  <th>External ID</th>
                  <th>Status</th>
                  <th>Pembayaran</th>
                  <th>Menggunakan</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1; foreach ($payments as $data) : ?>
               <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $data->external_id; ?></td>
                  <td>
                     <?php
                        $status = $data->status;
                        $badgeClass = '';
                        
                        switch ($status) {
                           case 'pending':
                              $badgeClass = 'badge bg-warning';
                              break;
                           case 'Sudah Dibayar':
                              $badgeClass = 'badge bg-success';
                              break;
                           case 'Expired':
                              $badgeClass = 'badge bg-danger';
                              break;
                           default:
                              $badgeClass = 'badge bg-secondary';
                              break;
                        }
                     ?>
                     <span class="<?php echo $badgeClass; ?>">
                     <?php echo $status; ?>
                     </span>
                  </td>
                  <td><?php echo $data->amount; ?></td>
                  <td><?php echo $data->pembayaran; ?></td>
                  <td>
                     <?php
                        if ($data->status == 'Sudah Dibayar') {
                            echo '<span class="badge text-bg-success">Transaksi Selesai</span>';
                        } elseif ($data->status == 'Expired') {
                            echo '<span class="badge text-bg-danger">Transaksi Kadaluarsa</span>';
                        } else {
                        ?>
                     <a class="btn btn-warning btn-sm btn-block" href="<?php echo base_url().'payment/bayar/'.$data->external_id; ?>">Bayar Transaksi</a>
                     <?php } ?>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.9/sweetalert2.all.min.js" integrity="sha512-WjATfZfsXsso7OWo2YzqeVvqhQbj41pURxSgRdt8uHZ3Q2s+awJU8ITuEZwRKR8TnLmMuc+RuADtKsseE05Rww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="<?php echo base_url().'assets/'; ?>javascript/jquery-3.7.0.js"></script>
      <script src="<?php echo base_url().'assets/'; ?>javascript/alert.js"></script>
      <script src="<?php echo base_url().'assets/'; ?>datatables/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url().'assets/'; ?>datatables/dataTables.bootstrap5.min.js"></script>
      <script>
         $(document).ready(function () {
               $('#bayar').DataTable();
         });
      </script>
   </body>
</html>