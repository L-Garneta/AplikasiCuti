   <!-- Begin Page Content -->
   <div class="container-fluid">
       <!-- Page Heading -->
       <div class="card">
           <div class="card-header">
               <strong><?= $title; ?></strong>
           </div>
           <div class="card-body">
               <div class="row">
                   <form class="form-inline" action="<?php echo base_url('staf/view_cutitahunan'); ?>" method="post">
                       <a href="javascript:window.history.go(-1);" class="btn btn-info btn-sm mr-2">Kembali</a>
                       <a href="<?php echo base_url('staf/history'); ?>" class="btn btn-secondary btn-sm mr-4">View Cuti</a>
                       <input type="hidden" name="id_user" value="<?php echo $user['id']; ?>" />
                       <span class="font-weight-bold">Masukkan Tahun &nbsp&nbsp </span>
                       <select name="tahun" class="form-control-sm">
                           <?php
                            $mulai = date('Y') - 2;
                            for ($i = $mulai; $i < $mulai + 5; $i++) {
                                $sel = $i == date('Y') ? ' selected="selected"' : '';
                                echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                            }
                            ?>
                       </select>
                       <button type="submit" class="btn btn-primary btn-sm ml-1"> Proses</button>
                   </form>
                   <table class="table table-hover mt-2" style="font-size:13px;">
                       <thead>
                           <tr>
                               <th scope="col">#</th>
                               <th scope="col">Tgl Input</th>
                               <th scope="col">Jenis Cuti</th>
                               <th scope="col">Keterangan</th>
                               <th scope="col">Cuti Diambil</th>
                               <th scope="col">Sisa Cuti</th>
                               <th scope="col">Cuti 1</th>
                               <th scope="col">Cuti 2</th>
                               <th scope="col">Masuk Kerja</th>
                               <th scope="col">Status</th>
                           </tr>
                       </thead>
                       <?php $i = 1; ?>
                       <?php foreach ($user_cuti as $uc) : ?>
                           <tbody>
                               <tr>
                                   <th scope="row"><?php echo $i++; ?></th>
                                   <td><?php echo format_indo($uc['input']); ?></td>
                                   <td><?php echo ucfirst($uc['jenis_cuti']); ?></td>
                                   <td><?php echo ucfirst($uc['keterangan']); ?></td>
                                   <td><?php echo $uc['jml_cuti']; ?></td>
                                   <td><?php echo $uc['sisa_cuti']; ?></td>
                                   <td><?php echo format_indo($uc['cuti']); ?></td>
                                   <td><?php echo format_indo($uc['cuti2']); ?></td>
                                   <td><?php echo format_indo($uc['masuk']); ?></td>
                                   <?php if ($uc['is_approve'] == 1) : ?>
                                       <td><span class="badge badge-light" style="font-size:14px;">Menunggu</span></td>
                                   <?php elseif ($uc['is_approve'] == 2) : ?>
                                       <td><span class="badge badge-light" style="font-size:14px;">Ditolak</span></td>
                                   <?php else : ?>
                                       <td><span class="badge badge-light" style="font-size:14px;">Diterima</span></td>
                                   <?php endif; ?>
                               </tr>
                           </tbody>
                       <?php endforeach; ?>
                   </table>
               </div>
           </div>



       </div>
       <!-- /.container-fluid -->