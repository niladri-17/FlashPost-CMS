$(document).ready(function () {
  $("#show_hide_password1 a").on("click", function (event) {
    event.preventDefault();
    if ($("#show_hide_password1 input").attr("type") == "text") {
      $("#show_hide_password1 input").attr("type", "password");
      $("#show_hide_password1 i").addClass("fa-eye-slash");
      $("#show_hide_password1 i").removeClass("fa-eye");
    } else if ($("#show_hide_password1 input").attr("type") == "password") {
      $("#show_hide_password1 input").attr("type", "text");
      $("#show_hide_password1 i").removeClass("fa-eye-slash");
      $("#show_hide_password1 i").addClass("fa-eye");
    }
  });

  $("#show_hide_password2 a").on("click", function (event) {
    event.preventDefault();
    if ($("#show_hide_password2 input").attr("type") == "text") {
      $("#show_hide_password2 input").attr("type", "password");
      $("#show_hide_password2 i").addClass("fa-eye-slash");
      $("#show_hide_password2 i").removeClass("fa-eye");
    } else if ($("#show_hide_password2 input").attr("type") == "password") {
      $("#show_hide_password2 input").attr("type", "text");
      $("#show_hide_password2 i").removeClass("fa-eye-slash");
      $("#show_hide_password2 i").addClass("fa-eye");
    }
  });

  // Activate tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Select/Deselect checkboxes
  var checkbox = $('table tbody input[type="checkbox"]');
  $("#selectAll").click(function () {
    if (this.checked) {
      checkbox.each(function () {
        this.checked = true;
      });
    } else {
      checkbox.each(function () {
        this.checked = false;
      });
    }
  });
  checkbox.click(function () {
    if (!this.checked) {
      $("#selectAll").prop("checked", false);
    }
  });

  //   Datatables init
  $("#manage-users").DataTable({
    columnDefs: [
      {
        targets: [0, 6],
        orderable: false,
      },
    ],
  });
  // $("#manage-category").DataTable({
  //   columnDefs: [
  //     {
  //       targets: [0, 3],
  //       orderable: false,
  //     },
  //   ],
  // });

  $("#manage-posts,#user-posts,#manage-posts-by-user").DataTable({
    columnDefs: [
      {
        targets: [0, 6],
        orderable: false,
      },
    ],
  });
  $(".phone-mask").mask("0000-0000-00");

  $("#summernote").summernote();

  // Delete single user
  $(".confirm_delete_btn").click(function (e) {
    // e.preventDefault();
    delete_user_id = $(this).attr("id");
    $("#confirm_delete_id").val(delete_user_id);
    // alert(user_id)

    $("#deleteUserModal").modal("show");

    $("#delete-user").click(function (e) {
      // e.preventDefault();
      $.ajax({
        url: "manage-users", //not url: "manage-users.php" due to .htaccess rules
        method: "POST",
        data: {
          confirm_delete_btn: true,
          delete_id: delete_user_id,
        },
        success: function (result) {
          // console.log(result);
          $("#manage-users").load(location.href + " #manage-users");
        },
      });
    });
  });

  // Delete multiple users at once by selecting the checkbox
  $(".delete_multiple_user_btn").click(function (e) {
    // e.preventDefault();
    let selectedCheckboxes = [];
    $('input[type="checkbox"]:checked').each(function () {
      // Push the ID of the selected checkbox into the array
      if ($(this).attr("value") !== undefined && $(this).attr("value") !== "")
        selectedCheckboxes.push($(this).attr("value"));
    });
    $("#confirm_delete_id").val(selectedCheckboxes);

    $("#deleteUserModal").modal("show");

    $("#delete-user").click(function (e) {
      // e.preventDefault();
      $.ajax({
        url: "manage-users",
        method: "POST",
        data: {
          confirm_delete_multiple_btn: true,
          delete_ids: selectedCheckboxes,
        },
        success: function (result) {
          // console.log(result);
          $("#manage-users").load(location.href + " #manage-users");
        },
      });
    });
  });

  // Edit single Category
  $(".edit-category-btn").click(function (e) {
    // e.preventDefault();
    var edit_category_id = $(this).attr("id");
    var edit_category_title = $("#category-title").val();
    var cat_td = $(this).parent().siblings()[2];
    $("#category-title").val($(cat_td).text());

    $("#editCategoryModal").modal("show");

    $("#edit-category").click(function (e) {
      // e.preventDefault();
      edit_category_title = $("#category-title").val();
      $.ajax({
        url: "",
        method: "POST",
        data: {
          edit_category: true,
          edit_id: edit_category_id,
          edit_title: edit_category_title,
        },
        success: function (result) {
          // console.log(result);
          alertify.set("notifier", "position", "top-right");
          alertify.success("Edited");
          // $("#manage-category").load(location.href);
          location.reload();
        },
      });
    });
  });

  // Delete single Category
  $(".delete-category-btn").click(function (e) {
    // e.preventDefault();
    delete_category_id = $(this).attr("id");

    $("#deleteCategoryModal").modal("show");

    $("#delete-category").click(function (e) {
      // e.preventDefault();
      $.ajax({
        url: "", //not url: "manage-users.php" due to .htaccess rules
        method: "POST",
        data: {
          delete_category: true,
          delete_id: delete_category_id,
        },
        success: function (result) {
          // console.log(result);
          // $("#manage-category").load(location.href + " #manage-category");
          location.reload();
        },
      });
    });
  });

  // Delete multiple category at once by selecting the checkbox
  $(".delete-multiple-category-btn").click(function (e) {
    // e.preventDefault();
    let selectedCheckboxes = [];
    $('input[type="checkbox"]:checked').each(function () {
      // Push the ID of the selected checkbox into the array
      if ($(this).attr("value") !== undefined && $(this).attr("value") !== "")
        selectedCheckboxes.push($(this).attr("value"));
    });

    $("#deleteUserModal").modal("show");

    $("#delete-category").click(function (e) {
      // e.preventDefault();
      $.ajax({
        url: "",
        method: "POST",
        data: {
          delete_multiple_category: true,
          delete_ids: selectedCheckboxes,
        },
        success: function (result) {
          // console.log(result);
          // $("#manage-category").load(location.href + " #manage-category");
          location.reload();
        },
      });
    });
  });
});
