<?php
$files = [
    'application/views/staf/index.php',
    'application/views/sdm/index.php',
    'application/views/kaur/index.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $c = file_get_contents($file);
    
    // Add IDs to passwords in ubah-pass only.
    $replacement = <<<'EOF'
                           <div class="form-group">
                               <label>Ulang Password</label>
                               <input type="password" class="form-control form-control-sm pass-toggle" name="new_password2" placeholder="Ketik ulang password baru" required>
                           </div>
                           <div class="form-group custom-control custom-checkbox small">
                               <input type="checkbox" class="custom-control-input" id="checkPass" onclick="togglePass()">
                               <label class="custom-control-label" for="checkPass" style="cursor:pointer;">Tampilkan Password</label>
                           </div>
                           <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                           <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
       <script>
       function togglePass() {
           var elements = document.getElementsByClassName("pass-toggle");
           for(var i=0; i<elements.length; i++) {
               if(elements[i].type === "password") {
                   elements[i].type = "text";
               } else {
                   elements[i].type = "password";
               }
           }
       }
       </script>
EOF;

    // First replace the input classes
    $c = str_replace(
        '<input type="password" class="form-control form-control-sm" name="current_password" required>',
        '<input type="password" class="form-control form-control-sm pass-toggle" name="current_password" required>',
        $c
    );
    $c = str_replace(
        '<input type="password" class="form-control form-control-sm" name="new_password1" required>',
        '<input type="password" class="form-control form-control-sm pass-toggle" name="new_password1" required>',
        $c
    );
    
    // Now replace the end form area:
    // Regex because whitespace might be different
    $c = preg_replace(
        '/<div class="form-group">\s*<label>Ulang Password<\/label>\s*<input type="password" class="form-control form-control-sm" name="new_password2" placeholder="Ketik ulang password baru" required>\s*<\/div>\s*<button type="submit" class="btn btn-primary">Simpan Perubahan<\/button>\s*<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup<\/button>\s*<\/form>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/s',
        $replacement,
        $c
    );

    file_put_contents($file, $c);
}
echo "Done";
