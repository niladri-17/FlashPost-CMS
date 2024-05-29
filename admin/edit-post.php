<?php require("includes/admin-header.php"); ?>
<?php $post_id = $_GET['id'] ?>
<?php edit_post(); ?>


<?php
global $connection;
$edit_post_query =
  "
    SELECT 
        posts.post_id, 
        posts.post_title, 
        posts.post_image, 
        posts.post_content, 
        posts.post_type, 
        posts.post_date, 
        posts.post_status, 
        categories.cat_title 
    FROM 
        posts 
    INNER JOIN 
        categories ON posts.post_category_id = categories.cat_id 
    WHERE 
        posts.post_id = {$post_id}
  ";
$edit_post_result = mysqli_query($connection, $edit_post_query);
while($row = mysqli_fetch_assoc($edit_post_result)){
  $post_title = $row['post_title'];
  $post_content = $row['post_content'];
  $post_image = $row['post_image'];
  $post_status = $row['post_status'];
  $post_type = $row['post_type'];
  $cat_title = $row['cat_title'];
}
?>

<?php
$title = $_SESSION['edit-post-data']['post-title'] ?? null;
$content = $_SESSION['edit-post-data']['post-content'] ?? null;
$image = $_SESSION['edit-post-data']['post-image'] ?? null;
$status = $_SESSION['edit-post-data']['post-status'] ?? null;
$type = $_SESSION['edit-post-data']['post-type'] ?? null;
unset($_SESSION['edit-post-data']);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3"><b>Add Post</b></h1>
  <div class="row col-lg-8 mx-auto justify-content-center">

    <?php if (isset($_SESSION['edit-post'])) : ?>
      <div class="alert alert-danger alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-exclamation-circle"></i>
        <?= $_SESSION['edit-post'];
        unset($_SESSION['edit-post']);
        ?>
      </div>
    <?php elseif (isset($_SESSION['post-success'])) : ?>
      <div class="alert alert-info alert-dismissable w-100">
        <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
        <i class="fas fa-check-square"></i>
        <?= $_SESSION['edit-post-success'];
        unset($_SESSION['post-success']);
        ?>
      </div>
    <?php endif ?>

    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
      <div class="form-group">
        <label for="title">Title</label>
        <input name="post-title" type="text" class="form-control" id="title" value="<?= $title ?? $post_title ?>" required />
      </div>
      <div class="form-group">
        <label for="summernote">Content</label>
        <textarea name="post-content" class="form-control" id="summernote" required><?= $content ?? $post_content ?></textarea>
      </div>
      <div class="mb-3">
        <label for="image">Image</label>
        <div><img class="mb-3" width="500px" src="<?= ROOT_URL . "images/" . "$post_image" ?>" alt=""></div>
        <div class="custom-file">
          <input name="post-image" type="file" class="custom-file-input" id="image" value="<?= $image ?? $post_image?>" />
          <label class="custom-file-label" for="image">Choose file</label>
        </div>
      </div>
      <div class="input-group mb-3">
        <select name="post-status" class="custom-select">
          <option <?= $post_status == "published" ? "selected" : " "; ?> value="published">Publish</option>
          <option <?= $post_status == "draft" ? "selected" : " "; ?> value="draft">Draft</option>
        </select>
      </div>
      <div class="input-group mb-3">
        <label for="category" class="col-form-label">Category</label>
        <select name="post-category" class="custom-select" id="category" required>
          <option selected disabled>Choose category</option>
          <?php show_category($cat_title); ?>
        </select>
      </div>
      <?php if (isset($_SESSION['user-is-admin'])) : ?>
        <div class="input-group mb-3">
          <label for="featured" class="col-form-label">Post type</label>
          <select name="post-type" class="custom-select" id="featured" required>
            <option <?= $post_type == 0 ? "selected" : " "; ?> value="0">Normal</option>
            <option <?= $post_type == 1 ? "selected" : " "; ?> value="1">Feature 1</option>
            <option <?= $post_type == 2 ? "selected" : " "; ?> value="2">Feature 2</option>
            <option <?= $post_type == 3 ? "selected" : " "; ?> value="3">Feature 3</option>
          </select>
        </div>
      <?php endif ?>
      <button name="edit-post-submit" type="submit" class="btn btn-primary">Edit Post</button>
    </form>
  </div>
</div>

<?php require("includes/admin-footer.php"); ?>