   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->
       <div class="card">
           <div class="card-header">
               <strong><?= $title; ?></strong>
           </div>
           <div class="card-body">
               <form action="<?php echo base_url('menu/edit_menu/' . $menu['id']); ?>" method="post">
                   <div class="form-group row">
                       <label for="menu" class="col-sm-1 col-form-label">Menu</label>
                       <div class="col-sm-6">
                           <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
                           <input type="text" class="form-control" id="menu" name="menu" value="<?php echo $menu['menu']; ?>">
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="menu" class="col-sm-1 col-form-label"></label>
                       <div class="col-sm-6">
                           <button type="submit" class="btn btn-primary btn-sm">Update</button>
                       </div>
                   </div>
               </form>
           </div>
       </div>

   </div>
   <!-- /.container-fluid -->



   <!-- End of Main Content -->

   <!-- Button trigger modal -->

   <!-- Modal -->