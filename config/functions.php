<?php

function password_encrypt($password)
{
    $hashFormat = "$2y$10$";
    $salt = "69hellomotherfucker696";
    $hash_form_and_salt = $hashFormat . $salt;
    $password_hash = crypt($password, $hash_form_and_salt);
    return $password_hash;
}

function user_signup()
{
    global $connection;

    if (isset($_POST['signup-submit'])) {

        $name = filter_var($_POST['signup-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['signup-username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['signup-email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $create_password = filter_var($_POST['create-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirm_password = filter_var($_POST['confirm-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($create_password !== $confirm_password) {
            // check if passwords match
            $_SESSION['signup'] = "Passwords do not match!";
        } else {
            // hash password
            $password_hash = password_encrypt($confirm_password);

            $user_check_query = "SELECT * FROM users WHERE user_username = '$username' OR user_email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "* Username or email already exists!";
            }
        }

        if (isset($_SESSION['signup'])) {
            $_SESSION['signup-data'] = $_POST;
        } else {
            $user_signup_query = "INSERT INTO users(user_name, user_username, user_email , user_password) ";
            $user_signup_query .= "VALUES ('$name', '$username', '$email', '$password_hash')";
            $user_signup_result = mysqli_query($connection, $user_signup_query);
            if ($user_signup_result) {
                $_SESSION['signup-success'] = 'Registration successful. Please log in';
                // die();
            }
        }
    }
}

function user_login()
{
    global $connection;

    if (isset($_POST['login-submit'])) {
        $email_username = filter_var($_POST['login-email-username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['login-password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$email_username) $_SESSION['login'] = "* Username or Email required";
        else if (!$password) $_SESSION['login'] = "* Password required";
        else {
            $fetch_user_query = "SELECT * FROM users WHERE user_username = '$email_username' OR  user_email='$email_username'";
            $fetch_user_result = mysqli_query($connection, $fetch_user_query);

            if (mysqli_num_rows($fetch_user_result) == 1) {
                $user_record = mysqli_fetch_assoc($fetch_user_result);
                $db_password = $user_record['user_password'];
                //compare form password with database password
                if (password_encrypt($password) === $db_password) {
                    // set session for access control
                    $_SESSION['user-id'] = $user_record['user_id'];

                    //set session if user is admin
                    if ($user_record['user_role'] == 1) {
                        $_SESSION['user-is-admin'] = true;
                    }
                    // log user in
                    header("Refresh:0");
                } else {
                    $_SESSION['login'] = "* Wrong password";
                }
            } else {
                $_SESSION['login'] = "* User not found";
            }
        }
        // if any problem, redirect back to login page with login details
        if (isset($_SESSION['login'])) {
            $_SESSION['login-data'] = $_POST;
            // header('Location: ' . ROOT_URL);
            // die('Query failed' . mysqli_error($connection));
        }
    }
}

function open_signup_modal()
{
    echo "
    <script>
    var form_modal = document.querySelector('.cd-user-modal'),
    form_login = form_modal.querySelector('#cd-login'),
    form_signup = form_modal.querySelector('#cd-signup'),
    form_forgot_password = form_modal.querySelector('#cd-reset-password'),
    form_modal_tab = document.querySelector('.cd-switcher'),
    tab_login = form_modal_tab.children[0].querySelector('a'),
    tab_signup = form_modal_tab.children[1].querySelector('a'),
    forgot_password_link = form_login.querySelector('.cd-form-bottom-message a'),
    back_to_login_link = form_forgot_password.querySelector('.cd-form-bottom-message a'),
    main_nav = document.querySelector('.main-nav');
    form_modal.classList.add('is-visible');
    form_login.classList.remove('is-selected');
    form_signup.classList.add('is-selected');
    form_forgot_password.classList.remove('is-selected');
    tab_login.classList.remove('selected');
    tab_signup.classList.add('selected');
    console.log('hello-signup');
    </script>
    ";
}
function open_login_modal()
{
    echo "
    <script>
    var form_modal = document.querySelector('.cd-user-modal'),
    form_login = form_modal.querySelector('#cd-login'),
    form_signup = form_modal.querySelector('#cd-signup'),
    form_forgot_password = form_modal.querySelector('#cd-reset-password'),
    form_modal_tab = document.querySelector('.cd-switcher'),
    tab_login = form_modal_tab.children[0].querySelector('a'),
    tab_signup = form_modal_tab.children[1].querySelector('a'),
    forgot_password_link = form_login.querySelector('.cd-form-bottom-message a'),
    back_to_login_link = form_forgot_password.querySelector('.cd-form-bottom-message a'),
    main_nav = document.querySelector('.main-nav');
    form_modal.classList.add('is-visible');
    form_login.classList.add('is-selected');
    form_signup.classList.remove('is-selected');
    form_forgot_password.classList.remove('is-selected');
    tab_login.classList.add('selected');
    tab_signup.classList.remove('selected');
    console.log('hello-login');
    </script>
    ";
}

function show_category()
{
    global $connection;
    $select_all_query = "SELECT * FROM categories";
    $select_all_result = mysqli_query($connection, $select_all_query);
    while ($row = mysqli_fetch_assoc($select_all_result)) {
        echo "<li class='tab'>{$row['cat_title']}</li>";
    }
}

function post_date($date)
{

    // Create a DateTime object from the retrieved date
    $dateTime = new DateTime($date);

    // Get day, month, and year separately
    $day = $dateTime->format('j');
    $month = $dateTime->format('F');
    $year = $dateTime->format('Y');

    // Determine the day suffix
    if ($day == 1 || $day == 21 || $day == 31) {
        $suffix = 'st';
    } elseif ($day == 2 || $day == 22) {
        $suffix = 'nd';
    } elseif ($day == 3 || $day == 23) {
        $suffix = 'rd';
    } else {
        $suffix = 'th';
    }

    // Print the formatted date
    return $day . "<sup>$suffix</sup>" . ' ' . $month . ' ' . $year;
}

function estimateReadingTime($content)
{
    $wordsPerMinute = 200;
    // Remove HTML tags and decode HTML entities to get plain text
    $text = strip_tags(html_entity_decode($content));

    // Count the number of words in the plain text
    $content = strip_tags($content);
    $wordCount = str_word_count($text);

    // Calculate the reading time in minutes
    $readingTimeMinutes = ceil($wordCount / $wordsPerMinute);

    // Return the estimated reading time
    return $readingTimeMinutes . " Min" . " read";
}

function trimWords($text)
{
    // Trim the text to the nearest word boundary
    $maxLength = 175;

    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength);
        $text = substr($text, 0, strrpos($text, ' ')); // Trim to the last space
        $text .= '...';
    }
    return $text;
}

function show_blog_posts()
{
    global $connection;

    $post_query =
        "
            SELECT posts.post_id, posts.post_title, posts.post_content, posts.post_image, posts.post_date, posts.post_status, categories.cat_title, users.user_name, users.user_image 
            FROM posts
            JOIN categories
            ON posts.post_category_id = categories.cat_id 
            JOIN users 
            ON posts.post_author_id = users.user_id
        ";

    $post_result = mysqli_query($connection, $post_query);

    while ($row = mysqli_fetch_assoc($post_result)) {
        if ($row['post_status'] == "published") {
            $post_date = post_date($row['post_date']);
            $reading_time = estimateReadingTime($row['post_content']);
            $blog_post_content = trimWords($row['post_content']);
            if ($row['user_image'] !== NULL) {
                $user_image = ROOT_URL . "images/" . $row['user_image'];
            } else {
                $user_image = ROOT_URL . "images/user-profile-image.png";
            }
            echo
            "
                <a href='post.php?post={$row['post_id']}' class='blog-article blog-featured-article'>
                    <img src='" . ROOT_URL . "images/{$row['post_image']}" . "' alt='' class='blog-article-image' />
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
                        <p>{$blog_post_content}</p>
                    </div>
                    
                    </div>
                </a>
            ";
        }
    }
}

function post_data()
{
    global $connection;
    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];

        $post_data_query =  "SELECT posts.post_title, posts.post_content, posts.post_image, posts.post_date, users.user_name, users.user_image FROM posts INNER JOIN users ON posts.post_author_id = users.user_id WHERE posts.post_id = '$post_id'";
        $post_data_result = mysqli_query($connection, $post_data_query);
        while ($row = mysqli_fetch_assoc($post_data_result)) {
            $post_date = post_date($row['post_date']);
            $reading_time = estimateReadingTime($row['post_content']);
            echo
            "
            <h3 id='{$_GET['post']}' class='title blog-post-title'>{$row['post_title']}</h3>
                  <div class='article-data'>
                    <span>{$post_date}</span>
                    <span class='article-data-spacer'></span>
                    <span>{$reading_time}</span>
                  </div>
                  <img src='" . ROOT_URL . "images/{$row['post_image']}" . "' alt='' />
                </div>
            
                <div class='container'>
                  <p>
                  {$row['post_content']}
                  </p>
            
            
                  <!-- <blockquote class='quote'>
                    <p>
                      <span><i class='ri-double-quotes-l'></i></span> Lorem ipsum dolor
                      sit amet consectetur adipisicing elit. Officia voluptates,
                      laboriosam voluptatum quos non consequuntur nesciunt
                      necessitatibus tempora quod inventore corporis rem nihil itaque,
                      at provident minus aliquam veritatis. Labore?
                      <span><i class='ri-double-quotes-r'></i></span>
                    </p>
                  </blockquote> -->
            
                  <div class='author d-grid'>
                    <div class='author-image-box'>
                      <img src='" . ROOT_URL . "images/{$row['user_image']}" . "' alt='' class='article-image' />
                    </div>
                    <div class='author-about'>
                      <h3 class='post author-name'>{$row['user_name']}</h3>
                      <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque
                        quis repellat rerum, possimus cumque dolor repellendus eligendi
                        atque explicabo exercitationem id.
                      </p>
                      <ul class='list social-media'>
                        <li class='list-item'>
                          <a href='#' class='list-link'><i class='ri-instagram-line'></i></a>
                        </li>
                        <li class='list-item'>
                          <a href='#' class='list-link'><i class='ri-facebook-circle-line'></i></a>
                        </li>
                        <li class='list-item'>
                          <a href='#' class='list-link'><i class='ri-twitter-line'></i></a>
                        </li>
                      </ul>
                    </div>
                  </div>
            ";
        }
    }
}

function total_comments()
{
    global $connection;
    $post_id = $_GET['post'];
    $total_comments_query = "SELECT COUNT(*) as total_comments FROM comments WHERE comment_post_id = $post_id";
    $total_comments_result = mysqli_query($connection, $total_comments_query);

    if ($total_comments_result) {
        if (mysqli_num_rows($total_comments_result) > 0) {
            $row = mysqli_fetch_assoc($total_comments_result);
            $totalRows = $row['total_comments'];
            echo $totalRows . " Comments";
        } else {
            echo "No comments yet";
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

function likes_count()
{
    global $connection;
    $post_id = $_GET['post'];
    $count_query = "SELECT post_likes FROM posts WHERE post_id = $post_id";
    $count_result = mysqli_query($connection, $count_query);
    $row = mysqli_fetch_assoc($count_result);
    echo $row['post_likes'];
}

function like_status()
{
    global $connection;
    $post_id = $_GET['post'];
    $user_id = $_SESSION['user-id'];
    $like_query = "SELECT * FROM likes WHERE like_post_id = $post_id AND like_user_id = $user_id AND like_status = 1";
    $like_result = mysqli_query($connection, $like_query);
    if (mysqli_num_rows($like_result) > 0) {
        echo
        "
        <div class='like' style='display: flex;justify-content:center;gap:3rem;'>
        <span>Liked this post? Leave a like...</span>
        <i class='ri-heart-fill btn liked'> 
        ";
    } else {
        echo
        "
        <div class='like' style='display: flex;justify-content:center;gap:3rem;'>
        <span>Liked this post? Leave a like...</span>
        <i class='ri-heart-line btn unliked'>
        ";
    }
}
