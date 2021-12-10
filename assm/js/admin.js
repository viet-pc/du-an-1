$(document).ready(function () {
  $("#table_id").DataTable();

  $(".changesp").on("click", function () {
    let parent = $(this).parent().parent();
    let id = parent.children(".id").text();
    console.log(id);
    $.ajax({
      url: "http://localhost/assm/ajax/changesp",
      type: "POST",
      dataType: "html",
      data: {
        id: id,
      },
    }).done(function (product_data) {
      parent.html(product_data);
      // alert(product_data);
    });
  });
  $("#addsp").click(function () {
    let parent = $("tbody");
    let id = parent.children(".id").text();
    console.log(parent);
    $.ajax({
      url: "http://localhost/assm/ajax/addsp",
      type: "POST",
      dataType: "html",
      data: {
        id: id,
      },
    }).done(function (product_data) {
      parent.append(product_data);
      // alert(product_data);
    });
  });
  $("#addkh").click(function () {
    let parent = $("tbody");
    let id = parent.children(".id").text();
    console.log(parent);
    $.ajax({
      url: "http://localhost/assm/ajax/addkh",
      type: "POST",
      dataType: "html",
      data: {
        id: id,
      },
    }).done(function (product_data) {
      parent.append(product_data);
      // alert(product_data);
    });
  });
  $(".changekh").on("click", function () {
    let parent = $(this);
    let id = $(this).parent().parent().children(".id").text();
    console.log(id);
    $.ajax({
      url: "http://localhost/assm/ajax/changekh",
      type: "POST",
      dataType: "html",
      data: {
        id: id,
      },
    }).done(function (product_data) {
      //parent.parent().parent().remove();
      parent.parent().parent().parent().html(product_data);
      alert(product_data);
    });
  });
});
