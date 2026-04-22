<?php
$file = 'c:\\xampp\\htdocs\\AplikasiCuti\\application\\views\\sdm\\list_kary.php';
$content = file_get_contents($file);

// Add button to card header
$content = str_replace(
    '<h5 class="card-header"> <strong><?= $title; ?></strong></h5>',
    '<h5 class="card-header"> <strong><?= $title; ?></strong> <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#hitung-gaji"><i class="fas fa-calculator"></i> Hitung Gaji</button></h5>',
    $content
);

// Append Modal and JS
$append = <<<'EOD'

<!-- Modal Hitung Gaji -->
<div class="modal fade" id="hitung-gaji" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-calculator"></i> Kalkulator Gaji Bersih</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formHitungGaji">
                    <div class="form-group">
                        <label>Pilih Pegawai</label>
                        <select name="id_pegawai" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($pegawai as $p) : ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> (<?= $p['nik'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control" required>
                                    <option value="">- Bulan -</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control" required>
                                    <option value="">- Tahun -</option>
                                    <?php 
                                        $yr = date('Y');
                                        for($i=0; $i<5; $i++): 
                                    ?>
                                        <option value="<?= $yr-$i ?>"><?= $yr-$i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gaji Pokok (Rp)</label>
                        <input type="number" class="form-control" name="gaji_pokok" placeholder="Contoh: 3000000" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="btnHitung">Hitung</button>
                </form>

                <div id="hasilHitung" class="mt-4" style="display:none;">
                    <h6 class="font-weight-bold text-center border-bottom pb-2">Hasil Perhitungan</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Total Cuti (Potong Gaji)</td>
                            <td>:</td>
                            <td class="font-weight-bold"><span id="res_total_cuti"></span> Hari</td>
                        </tr>
                        <tr>
                            <td>Gaji Pokok</td>
                            <td>:</td>
                            <td class="font-weight-bold">Rp <span id="res_gaji_pokok"></span></td>
                        </tr>
                        <tr>
                            <td>Total Potongan</td>
                            <td>:</td>
                            <td class="font-weight-bold text-danger">- Rp <span id="res_potongan"></span></td>
                        </tr>
                        <tr class="border-top">
                            <td class="font-weight-bold">Gaji Bersih</td>
                            <td class="font-weight-bold">:</td>
                            <td class="font-weight-bold text-success h5">Rp <span id="res_gaji_bersih"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#formHitungGaji').on('submit', function(e) {
    e.preventDefault();
    $('#btnHitung').html('<i class="fas fa-spinner fa-spin"></i> Menghitung...').prop('disabled', true);
    
    $.ajax({
        url: '<?= base_url('sdm/hitung_gaji_ajax') ?>',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            if(res.status == 'success') {
                $('#res_total_cuti').text(res.total_cuti);
                $('#res_gaji_pokok').text(res.gaji_pokok);
                $('#res_potongan').text(res.potongan);
                $('#res_gaji_bersih').text(res.gaji_bersih);
                $('#hasilHitung').slideDown();
            } else {
                alert(res.message);
            }
            $('#btnHitung').html('Hitung').prop('disabled', false);
        },
        error: function() {
            alert('Terjadi kesalahan sistem.');
            $('#btnHitung').html('Hitung').prop('disabled', false);
        }
    });
});
</script>
EOD;

file_put_contents($file, $content . $append);
echo "Appended list_kary.php";
?>
