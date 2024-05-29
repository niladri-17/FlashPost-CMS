<?php require("includes/admin-header.php"); ?>
<?php if (!isset($_SESSION['user-is-admin'])) header('Location: ' . ROOT_URL . '/admin'); ?>
<?php add_user(); ?>

<?php
$name = $_SESSION['add-user-data']['user-name'] ?? null;
$username = $_SESSION['add-user-data']['user-username'] ?? null;
$email = $_SESSION['add-user-data']['user-email'] ?? null;
unset($_SESSION['signup-data']);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Add User</b></h1>
  <div class="row col-lg-6 mx-auto justify-content-center">

    <?php if (isset($_SESSION['add-user'])) : ?>
      <div class="alert alert-danger alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-exclamation-circle"></i>
        <?= $_SESSION['add-user'];
        unset($_SESSION['add-user']); ?>
      </div>
    <?php elseif (isset($_SESSION['add-user-success'])) : ?>
      <div class="alert alert-info alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-check-square"></i>
        <?= $_SESSION['add-user-success'];
        unset($_SESSION['add-user-success']);
        ?>
      </div>
    <?php endif ?>

    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
      <div class="mb-3">
        <input name="user-name" type="text" class="form-control" value="<?= $name ?>" placeholder="Full Name" required />
      </div>
      <div class="mb-3">
        <input name="user-username" type="text" class="form-control" value="<?= $username ?>" placeholder="Username" required />
      </div>
      <div class="mb-3">
        <input name="user-email" type="email" class="form-control" value="<?= $email ?>" placeholder="Email" required />
      </div>
      <!-- <div class="mb-3">
        <input type="text" class="form-control phone-mask" placeholder="Phone number" required />
      </div> -->
      <div class="mb-3">
        <div class="input-group d-flex align-items-center" id="show_hide_password1">
          <input name="create-password" type="password" class="form-control" placeholder="Create Password" required />
          <div class="input-group-addon p-2">
            <a href="" style="
                          display: block;
                          height: 100%;
                          width: 25px;
                          text-align: center;
                        "><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <div class="input-group d-flex align-items-center" id="show_hide_password2">
          <input name="confirm-password" type="password" class="form-control" aria-describedby="confirmPasswordHelp" placeholder="Confirm Password" required />
          <div class="input-group-addon p-2">
            <a href="" style="
                          display: block;
                          height: 100%;
                          width: 25px;
                          text-align: center;
                        "><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
      <div class="mb-3 d-flex">
        <div>
          <label for="userRole" class="form-label">User Role</label>
        </div>
        <select name="user-role" class="form-select" id="userRole">
          <option selected value="0">Author</option>
          <option value="1">Admin</option>
        </select>
      </div>
      <div class="mb-3 d-flex align-items-center">
        <label for="formFile" class="col-form-label">User Avatar</label>
        <div class="col-auto">
          <input name="user-image" class="form-control" type="file" id="formFile" />
        </div>
      </div>
      <button name="add-user" type="submit" class="btn btn-primary">Add User</button>
    </form>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>