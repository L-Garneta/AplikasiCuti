<?php

$f = 'application/views/staf/index.php';
$c = file_get_contents($f);

// Find the section that outputs Status Cuti
$pattern = '/<\?php else : \?> <\?php if \(\$sisa_cuti\[\'is_approve\'\] == 2\) : \?> .*?<\?php endif; \?>\s*<\/ul>\s*<\?php endif; \?>/is';

$replacement = <<<EOF
<?php else : ?>
                                   <?php if (\$sisa_cuti['is_approve'] == 2) : ?>
                                        <div class="alert alert-danger shadow-sm border-left-danger" role="alert">
                                            <h5 class="text-danger font-weight-bold mb-2"><i class="fas fa-times-circle"></i> CUTI DITOLAK</h5>
                                            <div class="text-dark mb-3" style="font-size: 15px; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;"><strong>Alasan Penolakan:</strong><br> <?php echo \$sisa_cuti['alasan_ditolak'] ?? '-'; ?></div>
                                            <a href="<?php echo base_url('staf/add_cuti'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-redo"></i> Ajukan Ulang</a>
                                        </div>
                                   <?php else : ?>
                                       <ul>
                                           <li> Tanggal :<strong> <?php echo \$sisa_cuti['cuti'] ?? '-'; ?></strong> </li>
                                           <li> Keterangan : <strong> <?php echo \$sisa_cuti['keterangan'] ?? '-'; ?></strong></li>
                                           <li> Ambil Cuti : <strong> <?php echo \$sisa_cuti['jml_cuti'] ?? 0; ?> hari</strong></li>
                                           <li> Sisa Cuti : <strong> <?php echo \$sisa_cuti['sisa_cuti'] ?? 0; ?> hari</strong></li>
                                           <?php if (\$sisa_cuti['is_approve'] == 1) : ?>
                                               <li><strong>Status : </strong><strong><span class="font-weight-bolder" style="font-size:18px;">Menunggu</span></strong><br>
                                                   <strong><a href="<?php echo base_url(); ?>staf/edit_cuti/<?php echo \$sisa_cuti['id'] ?? 0; ?>" class="btn btn-dark btn-sm mt-2"><i class="fas fa-edit"></i> Edit Data</a></strong></li>
                                           <?php else : ?>
                                               <li>Status : <strong><span class="font-weight-bolder" style="font-size:18px;">Disetujui</span></strong><br>
                                                   <a class="btn btn-primary btn-sm mt-2" href="<?php echo base_url(); ?>staf/cetak_data/<?php echo \$sisa_cuti['id']; ?>" target="_blank" role="button"><i class="fas fa-print"></i> Cetak Data</a>
                                               </li>
                                           <?php endif; ?>
                                       </ul>
                                   <?php endif; ?>
                               <?php endif; ?>
EOF;

$c = preg_replace($pattern, $replacement, $c);
file_put_contents($f, $c);
echo "Staf CSS and HTML fixed.\n";
