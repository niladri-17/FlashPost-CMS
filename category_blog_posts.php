<?php
sleep(2);
require "config/db.php";
require "config/functions.php";

global $connection;

if (isset($_POST['load_category_blog_posts'])) {
    if ($_POST['category'] != "All") {
        $post_category = mysqli_real_escape_string($connection, $_POST['category']); // Sanitize input
        $post_category = strtolower($post_category);

        $post_category_query =
            "
            SELECT 
            posts.post_id, 
            posts.post_title, 
            posts.post_content, 
            posts.post_image, 
            posts.post_date, 
            users.user_name, 
            users.user_image,
            categories.cat_title
        FROM 
            posts 
        INNER JOIN 
            users ON posts.post_author_id = users.user_id
        INNER JOIN 
            categories ON posts.post_category_id = categories.cat_id
        WHERE 
            posts.post_status = 'published' 
            AND 
            (
                LOWER(posts.post_title) LIKE '%$post_category%' 
                OR LOWER(posts.post_content) LIKE '%$post_category%' 
                OR LOWER(categories.cat_title) LIKE '%$post_category%'
            ) 
                ";
        $post_category_result = mysqli_query($connection, $post_category_query);
        $html = "";

        if (mysqli_num_rows($post_category_result) > 0) {
            while ($row = mysqli_fetch_assoc($post_category_result)) {
                $post_date = post_date($row['post_date']);
                $reading_time = estimateReadingTime($row['post_content']);
                $blog_post_content = trimWords($row['post_content']);
                if ($row['user_image'] !== NULL) {
                    $user_image = ROOT_URL . "images/" . $row['user_image'];
                } else {
                    $user_image = ROOT_URL . "images/user-profile-image.png";
                }
                $html .=
                    "
                        <a href='post.php?post={$row['post_id']}' class='blog-article blog-featured-article'>
                            <img src='" . ROOT_URL . "images/{$row['post_image']}' alt='' class='blog-article-image' />
                            <span class='article-category'>{$row['cat_title']}</span>
                            
                            <div class='blog-article-data-container'>
                            
                            <div class='post-author'>
                                <img class='author-img' src='$user_image' alt='Author Profile Image'>
                                <span class='author-name'>{$row['user_name']}</span>
                            </div>
                            <div class='article-data'>
                                <span>{$post_date}</span>
                                <span class='article-data-spacer'></span>
                                <span>{$reading_time}</span>
                            </div>
                            <h3 class='title article-title'>{$row['post_title']}</h3>
                            <div class='article-content'>
                                <p>
                                {$blog_post_content}
                                </p>
                            </div>
                            
                            </div>
                        </a>
                    ";
            }
            $res = [
                'status' => 200,
                'message' => $html
            ];
            echo json_encode($res);
            return;
        } else {
            $html = "<div class='Loader' style='width: 100%;height:30rem;color:var(--light-color);text-align:center;align-content:center'>No results found!</div>";
            $res = [
                'status' => 200,
                'message' => $html
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $post_query =
            "
                SELECT posts.post_id, posts.post_title, posts.post_content, posts.post_image, posts.post_date, users.user_name, users.user_image 
                FROM posts 
                INNER JOIN users 
                ON posts.post_author_id = users.user_id
                WHERE posts.post_status = 'published'
            ";

        $post_result = mysqli_query($connection, $post_query);
        $html = "";
        while ($row = mysqli_fetch_assoc($post_result)) {
            $post_date = post_date($row['post_date']);
            $reading_time = estimateReadingTime($row['post_content']);
            $blog_post_content = trimWords($row['post_content']);
            if ($row['user_image'] !== NULL) {
                $user_image = ROOT_URL . "images/" . $row['user_image'];
            } else {
                $user_image = ROOT_URL . "images/user-profile-image.png";
            }
            $html .=
                "
                    <a href='post.php?post={$row['post_id']}' class='blog-article blog-featured-article'>
                    <img src='" . ROOT_URL . "images/{$row['post_image']}" . "' alt='' class='blog-article-image' />
                    <span class='article-category'>Web Development</span>
                    
                    <div class='blog-article-data-container'>
                    
                    <div class='post-author'>
                        <img class='author-img' src='$user_image ' alt='Author Profile Image'>
                        <span class='author-name'>{$row['user_name']}</span>
                    </div>
                    <div class='article-data'>
                        <span>{$post_date}</span>
                        <span class='article-data-spacer'></span>
                        <span>{$reading_time}</span>
                    </div>
                    <h3 class='title article-title'>{$row['post_title']}</h3>
                    <div class='article-content'>
                        <p>
                        {$blog_post_content}
                        </p>
                    </div>
                    
                    </div>
                    </a>
                ";
        }
        $res = [
            'status' => 200,
            'message' => $html
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['search'])) {
    if ($_POST['search_category'] != "") {
        $post_category = mysqli_real_escape_string($connection, $_POST['search_category']); // Sanitize input
        $post_category = strtolower($post_category);

        $post_category_query =
            "
            SELECT 
            posts.post_id, 
            posts.post_title, 
            posts.post_content, 
            posts.post_image, 
            posts.post_date, 
            users.user_name, 
            users.user_image,
            categories.cat_title
        FROM 
            posts 
        INNER JOIN 
            users ON posts.post_author_id = users.user_id
        INNER JOIN 
            categories ON posts.post_category_id = categories.cat_id
        WHERE 
            posts.post_status = 'published' 
            AND 
            (
                LOWER(posts.post_title) LIKE '%$post_category%' 
                OR LOWER(posts.post_content) LIKE '%$post_category%' 
                OR LOWER(categories.cat_title) LIKE '%$post_category%'
            )        
                ";
        $post_category_result = mysqli_query($connection, $post_category_query);
        $html = "";

        if (mysqli_num_rows($post_category_result) > 0) {
            while ($row = mysqli_fetch_assoc($post_category_result)) {
                $post_date = post_date($row['post_date']);
                $reading_time = estimateReadingTime($row['post_content']);
                $blog_post_content = trimWords($row['post_content']);
                if ($row['user_image'] !== NULL) {
                    $user_image = ROOT_URL . "images/" . $row['user_image'];
                } else {
                    $user_image = ROOT_URL . "images/user-profile-image.png";
                }
                $html .=
                    "
                        <a href='post.php?post={$row['post_id']}' class='blog-article blog-featured-article'>
                            <img src='" . ROOT_URL . "images/{$row['post_image']}' alt='' class='blog-article-image' />
                            <span class='article-category'>{$row['cat_title']}</span>
                            
                            <div class='blog-article-data-container'>
                            
                            <div class='post-author'>
                                <img class='author-img' src='$user_image' alt='Author Profile Image'>
                                <span class='author-name'>{$row['user_name']}</span>
                            </div>
                            <div class='article-data'>
                                <span>{$post_date}</span>
                                <span class='article-data-spacer'></span>
                                <span>{$reading_time}</span>
                            </div>
                            <h3 class='title article-title'>{$row['post_title']}</h3>
                            <div class='article-content'>
                                <p>
                                {$blog_post_content}
                                </p>
                            </div>
                            
                            </div>
                        </a>
                    ";
            }
            $res = [
                'status' => 200,
                'message' => $html
            ];
            echo json_encode($res);
            return;
        } else {
            $html = "<div class='Loader' style='width: 100%;height:30rem;color:var(--light-color);text-align:center;align-content:center'>No results found!</div>";
            $res = [
                'status' => 200,
                'message' => $html
            ];
            echo json_encode($res);
            return;
        }
    }
}
