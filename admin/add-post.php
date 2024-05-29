<?php require("includes/admin-header.php"); ?>

<?php add_post(); ?>

<?php
$title = $_SESSION['post-data']['post-title'] ?? null;
$content = $_SESSION['post-data']['post-content'] ?? null;
$image = $_SESSION['post-data']['post-image'] ?? null;
$status = $_SESSION['post-data']['post-status'] ?? null;
$status = $_SESSION['post-data']['post-status'] ?? null;
$type = $_SESSION['post-data']['post-type'] ?? null;
unset($_SESSION['post-data']);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Add Post</b></h1>
  <div class="row col-lg-8 mx-auto justify-content-center">

    <?php if (isset($_SESSION['post'])) : ?>
      <div class="alert alert-danger alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-exclamation-circle"></i>
        <?= $_SESSION['post'];
        unset($_SESSION['post']);
        ?>
      </div>
    <?php elseif (isset($_SESSION['post-success'])) : ?>
      <div class="alert alert-info alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-check-square"></i>
        <?= $_SESSION['post-success'];
        unset($_SESSION['post-success']);
        ?>
      </div>
    <?php endif ?>

    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
      <div class="form-group">
        <label for="title">Title</label>
        <input name="post-title" type="text" class="form-control" id="title" value="<?= $title ?>" required />
      </div>
      <div class="form-group">
        <label for="summernote">Content</label>
        <textarea name="post-content" class="form-control" id="summernote" value="<?= $content ?>" required></textarea>
      </div>
      <div class="mb-3">
        <label for="image">Image</label>
        <div class="custom-file">
          <input name="post-image" type="file" class="custom-file-input" id="image" value="<?= $image ?>" required />
          <label class="custom-file-label" for="image">Choose file</label>
        </div>
      </div>
      <div class="input-group mb-3">
        <select name="post-status" class="custom-select">
          <option selected value="published">Publish</option>
          <option value="draft">Draft</option>
        </select>
      </div>
      <div class="input-group mb-3">
        <label for="category" class="col-form-label">Category</label>
        <select name="post-category" class="custom-select" id="category" required>
          <option selected disabled>Choose category</option>
          <?php show_category(); ?>
        </select>
      </div>
      <?php if (isset($_SESSION['user-is-admin'])) : ?>
        <div class="input-group mb-3">
          <label for="featured" class="col-form-label">Post type</label>
          <select name="post-type" class="custom-select" id="featured" required>
            <option selected value="0">Normal</option>
            <option value="1">Feature 1</option>
            <option value="2">Feature 2</option>
            <option value="3">Feature 3</option>
          </select>
        </div>
      <?php endif ?>
      <button name="add-post-submit" type="submit" class="btn btn-primary">Add Post</button>
    </form>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>