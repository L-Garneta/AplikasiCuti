   <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <!------ Include the above in your HEAD tag ---------->

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>


   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->

       <div class="card">
           <h5 class="card-header"><strong><?= $title; ?></strong></h5>
           <div class="card-body">
               <div class="row">
                   <div class="col-md-12">
                       <?php echo form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                       <?php echo $this->session->flashdata('message'); ?>
                       <a href="" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>
                       <table class="table table-hover" style="font-size:12px;">
                           <thead>
                               <tr>
                                   <th scope="col">#</th>
                                   <th scope="col">Role</th>
                                   <th scope="col">Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               <?php $i = 1; ?>
                               <?php foreach ($role as $r) : ?>
                                   <tr>
                                       <th scope="row"><?php echo $i++; ?></th>
                                       <td><?php echo $r['role']; ?></td>
                                       <td>
                                           <a href="<?php echo base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-info" style="font-size:14px;">Access</a>
                                           <a href="" class="badge badge-success" style="font-size:14px;">edit</a>
                                           <a href="" class="badge badge-danger" style="font-size:14px;">delete</a>
                                       </td>
                                   </tr>
                               <?php endforeach; ?>
                           </tbody>
                       </table>
                   </div>

               </div>
           </div>
       </div>







   </div>
   <!-- /.container-fluid -->


   <!-- End of Main Content -->

   <!-- Button trigger modal -->

   <!-- Modal -->
   <div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form action="<?php echo base_url('admin/role'); ?>" method="post">
                   <div class="modal-body">
                       <div class="form-group">
                           <input type="text" class="form-control" id="role" name="role" placeholder="Role Name">
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">Add Role</button>
                   </div>

               </form>

           </div>
       </div>
   </div>