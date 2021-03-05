$(document).ajaxStart(function () {
  $(".loading-overlay").show();
});

$(document).ajaxStop(function () {
  $(".loading-overlay").hide();
});

function searchFilter(page_num) {
  page_num = page_num ? page_num : 0;
  $.ajax({
    type: "POST",
    url: "datos.php",
    data: "page=" + page_num,
    beforeSend: function () {
      $(".loading-overlay").show();
    },
    success: function (html) {
    console.log(page_num);
      $("#contenido").html(html);
      $(".loading-overlay").fadeOut("slow");
    },
  });
}
