<?php
$f = 'application/views/staf/index.php';
$c = file_get_contents($f);
$c = str_replace(
'<input type="text" class="form-control form-control-sm" name="username" value="<?php echo $user[\'username\']; ?>" readonly>',
'<input type="text" class="form-control form-control-sm" name="username" value="<?php echo $user[\'username\']; ?>" required>',
$c);
$c = str_replace(
'<input type="text" class="form-control form-control-sm" name="nik" value="<?php echo $user[\'nik\']; ?>" readonly>',
'<input type="text" class="form-control form-control-sm" name="nik" value="<?php echo $user[\'nik\']; ?>" required>',
$c);
file_put_contents($f, $c);
