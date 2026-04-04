   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->
       <div class="card">
           <div class="card-header">
               <strong><?= $title; ?></strong>
           </div>
           <div class="card-body">
               <div class="col-md-8">
                   <form action="<?php echo base_url('menu/edit_submenu/' . $subMenu['id']); ?>" method="post">
                       <div class="form-group row">
                           <label for="inputPassword" class="col-sm-2 col-form-label">SubMenu</label>
                           <div class="col-sm-9">
                               <input type="hidden" name="id" value="<?php echo $subMenu['id']; ?>">
                               <input type="text" class="form-control" id="title" name="title" value="<?php echo $subMenu['title']; ?>">
                           </div>
                       </div>
                       <div class="form-group row">
                           <label for="inputPassword" class="col-sm-2 col-form-label">Menu</label>
                           <div class="col-sm-9">
                               <select name="menu_id" id="menu_id" class="form-control">
                                   <option value="<?php echo $subMenu['menu_id']; ?>"><?php echo $subMenu['menu']; ?></option>
                                   <?php foreach ($menu as $m) : ?>
                                       <option value="<?php echo $m['id']; ?>">
                                           <?php echo $m['menu']; ?>
                                       </option>
                                   <?php endforeach; ?>
                               </select>
                           </div>
                       </div>
                       <div class="form-group row">
                           <label for="inputPassword" class="col-sm-2 col-form-label">Url</label>
                           <div class="col-sm-9">
                               <input type="text" class="form-control" id="url" name="url" value="<?php echo $subMenu['url']; ?>">
                           </div>
                       </div>
                       <div class="form-group row">
                           <label for="inputPassword" class="col-sm-2 col-form-label">Icon</label>
                           <div class="col-sm-9">
                               <input type="text" class="form-control" id="icon" name="icon" value="<?php echo $subMenu['icon']; ?>">
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-2">
                           </div>
                           <div class="col-md-6">
                               <?php echo form_error('is_active', '<small class="text-danger pl-2">', '</small>'); ?>
                               <div class=" form-group">
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="is_active" id="inlineRadio1" value="1">
                                       <label class="form-check-label" for="inlineRadio1">Aktif</label>
                                   </div>
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="is_active" id="inlineRadio2" value="0">
                                       <label class="form-check-label" for="inlineRadio2">Tidak Aktif</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-2">
                           </div>
                           <div class="col-md-6">
                               <div class=" form-group">
                                   <button type="submit" class="btn btn-primary">Simpan</button>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>

   </div>
   <!-- /.container-fluid -->



   <!-- End of Main Content -->

   <!-- Button trigger modal -->

   <!-- Modal -->