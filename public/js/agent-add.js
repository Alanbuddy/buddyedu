
$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $('#teacher-select').select2({
  	placeholder: "请选择教师名"
  });
  
  function courseSelect(){

    $.ajax({
      type: 'get',
      url: window.course_select,
      success: function(data){
        if(data.success){
          console.log(data.data);
          $.each(data.data, function (index, item) {  
            var id = item.id; 
            var text = item.name; 
            $("#course").append("<option value='"+id+"'>"+text+"</option>");
        }); 
        }
      }
    });
  }

  courseSelect();

  $("#course").change(function(){
    $.ajax({
      type: 'get',
      url: window.course_select,
      success: function(data){
        if(data.success){
          $.each(data.data, function (index, item) {  
            var id = item.id; 
            var text = item.name; 
            var description = item.description;
            $("#course-desc").text(description);
        }); 
        }
      }
    });
  });

  $("#apply").click(function(){
  	var course = $("#course").val();
  	var point = $("#point").val();
  	var teacher = $("#teacher-select").val();
  	var num = $("#num").val().trim();
    var begin = $("#datepicker1").val();
    var end = $("#datepicker2").val();
    var price = $("#price").val().trim();
    var remark = $("#remark").val().trim();
  	$.ajax({
  	  url: window.course_store,
  	  type: 'post',
  	  data: {
  	    _token: window.token,
  	    course_id: course,
  	    point_id: point,
  	    teachers: teacher,
  	    quota: num,
  	    begin: begin,
  	    end: end,
        price: price,
        remark: remark
  	  },
  	  success: function( data ) {
  	    if(data.success){
          location.href = window.schedule_create;
        }
  	  }
  	});
  });

  $( "#datepicker1" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker1" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  $( "#datepicker2" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker2" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  function search(){
    var value = $("#search-input").val();
    location.href = window.course_search + "?key=" + value;
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



  
});