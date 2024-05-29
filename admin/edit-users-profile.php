<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>
<?php
global $connection;
if (isset($_GET['id'])) {
  $edit_user_id = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $select_user_query = "SELECT * FROM users WHERE user_id = '$edit_user_id'";
  $selected_user_result = mysqli_query($connection, $select_user_query);

  $edit_user = mysqli_fetch_assoc($selected_user_result);

  if (isset($edit_user['user_image'])) {
    $edit_user_image = $edit_user['user_image'];
  } else {
    $edit_user_image = "user-profile-image.png";
  }
}
?>

<?php $redirect_url = 'admin/edit-users-profile.php?id=' . $edit_user_id  ?>

<?php profile_update($edit_user_id, $redirect_url); ?>
<?php change_password($edit_user_id, $redirect_url); ?>
<?php profile_image_update($edit_user_id, $redirect_url); ?>
<?php remove_profile_image($edit_user_id, $redirect_url); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Profile of <?= $edit_user['user_name'] ?></b></h1>

  <div class="row justify-content-center">
    <!-- left column -->

    <div class="col-md-3 mb-3">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="text-center">
          <img src="<?= ROOT_URL . 'images/' . $edit_user_image ?>" style="height: 200px; width:200px; object-fit:cover; border-radius:50%;border:2px solid grey;" class="avatar img-circle m-2" alt="avatar">
          <input name="user-image" type="file" class="form-control" value=<?= "\"$user_image\"" ?>>
          <h6 class="p-2">File should be in png, jpg, or jpeg format.</h6>
        </div>
        <div class="row justify-content-around">
          <input name="update-image" class="btn btn-success" type="submit" value="Add Image">
          <a class="btn btn-danger g-3" href="#deleteAvatar" data-toggle="modal">Remove Image</a>
        </div>
      </form>
    </div>


    <!-- edit form column -->
    <div class="col-md-6 personal-info">
      <?php if (isset($_SESSION['update'])) : ?>
        <div class="alert alert-danger alert-dismissable">
          <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
          <i class="fas fa-exclamation-circle"></i>
          <?= $_SESSION['update'];
          unset($_SESSION['update']); ?>
        </div>
      <?php elseif (isset($_SESSION['update-success'])) : ?>
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
          <i class="fas fa-check-square"></i>
          <?= $_SESSION['update-success'];
          unset($_SESSION['update-success']);
          ?>
        </div>
      <?php elseif (isset($_SESSION['image-success'])) : ?>
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
          <i class="fas fa-check-square"></i>
          <?= $_SESSION['image-success'];
          unset($_SESSION['image-success']);
          ?>
        </div>
      <?php endif ?>

      <h3>Personal info</h3>

      <form action="" method="POST" class="form-horizontal w-100" role="form">
        <div class="form-group">
          <label class="col-lg-3 control-label">Name:</label>
          <div class="col-lg-12">
            <input name="user-name" class="form-control" type="text" value="<?= $edit_user['user_name'] ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label>
          <div class="col-md-12">
            <input name="user-username" class="form-control" type="text" value="<?= $edit_user['user_username'] ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
          <div class="col-lg-12">
            <input name="user-email" class="form-control" type="text" value="<?= $edit_user['user_email'] ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12  d-flex justify-content-end">
            <input name="update-submit" type="submit" class="btn btn-primary" value="Save Changes">
            <span></span>
            <input type="reset" class="btn btn-default" value="Cancel">
          </div>
        </div>
      </form>
      <h5>Change your password:</h5>
      <form action="" method="POST" class="form-horizontal w-100" role="form">
        <div class="form-group">
          <label class="col-md-3 control-label">New Password:</label>
          <div class="col-md-12">
            <input name="update-password" class="form-control" type="password">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Confirm password:</label>
          <div class="col-md-12">
            <input name="confirm-update-password" class="form-control" type="password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12  d-flex justify-content-end">
            <input name="change-password" type="submit" class="btn btn-primary" value="Save Changes">
            <span></span>
            <input type="reset" class="btn btn-default" value="Cancel">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div id="deleteAvatar" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <h4 class="modal-title">Remove Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove your profile image?</p>
          <p class="text-warning">
            <small>You can add it again.</small>
          </p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
          <input name="remove-image" type="submit" class="btn btn-danger" value="Remove" />
        </div>
      </form>
    </div>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>