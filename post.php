<?php require "includes/header.php"; ?>
<?php if (!isset($_GET['post'])) header('Location: ' . ROOT_URL . 'blog'); ?>
<script>
  var user_id = <?= $_SESSION['user-id'] ?>
</script>

<section class="blog-post section-header-offset">
  <div class="blog-post-container container">
    <div class="blog-post-data">
      <?php post_data(); ?>

      <?php if (!isset($_SESSION['user-id'])) :  ?>
        <div style="display: flex;justify-content:center;gap:3rem;">
          <span>Liked this post? Leave a like... (
            <span class="main-nav"><a style="color:blue" href="#0" class="cd-signin">Sign in</a> / <a style="color:blue" href="#0" class="cd-signup">Sign up</a>
            </span> )
          </span>
          <i class="ri-heart-line btn" title="Sign in / Sign up to like this post"><span id="likes-count"><?php likes_count(); ?></span></i>
        </div>
      <?php else : ?>
        <?php like_status(); ?>
        <span id='likes-count'> <?php likes_count(); ?> </span></i>
        </div>
      <?php endif ?>

      <div class="comment-section">
        <div>
          <h3 class="comment-heading">Comments</h3>
          <div class="comment-box">
            <?php if (isset($_SESSION['user-id'])) : ?>
              <form id="commentForm">
                <textarea id="commentText" rows="3" class="comment-area" placeholder="Add a comment..." required></textarea>
                <button type="submit" class="btn comment-submit">Comment</button>
              </form>
            <?php else : ?>
              <div class="main-nav" style="margin-top: 1.5rem;">
                <a style="color:blue" href="#0" class="cd-signin">Sign in</a> / <a style="color:blue" href="#0" class="cd-signup">Sign up</a> to comment in this post.
              </div>
            <?php endif ?>
          </div>

          <div class="comment-body">
            <h3 class="total-comment"><?php total_comments(); ?></h3>
            <div id="comment-body"> </div>
          </div>
          <div id="comment-loader" style="display:none">Loading...
            <!-- <img src="<?= ROOT_URL . "assets/images/comment-loader.gif" ?>" alt=""> -->
          </div>
          <div id="load-more-comment" class="btn">Load more <i class="ri-arrow-down-s-line"></i></div>
        </div>
      </div>

    </div>

    <div class="see-more-container">
      <a href="#" class="btn see-more-btn place-items-center">See more <i class="ri-arrow-right-s-line"></i></a>
    </div>
  </div>
</section>

<?php require "includes/footer.php"; ?>