<body
    style="min-height:100vh; background: linear-gradient(to bottom, #003399, #4e73df, #f8f8f8); display:flex; justify-content:center; align-items:center;margin:0;">
    <div class="login-form">
        <form action="<?php echo base_url('auth'); ?>" method="post">
            <div class="form-header text-center" Style="font-size:18px;font-weight:700;padding-bottom:15px;">Halaman
                Login</div>
            <?php echo $this->session->flashdata('msg'); ?>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>"
                    placeholder=" Username" required>
                <?php echo form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <?php echo form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="login"><i class="fas fa-sign-in-alt"></i>
                    Login</button>
            </div>
        </form>
    </div>
</body>