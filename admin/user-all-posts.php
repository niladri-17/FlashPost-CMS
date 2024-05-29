<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>All posts</b></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <div class="d-flex justify-content-end mb-3">
          <div>
            <a href="#deleteUserModal" class="btn btn-danger" data-toggle="modal"><i class="fas fa-minus-circle"></i>
              <span>Delete post</span></a>
          </div>
        </div>
        <table class="table table-bordered" id="user-posts" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll" />
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>ID</th>
              <th>Title</th>
              <th>Image</th>
              <th>Content</th>
              <th>Category</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <span class="custom-checkbox">
                  <input type="checkbox" id="checkbox1" name="options[]" value="1" />
                  <label for="checkbox1"></label>
                </span>
              </td>
              <td>1</td>
              <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut, perspiciatis.</td>
              <td><img src="img/featured-1.jpg" alt="" width="150px"></td>
              <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Asperiores, et amet quos soluta culpa voluptatum eaque commodi eos, modi nisi, eligendi tempore ipsum hic repellat iusto placeat rerum debitis deserunt molestias incidunt quis deleniti dolores aut velit.</td>
              <td>Technology</td>
              <td>16th May 2024 at 00:22:40</td>
              <td class="d-flex justify-content-around">
                <a href="#editUserModal" class="edit" data-toggle="modal"><i class="fas fa-edit" style="color: #cfc914"></i></a>
                <a href="#deleteUserModal" class="delete" data-toggle="modal"><i class="fas fa-trash" style="color: #cb1010"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div id="editUserModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h4 class="modal-title">Edit User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" required />
          </div>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Username" required />
          </div>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" required />
          </div>
          <div class="form-group">
            <input type="text" class="form-control phone-mask" placeholder="Phone no." />
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" />
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm password" />
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
          <input type="submit" class="btn btn-info" value="Save" />
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="deleteUserModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h4 class="modal-title">Delete Post</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete these posts?</p>
          <p class="text-warning">
            <small>This action cannot be undone.</small>
          </p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
          <input type="submit" class="btn btn-danger" value="Delete" />
        </div>
      </form>
    </div>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>