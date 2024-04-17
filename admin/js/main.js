$(document).ready(function () {
  $(".menu-btn").click(function () {
    $(".sidebar").css({
      width: "70px",
      "font-size": "35px",
      "margin-top": "-5px",
    });
    $(".text-link").hide();
    $(".close-btn").show();
    $(".menu-btn").hide();
  });

  $(".close-btn").click(function () {
    $(".sidebar").css({
      width: "300px",
      "font-size": "16px",
    });
    $(".text-link").show();
    $(".close-btn").hide();
    $(".menu-btn").show();
  });

  $(".add_category").click(function () {
    $("#catModal").modal("show");
    $(".modal-title").text("Add New Category");
    $("#form_type").val("save");
  });

  $(".add_brand").click(function () {
    $("#brandModal").modal("show");
    $(".modal-title").text("Add New Brand");
    $("#form_type").val("save");
  });

  $(".add_product").click(function () {
    $("#productModal").modal("show");
    $(".modal-title").text("Add New Product");
    $("#form_type").val("save");
  });

  $("#category_name").change(function () {
    var cat_id = $(this).val();
    $.ajax({
      url: "action/cat_action.php",
      type: "POST",
      data: {
        cat_id: cat_id,
        action: "fetch_brand",
      },
      success: function (response) {
        $("#brand_name").html(response);
      },
    });
  });
  var count = 0;
  $(".add-more-thumbnail").click(function () {
    count++;
    var html = '<div class="row" id="row-' + count + '">';
    html += '<div class="col-md-12">';
    html += "    <label>Add More Thumbnails</label>";
    html += "</div>";
    html += '<div class="col-md-10">';
    html += '    <input type="file" name="" class="form-control" id="">';
    html += "</div>";
    html += '<div class="col-md-2">';
    html +=
      '    <button type="button" id="' +
      count +
      '" class="btn btn-danger btn-block shadow-none remove">Remove</button>';
    html += "</div>";
    html += "</div>";

    $(".extra-thumbnail-area").append(html);
  });

  $(document).on("click", ".remove", function () {
    var row_data = $(this).attr("id");
    $("#row-" + row_data).remove();
  });
});
