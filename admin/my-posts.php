<?php require("includes/admin-header.php"); ?>

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
                        <a href="#deletePostModal" class="btn btn-danger" data-toggle="modal"><i class="fas fa-minus-circle"></i>
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
                            <?php if (isset($_SESSION['user-is-admin'])) :  ?>
                                <th>Post Type</th>
                            <?php endif ?>
                            <th>Date</th>
                            <th>status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php my_posts(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div id="deletePostModal" class="modal fade">
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