   <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <!------ Include the above in your HEAD tag ---------->

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>


   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->
       <h5 class="h5 mb-4 text-gray-800"><strong><?= $title; ?></strong></h5>
       <div class="row">
           <div class="col-lg-6">

               <?php echo $this->session->flashdata('message'); ?>
               <h5>Level : <?php echo $role['role']; ?></h5>

               <table class="table table-hover">
                   <thead>
                       <tr>
                           <th scope="col">#</th>
                           <th scope="col">Menu</th>
                           <th scope="col">Access</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php $i = 1; ?>
                       <?php foreach ($menu as $m) : ?>
                           <tr>
                               <th scope="row"><?php echo $i++; ?></th>
                               <td><?php echo $m['menu']; ?></td>
                               <td>
                                   <div class="form-check">
                                       <input class="form-check-input" type="checkbox" <?php echo check_access($role['id'], $m['id']); ?> data-role="<?php echo $role['id']; ?>" data-menu="<?php echo $m['id']; ?>">
                                   </div>
                               </td>
                           </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           </div>
       </div>

   </div>
   <!-- /.container-fluid -->

   <script>
       $('.form-check-input').on('change', function() {
           const menuId = $(this).data('menu');
           const roleId = $(this).data('role');
           $.ajax({
               url: "<?php echo base_url('admin/changeaccess'); ?>",
               type: 'post',
               data: {
                   menuId: menuId,
                   roleId: roleId
               },
               success: function() {
                   document.location.href = "<?php echo base_url('admin/roleaccess/'); ?>" + roleId;
               }
           });
       });
   </script>

   <!-- End of Main Content -->