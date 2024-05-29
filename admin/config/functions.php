<?php

function password_encrypt($password)
{
    $hashFormat = "$2y$10$";
    $salt = "69hellomotherfucker696";
    $hash_form_and_salt = $hashFormat . $salt;
    $password_hash = crypt($password, $hash_form_and_salt);
    return $password_hash;
}

// Profile functions

function profile_update($user_id, $location)
{
    global $connection;

    if (isset($_POST['update-submit'])) {
        $user_name = filter_var($_POST['user-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_username = filter_var($_POST['user-username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_email = filter_var($_POST['user-email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user_check_query = "SELECT * FROM users WHERE user_username = '$user_username' OR user_email = '$user_email'";
        $user_check_result = mysqli_query($connection, $user_check_query);

        if (mysqli_num_rows($user_check_result) > 0) {
            $_SESSION['update'] = "Username or email already exists!";
        }

        if (!isset($_SESSION['update'])) {

            $user_update_query = "UPDATE users SET user_name = '$user_name', user_username = '$user_username' , user_email = '$user_email' WHERE user_id = '$user_id'";
            $user_update_result = mysqli_query($connection, $user_update_query);
            if ($user_update_result) {
                header('Location: ' . ROOT_URL . $location);
                $_SESSION['update-success'] = 'Update successful.';
            }
        }
    }
}

function change_password($user_id, $location)
{
    global $connection;

    if (isset($_POST['change-password'])) {
        $update_password = filter_var($_POST['update-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_update_password = filter_var($_POST['confirm-update-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if ($update_password !== $confirm_update_password) {
            // check if passwords match
            $_SESSION['update'] = "Passwords do not match!";
        } else {
            // hash password
            $password_hash = password_encrypt($confirm_update_password);

            $user_update_query = "UPDATE users SET  user_password = '$password_hash' WHERE user_id = '$user_id'";
            $user_update_result = mysqli_query($connection, $user_update_query);
            if ($user_update_result) {
                header('Location: ' . ROOT_URL . $location);
                $_SESSION['update-success'] = 'Update successful.';
            }
        }
    }
}

function profile_image_update($user_id, $location)
{
    global $connection;

    if (isset($_POST['update-image'])) {
        $user_image = $_FILES['user-image']['name'];
        $time = time();
        $user_image = $time . $user_image;
        $user_image_temp = $_FILES['user-image']['tmp_name'];
        $image_destination_path = '../images/' . $user_image;

        $old_image_query = "SELECT user_image FROM users WHERE user_id = '$user_id'";
        $old_image_result = mysqli_query($connection, $old_image_query);
        $old_user_image = mysqli_fetch_assoc($old_image_result);

        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $user_image);
        $extension = end($extension);
        if (empty($_FILES['user-image']['name'])) {
            $_SESSION['update'] = "Choose an Image";
        } else if (in_array($extension, $allowed_files)) {
            // make sure file size less than 1MB
            $user_image_size = $_FILES['user-image']['size'];
            if ($user_image_size < 1000000) {
                // upload image
                move_uploaded_file($user_image_temp, $image_destination_path);
                // remove old photo
                if ($old_user_image['user_image'] != NULL) unlink('../images/' . $old_user_image['user_image']);
            } else {
                $_SESSION['update'] = "Image size too big. Should be less than 1MB.";
            }
        } else {
            $_SESSION['update'] = "Image should be in png, jpg, or jpeg format.";
        }
        if (!isset($_SESSION['update'])) {

            $user_image_query = "UPDATE users SET user_image = '$user_image' WHERE user_id=$user_id";
            $user_image_result = mysqli_query($connection, $user_image_query);
            if ($user_image_result) {
                $_SESSION['image-success'] = 'Image Updated successfully.';
                header('Location: ' . ROOT_URL . $location);
            }
        }
    }
}

function remove_profile_image($user_id, $location)
{
    global $connection;

    if (isset($_POST['remove-image'])) {

        $remove_image_query = "UPDATE users SET user_image = NULL WHERE user_id=$user_id";
        $remove_image_result = mysqli_query($connection, $remove_image_query);
        if ($remove_image_result) {
            $_SESSION['image-success'] = 'Image removed successfully.';
            header('Location: ' . ROOT_URL . $location);
        }
    }
}

function add_user()
{
    global $connection;

    if (isset($_POST['add-user'])) {

        $name = filter_var($_POST['user-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['user-username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['user-email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $create_password = filter_var($_POST['create-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_password = filter_var($_POST['confirm-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_role = filter_var($_POST['user-role'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!isset($name)) $_SESSION['add-user'] = 'Enter your name';
        else if (!isset($username)) $_SESSION['add-user'] = 'Create Username';
        else if ($create_password !== $confirm_password) {
            // check if passwords match
            $_SESSION['add-user'] = "Passwords do not match!";
        } else {
            // hash password
            $password_hash = password_encrypt($confirm_password);

            $user_check_query = "SELECT * FROM users WHERE user_username = '$username' OR user_email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or email already exists!";
            } else if (empty($_FILES['user-image']['name'])) {
                $user_image = NULL;
            } else {
                $user_image = $_FILES['user-image']['name'];
                $time = time();
                $user_image = $time . $user_image;
                $user_image_temp = $_FILES['user-image']['tmp_name'];
                $image_destination_path = '../images/' . $user_image;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $user_image);
                $extension = end($extension);

                if (in_array($extension, $allowed_files)) {
                    // make sure file size less than 1MB
                    $user_image_size = $_FILES['user-image']['size'];
                    if ($user_image_size < 1000000) {
                        // upload image
                        move_uploaded_file($user_image_temp, $image_destination_path);
                    } else {
                        $_SESSION['add-user'] = "Image size too big. Should be less than 1MB.";
                    }
                } else {
                    $_SESSION['add-user'] = "Image should be in png, jpg, or jpeg format.";
                }
            }
        }
        if (isset($_SESSION['add-user'])) {
            $_SESSION['add-user-data'] = $_POST;
        } else {
            $add_user_query = "INSERT INTO users(user_name, user_username, user_email, user_image, user_password, user_role) ";
            $add_user_query .= "VALUES ('$name', '$username', '$email', '$user_image', '$password_hash', '$user_role')";
            $add_user_result = mysqli_query($connection, $add_user_query);
            if ($add_user_result) {
                $_SESSION['add-user-success'] = 'Registration successful.';
                // die();
            }
        }
    }
}

function manage_users()
{
    global $connection;
    $select_all_query = "SELECT * FROM users";
    $select_all_result = mysqli_query($connection, $select_all_query);
    while ($row = mysqli_fetch_assoc($select_all_result)) {
        if ($row['user_role'] == 1) $user_role = 'admin';
        if ($row['user_role'] == 0) $user_role = 'author';
        echo "
    <tr>
    <td>
      <span class='custom-checkbox'>
      <input type='checkbox' id='{$row['user_id']}' name='options[]' value='{$row['user_id']}'>
      <label for='checkbox1'></label>
      </span>
    </td>
    <td>" . $row['user_id'] . "</td>
    <td>" . $row['user_name'] . "</td>
    <td>" . $row['user_username'] . "</td>
    <td>" . $row['user_email'] . "</td>
    <td>" . $user_role . "</td>
    <td class='d-flex justify-content-around'>
      <a href='edit-users-profile.php?id=" . $row['user_id'] . "' class='edit' title='Edit'><i class='fas fa-user-edit' style='color: #cfc914'></i></a>
      <a href='#' id='{$row['user_id']}' class='delete confirm_delete_btn' data-toggle='modal' title='Delete'><i class='fas fa-trash' style='color: #cb1010'></i></a>
    </td>
  </tr>
    ";
    }
}

function delete_user()
{
    global $connection; {
        if (isset($_POST['confirm_delete_btn'])) {

            $delete_user_id = $_POST['delete_id'];

            $delete_user_query = "DELETE FROM users WHERE user_id = {$delete_user_id} ";
            $result = mysqli_query($connection, $delete_user_query);
        }
    }
}

function delete_multiple_users_by_checkbox()
{
    global $connection; {
        if (isset($_POST['confirm_delete_multiple_btn'])) {
            $delete_user_ids = $_POST['delete_ids'];
            $sanitizedIds = array_map('intval', $delete_user_ids);
            $sanitizedIds = implode(',', $delete_user_ids);

            // Construct the SQL query to delete records with the selected IDs
            $delete_user_query = "DELETE FROM users WHERE user_id IN($sanitizedIds) ";
            $result = mysqli_query($connection, $delete_user_query);
        }
    }
}

function add_category()
{
    global $connection;
    if (isset($_POST['add-category'])) {
        $category = filter_var($_POST['category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $select_all_query = "SELECT * FROM categories WHERE cat_title = '$category'";
        $select_all_result = mysqli_query($connection, $select_all_query);

        if (mysqli_num_rows($select_all_result) > 0) $_SESSION['category'] = "Category already exists!";

        if (!isset($_SESSION['category'])) {
            $add_category_query = "INSERT INTO categories(cat_title) ";
            $add_category_query .= "VALUES ('$category')";
            $add_category_result = mysqli_query($connection, $add_category_query);
            if ($add_category_result) header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
        } else {
            header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
        }
    }
}

function read_category()
{
    global $connection;
    $read_category_query = "SELECT * FROM categories";
    $read_category_result = mysqli_query($connection, $read_category_query);
    while ($row = mysqli_fetch_assoc($read_category_result)) {
        echo "
        <tr>
        <td>
          <span class='custom-checkbox'>
          <input type='checkbox' id='{$row['cat_id']}' name='options[]' value='{$row['cat_id']}'>
          <label for='checkbox1'></label>
          </span>
        </td>
        <td>" . $row['cat_id'] . "</td>
        <td id='cat-title'>" . $row['cat_title'] . "</td>
        <td class='d-flex justify-content-around'>
          <a href='' id='{$row['cat_id']}' class='edit-category-btn edit' title='Edit' data-toggle='modal'><i class='fas fa-user-edit' style='color: #cfc914'></i></a>
          <a href='' id='{$row['cat_id']}' class='delete delete-category-btn' title='Delete' data-toggle='modal'><i class='fas fa-trash' style='color: #cb1010'></i></a>
        </td>
      </tr>
        ";
    }
}

function edit_category()
{
    global $connection;
    if (isset($_POST['edit_category'])) {
        $category_id = $_POST['edit_id'];
        $category_title = $_POST['edit_title'];
        $edit_category_query = "UPDATE categories SET cat_title = '$category_title' WHERE cat_id = '$category_id'";
        $edit_category_result = mysqli_query($connection, $edit_category_query);
    }
}

function delete_category()
{
    global $connection;
    if (isset($_POST['delete_category'])) {

        $delete_category_id = $_POST['delete_id'];

        $delete_category_query = "DELETE FROM categories WHERE cat_id = {$delete_category_id} ";
        $result = mysqli_query($connection, $delete_category_query);
    }
}

function delete_multiple_categories_by_checkbox()
{
    global $connection;
    if (isset($_POST['delete_multiple_category'])) {
        $delete_category_ids = $_POST['delete_ids'];
        $sanitizedIds = array_map('intval', $delete_category_ids);
        $sanitizedIds = implode(',', $delete_category_ids);

        // Construct the SQL query to delete records with the selected IDs
        $delete_category_query = "DELETE FROM categories WHERE cat_id IN($sanitizedIds) ";
        $result = mysqli_query($connection, $delete_category_query);
    }
}

function show_category($select = "")
{
    global $connection;
    $select_all_query = "SELECT * FROM categories";
    $select_all_result = mysqli_query($connection, $select_all_query);
    while ($row = mysqli_fetch_assoc($select_all_result)) {
        if ($select == $row['cat_title']) $x = "selected";
        else $x = "";
        echo "<option $x value='{$row['cat_id']}'>{$row['cat_title']}</option>";
    }
}

function add_post()
{
    global $connection;

    if (isset($_POST['add-post-submit'])) {

        $post_title = filter_var($_POST['post-title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_content = $_POST['post-content'];
        if (isset($_POST['post-type'])) $post_type = filter_var($_POST['post-type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        else $post_type = 0;

        $post_status = filter_var($_POST['post-status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $post_author_id = $_SESSION['user-id'];
        $author_query = "SELECT user_name FROM users WHERE user_id=$post_author_id";
        $author_result = mysqli_query($connection, $author_query);
        $post_author = mysqli_fetch_assoc($author_result);
        $post_author = $post_author['user_name'];

        $post_image = $_FILES['post-image']['name'];
        $time = time();
        $post_image = $time . $post_image;
        $post_image_temp = $_FILES['post-image']['tmp_name'];
        $image_destination_path = '../images/' . $post_image;


        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $post_image);
        $extension = end($extension);
        if (empty($_FILES['post-image']['name'])) {
            $_SESSION['post'] = "Choose an Image";
        } else if (in_array($extension, $allowed_files)) {
            // make sure file size less than 1MB
            $user_image_size = $_FILES['post-image']['size'];
            if ($user_image_size < 10000000) {
                // upload image
                move_uploaded_file($post_image_temp, $image_destination_path);
            } else {
                $_SESSION['post'] = "Image size too big. Should be less than 1MB.";
            }
        } else {
            $_SESSION['post'] = "Image should be in png, jpg, or jpeg format.";
        }

        if (!isset($_POST['post-category'])) $_SESSION['post'] = "Choose a category.";

        if (isset($_SESSION['post']))
            $_SESSION['post-data'] = $_POST;
        else {
            $post_category_id = filter_var($_POST['post-category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $add_post_query = "INSERT INTO posts(post_author_id, post_category_id, post_title, post_author, post_image, post_content, post_type, post_status) ";
            $add_post_query .= "VALUES ('$post_author_id', '$post_category_id', '$post_title', '$post_author', '$post_image', '$post_content', '$post_type', '$post_status')";
            $add_post_result = mysqli_query($connection, $add_post_query);
            if ($add_post_result) {
                if ($post_status == "published") $_SESSION['post-success'] = 'Post added successfully.';
                else $_SESSION['post-success'] = 'Draft added successfully';
                header('Location: ' . ROOT_URL . 'admin/add-post.php');
            }
        }
    }
}

function my_posts()
{
    global $connection;
    $my_posts_query =
        "
    SELECT 
        posts.post_id, 
        posts.post_title, 
        posts.post_image, 
        posts.post_content, 
        posts.post_date, 
        posts.post_status, 
        posts.post_type, 
        categories.cat_title 
    FROM 
        posts 
    INNER JOIN 
        categories ON posts.post_category_id = categories.cat_id 
    WHERE 
        posts.post_author_id = {$_SESSION['user-id']}
    ";

    $my_posts_result = mysqli_query($connection, $my_posts_query);
    if (mysqli_num_rows($my_posts_result) > 0) {
        while ($row = mysqli_fetch_assoc($my_posts_result)) {
            $post_image = ROOT_URL . "images/" . $row['post_image'];
            if($row['post_type']==0)$post_type = "Normal";
            else if($row['post_type']==1)$post_type = "Feature 1";
            else if($row['post_type']==2)$post_type = "Feature 2";
            else if($row['post_type']==3)$post_type = "Feature 3";
            echo
            "                        
            <tr>
            <td>
                <span class='custom-checkbox'>
                    <input type='checkbox' id='checkbox1' name='options[]' value='1' />
                    <label for='checkbox1'></label>
                </span>
            </td>
            <td>{$row['post_id']}</td>
            <td>{$row['post_title']}</td>
            <td><img src='{$post_image}' alt='' width='300px' height='200px'></td>
            <td>{$row['post_content']}</td>
            <td>{$row['cat_title']}</td>";
            if (isset($_SESSION['user-is-admin']))  echo  "<td>{$post_type}</td>";
            echo   "<td>{$row['post_date']}</td>
            <td>{$row['post_status']}</td>
            <td class='d-flex justify-content-around'>
                <a href='edit-post.php?id={$row['post_id']}' class='edit'><i class='fas fa-edit' style='color: #cfc914'></i></a>
                <a href='#deletePostModal' class='delete' data-toggle='modal'><i class='fas fa-trash' style='color: #cb1010'></i></a>
            </td>
            </tr>
            ";
        }
    }
}

function edit_post()
{
    global $connection;

    $post_id = intval($_GET['id']);

    // Fetch the existing post details from the database
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);

    if (isset($_POST['edit-post-submit'])) {
        $post_title = filter_var($_POST['post-title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_content = $_POST['post-content'];
        $post_type = isset($_POST['post-type']) ? filter_var($_POST['post-type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : 0;
        $post_status = filter_var($_POST['post-status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_author_id = $_SESSION['user-id'];

        $author_query = "SELECT user_name FROM users WHERE user_id=$post_author_id";
        $author_result = mysqli_query($connection, $author_query);
        $post_author = mysqli_fetch_assoc($author_result);
        $post_author = $post_author['user_name'];
        $post_image = $post['post_image'];

        // Handle file upload if a new image is provided
        if (!empty($_FILES['post-image']['name'])) {
            $post_image = $_FILES['post-image']['name'];
            $time = time();
            $post_image = $time . $post_image;
            $post_image_temp = $_FILES['post-image']['tmp_name'];
            $image_destination_path = '../images/' . $post_image;

            // Validate image file type and size
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $post_image);
            $extension = end($extension);

            if (in_array($extension, $allowed_files)) {
                $user_image_size = $_FILES['post-image']['size'];
                if ($user_image_size < 1000000) {
                    move_uploaded_file($post_image_temp, $image_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Image size too big. Should be less than 1MB.";
                }
            } else {
                $_SESSION['edit-post'] = "Image should be in png, jpg, or jpeg format.";
            }
        }

        if (!isset($_POST['post-category'])) {
            $_SESSION['edit-post'] = "Choose a category.";
        }

        if (isset($_SESSION['edit-post'])) {
            $_SESSION['edit-post-data'] = $_POST;
        } else {
            $post_category_id = filter_var($_POST['post-category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $update_post_query = "UPDATE posts SET post_category_id = '$post_category_id', post_title = '$post_title', post_author = '$post_author', post_image = '$post_image', post_content = '$post_content', post_type = '$post_type', post_status = '$post_status' WHERE post_id = '$post_id'";
            $update_post_result = mysqli_query($connection, $update_post_query);

            if ($update_post_result) {
                $_SESSION['edit-post-success'] = 'Post updated successfully.';
                if ($post_status == "published") {
                    $_SESSION['edit-post-success'] = 'Post updated successfully.';
                } else {
                    $_SESSION['edit-post-success'] = 'Draft updated successfully';
                }
                header('Location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $post_id);
            }
        }
    }
}
