<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Manage posts</b></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="manage-posts" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll" />
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>ID</th>
              <th>Name</th>
              <th>Username</th>
              <th>Title</th>
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
              <td>Thomas Hardy</td>
              <td>THardy123</td>
              <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, facere?</td>
              <td>16th May 2024 at 00:22:40</td>
              <td class="d-flex justify-content-around">
                <a href="user-posts.html">See post</a>
              </td>
            </tr>
            <tr>
              <td>
                <span class="custom-checkbox">
                  <input type="checkbox" id="checkbox1" name="options[]" value="1" />
                  <label for="checkbox1"></label>
                </span>
              </td>
              <td>1</td>
              <td>Thomas Hardy</td>
              <td>THardy123</td>
              <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, facere?</td>
              <td>17th May 2024 at 00:22:34</td>
              <td class="d-flex justify-content-around">
                <a href="user-posts.html">See post</a>
              </td>
            </tr>
            <tr>
              <td>
                <span class="custom-checkbox">
                  <input type="checkbox" id="checkbox1" name="options[]" value="1" />
                  <label for="checkbox1"></label>
                </span>
              </td>
              <td>1</td>
              <td>Thomas Hardy</td>
              <td>THardy123</td>
              <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, facere?</td>
              <td>17th May 2024 at 00:22:38</td>
              <td class="d-flex justify-content-around">
                <a href="user-posts.html">See post</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal HTML -->
<div id="addUserModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h4 class="modal-title">Add User</h4>
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
          <input type="submit" class="btn btn-success" value="Add" />
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal HTML -->
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

<!-- Delete Modal HTML -->
<div id="deleteUserModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h4 class="modal-title">Delete User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete these Records?</p>
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