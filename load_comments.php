<?php

session_start();
require "config/db.php";
require "config/functions.php";

global $connection;
$post_id = $_POST['post'];


if (isset($_POST['add_comment'])) {
    $comment_content = $_POST['comment_content'];
    $user_id = $_SESSION['user-id'];
    if (!empty($comment_content)) {
        $add_comment_query = "INSERT INTO comments(comment_post_id, comment_user_id, comment_content) ";
        $add_comment_query .= "VALUES ('$post_id', '$user_id', '$comment_content')";
        $add_comment_result = mysqli_query($connection, $add_comment_query);
    }

    $select_last_comment_query =
        "
        SELECT 
            comments.comment_date,
            comments.comment_content,
            users.user_name,
            users.user_image
        FROM 
            comments 
        JOIN 
            posts ON comments.comment_post_id = posts.post_id
        JOIN 
            users ON comments.comment_user_id = users.user_id
        WHERE 
            posts.post_id = $post_id
            ORDER BY comment_id DESC 
            LIMIT 1
    ";
    $select_last_comment_result = mysqli_query($connection, $select_last_comment_query);

    while ($row = mysqli_fetch_assoc($select_last_comment_result)) {
        if (isset($row['user_image'])) {
            $user_image = ROOT_URL . "images/" . $row['user_image'];
        } else {
            $user_image = ROOT_URL . "images/user-profile-image.png";
        }
        $comment_date = post_date($row['comment_date']);
        $html = "
            <div class='comment'>
                <div class='comment-author'>
                <img class='comment-author-img' src='{$user_image}' alt='Author Profile Image'>
                <span class='comment-author-name'>{$row['user_name']}</span>
                <span class='comment-date'>{$comment_date}</span>
                </div>
                <p class='comment-text'>{$row['comment_content']}</p>
            </div>
        ";
    }
    $res = [
        'message' => $html
    ];
    echo json_encode($res);
}


if (isset($_POST['load_comment'])) {
    sleep(1);
    $comment_count = $_POST['comment_count'];

    $load_btn = $comment_count + 5;
    $load_btn_query =
        "
    SELECT 
        comments.comment_date,
        comments.comment_content,
        users.user_name,
        users.user_image
    FROM 
        comments 
    JOIN 
        posts ON comments.comment_post_id = posts.post_id
    JOIN 
        users ON comments.comment_user_id = users.user_id
    WHERE 
        posts.post_id = $post_id
    ORDER BY comment_id DESC 
    LIMIT {$load_btn},1
    ";

    $load_btn_result = mysqli_query($connection, $load_btn_query);
    if (mysqli_num_rows($load_btn_result) > 0)
        $status = "yes";
    else
        $status = "no";

    $select_all_query =
        "
        SELECT 
            comments.comment_date,
            comments.comment_content,
            users.user_name,
            users.user_image
        FROM 
            comments 
        JOIN 
            posts ON comments.comment_post_id = posts.post_id
        JOIN 
            users ON comments.comment_user_id = users.user_id
        WHERE 
            posts.post_id = $post_id
            ORDER BY comment_id DESC 
            LIMIT {$comment_count}, 5
            
    ";
    $select_all_result = mysqli_query($connection, $select_all_query);

    $html = "";

    while ($row = mysqli_fetch_assoc($select_all_result)) {
        if (isset($row['user_image'])) {
            $user_image = ROOT_URL . "images/" . $row['user_image'];
        } else {
            $user_image = ROOT_URL . "images/user-profile-image.png";
        }
        $comment_date = post_date($row['comment_date']);
        $html .= "
            <div class='comment'>
                <div class='comment-author'>
                <img class='comment-author-img' src='{$user_image}' alt='Author Profile Image'>
                <span class='comment-author-name'>{$row['user_name']}</span>
                <span class='comment-date'>{$comment_date}</span>
                </div>
                <p class='comment-text'>{$row['comment_content']}</p>
            </div>
        ";
    }

    $res = [
        'status' => $status,
        'message' => $html
    ];
    echo json_encode($res);
}


if (isset($_POST['add_like'])) {
    $post_id = $_POST['post'];
    $user_id = $_POST['user_id'];

    // Update the like count in the posts table
    $update_post_query = "UPDATE posts SET post_likes = post_likes + 1 WHERE post_id = $post_id";
    $update_post_result = mysqli_query($connection, $update_post_query);

    // Check if the user has already liked the post
    $like_query = "SELECT * FROM likes WHERE like_post_id = $post_id AND like_user_id = $user_id AND like_status = 0";
    $like_result = mysqli_query($connection, $like_query);

    if (mysqli_num_rows($like_result) > 0) {
        // Update the like status to 1 if the user has unliked before
        $update_like_query = "UPDATE likes SET like_status = 1 WHERE like_user_id = $user_id AND like_post_id = $post_id";
        $update_like_result = mysqli_query($connection, $update_like_query);
    } else {
        // Insert a new like record
        $insert_like_query = "INSERT INTO likes (like_post_id, like_user_id, like_status) VALUES ('$post_id', '$user_id', 1)";
        $insert_like_result = mysqli_query($connection, $insert_like_query);
    }

    if (!$update_post_result || (!$update_like_result && !$insert_like_result)) {
        die("Query failed: " . mysqli_error($connection));
    } else {
        $res = [
            'status' => 200,
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['remove_like'])) {
    $post_id = $_POST['post'];
    $user_id = $_POST['user_id'];

    // Update the like count in the posts table
    $update_post_query = "UPDATE posts SET post_likes = post_likes - 1 WHERE post_id = $post_id";
    $update_post_result = mysqli_query($connection, $update_post_query);

    // Update the like status to 0
    $update_like_query = "UPDATE likes SET like_status = 0 WHERE like_user_id = $user_id AND like_post_id = $post_id";
    $update_like_result = mysqli_query($connection, $update_like_query);

    if (!$update_post_result || !$update_like_result) {
        die("Query failed: " . mysqli_error($connection));
    } else {
        $res = [
            'status' => 200,
        ];
        echo json_encode($res);
    }
}
