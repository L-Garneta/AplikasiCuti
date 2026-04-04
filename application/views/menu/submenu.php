   <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <!------ Include the above in your HEAD tag ---------->

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>


   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Page Heading -->
       <h5 class="h5 mb-4 text-gray-800"><strong><?= $title; ?></strong></h5>
       <div class="row">
           <div class="col-lg">
               <?php if (validation_errors()) : ?>
                   <div class="alert alert-danger" role="alert">
                       <?php echo validation_errors(); ?>
                   </div>
               <?php endif; ?>

               <?php echo $this->session->flashdata('message'); ?>

               <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>
               <table class="table table-hover">
                   <thead>
                       <tr>
                           <th scope="col">#</th>
                           <th scope="col">Title</th>
                           <th scope="col">Menu</th>
                           <th scope="col">URL</th>
                           <th scope="col">Icon</th>
                           <th scope="col">Active</th>
                           <th scope="col">Action</th>

                       </tr>
                   </thead>
                   <tbody>
                       <?php $i = 1; ?>
                       <?php foreach ($subMenu as $sm) : ?>
                           <tr>
                               <th scope="row"><?php echo $i++; ?></th>
                               <td><?php echo $sm['title']; ?></td>
                               <td><?php echo $sm['menu']; ?></td>
                               <td><?php echo $sm['url']; ?></td>
                               <td><?php echo $sm['icon']; ?></td>
                               <td><?php echo $sm['is_active']; ?></td>
                               <td>
                                   <a href="" class="badge badge-pill badge-success" style="font-size:14px;">edit</a>
                                   <a href="" class="badge badge-pill badge-danger" style="font-size:14px;">delete</a>
                               </td>

                           </tr>
                       <?php endforeach; ?>

                   </tbody>
               </table>
           </div>
       </div>


   </div>
   <!-- /.container-fluid -->



   <!-- End of Main Content -->

   <!-- Button trigger modal -->

   <!-- Modal -->
   <div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="newSubMenuModalLabel">New Sub Menu</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form action="<?php echo base_url('menu/submenu'); ?>" method="post">
                   <div class="modal-body">
                       <div class="form-group">
                           <input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu Name">
                       </div>
                       <div class="form-group">
                           <select name="menu_id" id="menu_id" class="form-control">
                               <option value="">Select Menu</option>
                               <?php foreach ($menu as $m) : ?>
                                   <option value="<?php echo $m['id']; ?>">
                                       <?php echo $m['menu']; ?>
                                   </option>
                               <?php endforeach; ?>
                           </select>
                       </div>
                       <div class="form-group">
                           <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu URL">
                       </div>
                       <div class="form-group">
                           <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon">
                       </div>
                       <div class="form-group">
                           <div class="form-check">
                               <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                               <label class="form-check-label" for="is_active">
                                   Active ?
                               </label>
                           </div>
                       </div>

                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">Add Sub Menu</button>
                   </div>

               </form>

           </div>
       </div>
   </div>