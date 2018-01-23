$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.students_search + "?key=" + value;
  }
    
  $("#search-btn").click(function(){
    search();
  });

  $("#search-input").keydown(function(event){
    var code = event.which;
    if (code == 13){
      search();
    }
  });


  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});