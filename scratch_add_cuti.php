<?php
$f = 'application/views/staf/add_cuti.php';
$c = file_get_contents($f);

// 1. Change <option>Cuti Tahunan</option> to Cuti Bulanan
$c = str_replace('<option>Cuti Tahunan</option>', '<option>Cuti Bulanan</option>', $c);

// 2. Change jenis_cuti to Dropdown and add jml_cuti in Cuti Lain modal
// Old: <input type="text" class="form-control" id="keterangan" name="jenis_cuti" value="Cuti Lain" readonly>
// Oh, the old code in Cuti Lain modal has:
// <label for="keterangan">Jenis Cuti</label>
// <input type="text" class="form-control" id="keterangan" name="jenis_cuti" value="Cuti Lain" readonly>
$old_select = <<<EOF
							<div class="form-group col-md-6">
								<label for="keterangan">Jenis Cuti</label>
								<input type="text" class="form-control" id="keterangan" name="jenis_cuti"
									value="Cuti Lain" readonly>
							</div>
EOF;

// Since whitespace could be weird, let's use regex
$c = preg_replace(
    '/<div class="form-group col-md-6">\s*<label for="keterangan">Jenis Cuti<\/label>\s*<input type="text" class="form-control" id="keterangan" name="jenis_cuti"\s*value="Cuti Lain" readonly>\s*<\/div>/is',
    <<<EOF
                            <div class="form-group col-md-4">
                                <label for="jenis_cuti_lain">Jenis Cuti</label>
                                <select class="form-control" id="jenis_cuti_lain" name="jenis_cuti">
                                    <option>Cuti diluar jatah bulanan</option>
                                    <option>Cuti menikah</option>
                                    <option>Cuti sakit</option>
                                    <option>Cuti melahirkan</option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="jml_cuti_lain">Jml Cuti</label>
                                <input type="number" class="form-control" id="jml_cuti_lain" name="jml_cuti" min="1" required>
                            </div>
EOF,
    $c
);

file_put_contents($f, $c);
