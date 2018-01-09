$(document).ready(function(){
  $(".mine").click(function(){
    $("#profileModal").modal("show");
  });

  $(".close").click(function(){
    $("#profileModal").modal("hide");
  });
});