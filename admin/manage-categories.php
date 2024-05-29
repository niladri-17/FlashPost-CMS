<?php require("includes/admin-header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3"><b>Manage Users</b></h1>

    <!-- DataTales Example -->
    <div class="row">
        <div class="col-lg-12">
            <div class="container-xl">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="d-flex justify-content-end mb-3">
                            <div>
                                <a href="#addCategoryModal" class="btn btn-success delete_multiple_user_btn" data-toggle="modal">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Add Category</span>
                                </a>
                                <a href="#deleteCategoryModal" class="btn btn-danger delete-multiple-category-btn" data-toggle="modal">
                                    <i class="fas fa-minus-circle"></i>
                                    <span>Delete Selected</span>
                                </a>
                            </div>
                        </div>
                        <div>
                            <?php if (isset($_SESSION['category'])) : ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <a class="panel-close close" style="cursor: pointer;" data-dismiss="alert">×</a>
                                    <i class="fas fa-exclamation-circle"></i>
                                    <?= $_SESSION['category'];
                                    unset($_SESSION['category']); ?>
                                </div>
                            <?php endif ?>
                            <table id="manage-category" class="table table-striped table-hover col-6 m-auto">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="custom-checkbox">
                                                <input type="checkbox" id="selectAll">
                                                <label for="selectAll"></label>
                                            </span>
                                        </th>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php read_category(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Modal HTML -->
            <div id="addCategoryModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="POST">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Category Title</label>
                                    <input name="category" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input name="add-category" type="submit" class="btn btn-success" value="Add">
                                <?php add_category(); ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal HTML -->
            <div id="editCategoryModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Category Title</label>
                                    <input id="category-title" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input id="edit-category" type="submit" class="btn btn-info" data-dismiss="modal" value="Save">

                                <?php edit_category() ?>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal HTML -->
            <div id="deleteCategoryModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="user_id" id="confirm_delete_id">
                                <p>Are you sure you want to delete these Categories?</p>
                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" type class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input id="delete-category" type="submit" class="btn btn-danger" data-dismiss="modal" value="Delete">

                                <?php delete_category(); ?>

                                <?php delete_multiple_categories_by_checkbox(); ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php require("includes/admin-footer.php"); ?>