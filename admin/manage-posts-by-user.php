<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Manage Posts</b></h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="manage-posts-by-user" width="100%" cellspacing="0">
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
              <th>Email</th>
              <th>No. of posts</th>
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
              <td>thomas@gmail.com</td>
              <td>3</td>
              <td class="d-flex justify-content-around">
                <a href="user-all-posts.php">See all posts</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>