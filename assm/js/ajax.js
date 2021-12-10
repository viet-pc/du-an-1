$(document).ready(function () {
  $("#addtocard").click(function () {
    let id = $("#addtocard").data("id");
    $.ajax({
      url: "http://localhost/Php1/assm/ajax/add_bag",
      type: "POST",
      dataType: "html",
      data: {
        id: id,
      },
    }).done(function (product_data) {
      if (Number(product_data) == NaN) {
        $("tbody").append(product_data);
      } else {
        let so = Number(product_data.substr(1));
        $("td[data-id]").each(function () {
          if ($(this).data("id") == id) {
            console.log($(this).parent().children(".soluong").text(so));
          }
        });
      }

      // alert(product_data);
    });
  });
});
