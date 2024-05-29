$(document).ready(function () {
  // Nav styles on scroll
  const scrollHeader = () => {
    const navbarElement = $("#header");
    if ($(window).scrollTop() >= 15) {
      navbarElement.addClass("activated");
    } else {
      navbarElement.removeClass("activated");
    }
  };

  $(".tab").on("click", function () {
    console.log("hello");
    $("html, body").animate(
      {
        scrollTop: $("#posts-section").offset().top,
      },
      250
    ); // Adjust the duration as needed
  });

  $(window).on("scroll", scrollHeader);

  // Open menu & search pop-up
  const menuToggleIcon = $("#menu-toggle-icon");
  const formOpenBtn = $("#search-icon");
  const formCloseBtn = $("#form-close-btn");
  const searchContainer = $("#search-form-container");
  const category = $(".category");
  const categoryDropdown = $(".category-dropdown");
  const lgAvatarDropdown = $("#lg-avatar");

  const categoryDropdownToggle = () => {
    categoryDropdown.toggleClass("category-dropdown-height");
  };

  category.on("click", categoryDropdownToggle);

  const toggleMenu = () => {
    const mobileMenu = $("#menu");
    mobileMenu.toggleClass("activated");
    menuToggleIcon.toggleClass("activated");
  };

  menuToggleIcon.on("click", toggleMenu);

  lgAvatarDropdown.on("click", function () {
    $("#menu-2").toggleClass("activated");
  });

  // Switch theme/add to local storage
  const body = $("body");
  const themeToggleBtn = $("#theme-toggle-btn");
  const currentTheme = localStorage.getItem("currentTheme");

  if (currentTheme) {
    body.addClass("light-theme");
  }

  themeToggleBtn.on("click", function () {
    body.toggleClass("light-theme");
    if (body.hasClass("light-theme")) {
      localStorage.setItem("currentTheme", "themeActive");
    } else {
      localStorage.removeItem("currentTheme");
    }
  });

  // Swiper
  const swiper = new Swiper(".mySwiper", {
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 1500,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      700: {
        slidesPerView: 2,
      },
      1200: {
        slidesPerView: 3,
      },
    },
  });

  // Registration Sign in / Sign up Modal
  const registrationModal = function () {
    var $form_modal = $(".cd-user-modal"),
      $form_login = $form_modal.find("#cd-login"),
      $form_signup = $form_modal.find("#cd-signup"),
      $form_forgot_password = $form_modal.find("#cd-reset-password"),
      $form_modal_tab = $(".cd-switcher"),
      $tab_login = $form_modal_tab.children("li").eq(0).children("a"),
      $tab_signup = $form_modal_tab.children("li").eq(1).children("a"),
      $forgot_password_link = $form_login.find(".cd-form-bottom-message a"),
      $back_to_login_link = $form_forgot_password.find(
        ".cd-form-bottom-message a"
      ),
      $main_nav = $(".main-nav");

    //open modal
    $main_nav.on("click", function (event) {
      if ($(event.target).is($main_nav)) {
        // on mobile open the submenu
        $(this).children("ul").toggleClass("is-visible");
      } else {
        // on mobile close submenu
        $main_nav.children("ul").removeClass("is-visible");
        //show modal layer
        $form_modal.addClass("is-visible");
        //show the selected form
        $(event.target).is(".cd-signup") ? signup_selected() : login_selected();
      }
    });

    //close modal
    $(".cd-user-modal").on("click", function (event) {
      if (
        $(event.target).is($form_modal) ||
        $(event.target).is(".cd-close-form")
      ) {
        $form_modal.removeClass("is-visible");
      }
    });
    //close modal when clicking the esc keyboard button
    $(document).keyup(function (event) {
      if (event.which == "27") {
        $form_modal.removeClass("is-visible");
      }
    });

    //switch from a tab to another
    $form_modal_tab.on("click", function (event) {
      event.preventDefault();
      $(event.target).is($tab_login) ? login_selected() : signup_selected();
    });

    //hide or show password
    $(".hide-password").on("click", function () {
      var $this = $(this),
        $password_field = $this.prev("input");

      "password" == $password_field.attr("type")
        ? $password_field.attr("type", "text")
        : $password_field.attr("type", "password");
      "Hide" == $this.text() ? $this.text("Show") : $this.text("Hide");
      //focus and move cursor to the end of input field
      $password_field.putCursorAtEnd();
    });

    //show forgot-password form
    $forgot_password_link.on("click", function (event) {
      event.preventDefault();
      forgot_password_selected();
    });

    //back to login from the forgot-password form
    $back_to_login_link.on("click", function (event) {
      event.preventDefault();
      login_selected();
    });

    function login_selected() {
      $form_login.addClass("is-selected");
      $form_signup.removeClass("is-selected");
      $form_forgot_password.removeClass("is-selected");
      $tab_login.addClass("selected");
      $tab_signup.removeClass("selected");
    }

    function signup_selected() {
      $form_login.removeClass("is-selected");
      $form_signup.addClass("is-selected");
      $form_forgot_password.removeClass("is-selected");
      $tab_login.removeClass("selected");
      $tab_signup.addClass("selected");
    }

    function forgot_password_selected() {
      $form_login.removeClass("is-selected");
      $form_signup.removeClass("is-selected");
      $form_forgot_password.addClass("is-selected");
    }
    jQuery.fn.putCursorAtEnd = function () {
      return this.each(function () {
        if (this.setSelectionRange) {
          var len = $(this).val().length * 2;
          this.setSelectionRange(len, len);
        } else {
          $(this).val($(this).val());
        }
      });
    };
  };
  registrationModal();

  const signupValidation = function () {
    const createPasswordLength = $("#signup-create-password").val().length;
    const createPassword = $("#signup-create-password").val();
    const confirmPassword = $("#signup-confirm-password").val();
    if (createPasswordLength > 3 && createPassword === confirmPassword)
      $('input[name="submit-signup"]').prop("disabled", false);

    $("#signup-create-password").keyup(function () {
      const createPassword = $("#signup-create-password").val();
      const confirmPasswordEl = $("#signup-confirm-password");

      if (createPassword >= 1) {
        confirmPasswordEl.prop("disabled", false);
      } else {
        confirmPasswordEl.prop("disabled", true);
      }
    });

    $("#signup-create-password").keyup(function () {
      const createPasswordLength = $("#signup-create-password").val().length;
      const createPassword = $("#signup-create-password").val();
      const confirmPassword = $("#signup-confirm-password").val();
      console.log(createPassword);

      if (createPasswordLength > 0 && createPasswordLength <= 3) {
        $("#signup-create-password").addClass("has-error");
        $("#error-create-password").addClass("is-visible");
      } else {
        $("#signup-create-password").removeClass("has-error");
        $("#error-create-password").removeClass("is-visible");
      }

      if (createPassword === confirmPassword || confirmPassword === "") {
        $("#signup-confirm-password").removeClass("has-error");
        $("#error-confirm-password").removeClass("is-visible");
      } else {
        $("#signup-confirm-password").addClass("has-error");
        $("#error-confirm-password").addClass("is-visible");
      }

      if (
        confirmPassword === createPassword &&
        confirmPassword !== "" &&
        createPasswordLength > 3
      ) {
        $('input[name="submit-signup"]').prop("disabled", false);
      } else {
        $('input[name="submit-signup"]').prop("disabled", true);
      }
    });

    $("#signup-confirm-password").keyup(function () {
      const createPassword = $("#signup-create-password").val();
      const confirmPassword = $("#signup-confirm-password").val();
      const createPasswordLength = $("#signup-create-password").val().length;

      if (confirmPassword !== createPassword && confirmPassword !== "") {
        $("#signup-confirm-password").addClass("has-error");
        $("#error-confirm-password").addClass("is-visible");
      } else {
        $("#signup-confirm-password").removeClass("has-error");
        $("#error-confirm-password").removeClass("is-visible");
      }

      if (
        confirmPassword === createPassword &&
        confirmPassword !== "" &&
        createPasswordLength > 3
      ) {
        $('input[name="submit-signup"]').prop("disabled", false);
      } else {
        $('input[name="submit-signup"]').prop("disabled", true);
      }
    });
  };
  signupValidation();

  var offset = 0;
  $("#commentForm").submit(function (e) {
    e.preventDefault();
    offset++;
    const post_id = $(".blog-post-title").attr("id");
    var comment = $("#commentText").val();

    $.ajax({
      url: "load_comments",
      type: "POST",
      data: {
        add_comment: 1,
        post: post_id,
        comment_content: comment,
      },
      success: function (response) {
        $("#commentText").val(""); // Clear the textarea
        res = jQuery.parseJSON(response);
        $("#comment-body").prepend(res.message);
        alertify.set("notifier", "position", "bottom-right");
        alertify.success("New comment added!");
        $(".total-comment").load(location.href + " .total-comment");
      },
    });
  });

  var comment_count = -5;
  function load_comments(e) {
    const post_id = $(".blog-post-title").attr("id");
    comment_count += 5;
    comment_count += offset;
    // alert(comment_count);
    $("#comment-loader").css("display", "block");
    $.ajax({
      url: "load_comments",
      type: "POST",
      data: {
        load_comment: 1,
        post: post_id,
        comment_count: comment_count,
      },
      success: function (response) {
        res = jQuery.parseJSON(response);
        $("#comment-body").append(res.message);
        $("#comment-loader").css("display", "none");
        if (res.status == "no") {
          $("#load-more-comment").remove();
        }
      },
    });
  }
  load_comments();
  $("#load-more-comment").click(load_comments);

  const categorySlider = function () {
    const tabsBox = document.querySelector(".tabs-box"),
      allTabs = document.querySelectorAll(".tab"),
      arrowIcons = document.querySelectorAll(".icon i");

    let isDragging = false;

    const handleIcons = (scrollVal) => {
      let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;
      arrowIcons[0].parentElement.style.display =
        scrollVal <= 0 ? "none" : "flex";
      arrowIcons[1].parentElement.style.display =
        maxScrollableWidth - scrollVal <= 1 ? "none" : "flex";
    };

    arrowIcons.forEach((icon) => {
      icon.addEventListener("click", () => {
        // if clicked icon is left, reduce 350 from tabsBox scrollLeft else add
        let scrollWidth = (tabsBox.scrollLeft +=
          icon.id === "left" ? -340 : 340);
        handleIcons(scrollWidth);
      });
    });

    allTabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        tabsBox.querySelector(".active").classList.remove("active");
        tab.classList.add("active");
      });
    });

    const dragging = (e) => {
      if (!isDragging) return;
      tabsBox.classList.add("dragging");
      tabsBox.scrollLeft -= e.movementX;
      handleIcons(tabsBox.scrollLeft);
    };

    const dragStop = () => {
      isDragging = false;
      tabsBox.classList.remove("dragging");
    };

    tabsBox.addEventListener("mousedown", () => (isDragging = true));
    tabsBox.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);
  };
  categorySlider();

  const categoyBlogPosts = function () {
    const tabs = $(".tab");
    const loader = $(".loader ");

    tabs.each(function () {
      $(this).click(function (e) {
        e.preventDefault();
        $(".loader").css("display", "block");
        var category = $(this).text().trim();
        console.log(category);
        $.ajax({
          url: "category_blog_posts",
          type: "POST",
          data: {
            load_category_blog_posts: true,
            category: category,
          },
          success: function (response) {
            res = jQuery.parseJSON(response);
            $(".loader").css("display", "none");
            $("#blog-posts").html(res.message);
          },
        });
      });
    });
  };
  categoyBlogPosts();

  // Search

  $(".tab").on("click", function () {
    console.log("hello");
    $("html, body").animate(
      {
        scrollTop: $("#posts-section").offset().top,
      },
      500
    ); // Adjust the duration as needed
  });

  $("#search").submit(function (e) {
    e.preventDefault();
    if ($("#search-input").val() !== "") {
      var search = $("#search-input").val();
      $("html, body").animate(
        {
          scrollTop: $("#posts-section").offset().top,
        },
        250
      );
      $(".loader").css("display", "block");
      $.ajax({
        url: "category_blog_posts",
        type: "POST",
        data: {
          search: true,
          search_category: search,
        },
        success: function (response) {
          res = jQuery.parseJSON(response);
          $(".loader").css("display", "none");
          $("#blog-posts").html(res.message);
        },
      });
    }
  });
});

$(document).ready(function () {
  const search = function () {
    var $searchInput = $("#search-input");
    var $searchBtn = $("#search-btn");
    var $searchForm = $("#search");

    $searchBtn.on("click", function (event) {
      // event.preventDefault();
      $searchInput.addClass("visible").focus();
    });

    $(document).on("click", function (event) {
      if (
        !$searchForm.is(event.target) &&
        $searchForm.has(event.target).length === 0
      ) {
        $searchInput.removeClass("visible");
        $("#search-input").val("");
      }
    });
    // Close the search form popup on ESC keypress
    $(window).on("keyup", (event) => {
      if (event.key === "Escape") {
        $searchInput.removeClass("visible");
        $("#search-input").val("");
      }
    });
  };
  search();
});

$(document).ready(function () {
  $(".like i").on("click", function (event) {
    if ($(this).hasClass("unliked")) {
      console.log(user_id);
      const post_id = $(".blog-post-title").attr("id");
      $.ajax({
        url: "load_comments",
        type: "POST",
        data: {
          add_like: true,
          post: post_id,
          user_id: user_id,
        },
        success: function (response) {
          res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $(".like i").toggleClass("ri-heart-line ri-heart-fill");
            $(".like i").addClass("liked");
            $(".like i").removeClass("unliked");
          }
          $("#likes-count").load(location.href + " #likes-count");
        },
      });
    } else if ($(".like i").hasClass("liked")) {
      console.log(user_id);
      const post_id = $(".blog-post-title").attr("id");
      $.ajax({
        url: "load_comments",
        type: "POST",
        data: {
          remove_like: true,
          post: post_id,
          user_id: user_id,
        },
        success: function (response) {
          res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $(".like i").toggleClass("ri-heart-line ri-heart-fill");
            $(".like i").removeClass("liked");
            $(".like i").addClass("unliked");
          }
          $("#likes-count").load(location.href + " #likes-count");
        },
      });
    }
  });
});
