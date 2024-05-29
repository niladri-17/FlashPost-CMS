<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Manage Users</b></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <div class="d-flex justify-content-end mb-3">
          <div>
            <a href="" class="btn btn-danger delete_multiple_user_btn" data-toggle="modal">
              <i class="fas fa-minus-circle"></i>
              <span>Delete Selected</span>
            </a>
          </div>
        </div>
        <table class="table table-bordered" id="manage-users" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll">
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>ID</th>
              <th>Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>User Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php manage_users(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->


<!-- Delete Modal HTML -->
<div id="deleteUserModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="confirm_delete_id">
        <p>Are you sure you want to delete these Records?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" data-dismiss="modal" value="Delete" id="delete-user">

        <?php delete_user(); ?>

        <?php delete_multiple_users_by_checkbox(); ?>

      </div>
    </div>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>