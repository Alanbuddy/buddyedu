
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
          $.each(data.data, function (index, item) {  
            var id = item.id; 
            var text = item.name;
            var guide_price = item.guide_price;
            var is_batch = item.pivot.is_batch;
            $("#course").append("<option value='"+id+ "'data-price='" + guide_price + "'data-batch='" + is_batch + "'>"+text+"</option>");
        }); 
        }
      }
    });
  }

  courseSelect();

  $("#course").on('change', function(){
    var guide_price = $(this).find('option:selected').attr("data-price");
    var is_batch = $(this).find('option:selected').attr("data-batch");
    if(is_batch == "1"){
      $(this).closest('.controls').siblings("#course-price").hide();
      $(this).closest('.controls').siblings("#desc").hide();
      $(this).closest('.controls').siblings("#course-num").hide();
      $(this).closest('.controls').siblings("#course-time").hide();
      $("#addModal").find(".modal-dialog").css({"margin-top":"-282px","height": "564px"});
    }else{
      $(this).closest('.controls').siblings("#course-price").show();
      $(this).closest('.controls').siblings("#desc").show();
      $(this).closest('.controls').siblings("#course-num").show();
      $(this).closest('.controls').siblings("#course-time").show();
      $("#addModal").find(".modal-dialog").css({"margin-top":"-377px","height": "754px"});
      if(guide_price != ""){
        $("#course-desc").text(guide_price).css("margin-left", "8px");
        $("#course-price").removeClass('mb24');
        $("#desc").show();
      }
    }
  });

  $("#apply").click(function(){
    var is_batch = $("#course").find('option:selected').attr("data-batch");
    console.log(is_batch);
  	var course = $("#course").val();
  	var point = $("#point").val();
  	var teacher = $("#teacher-select").val();
  	var num = $("#num").val().trim();
    var begin = $("#datepicker1").val();
    var end = $("#datepicker2").val();
    var time = $("#time").val().trim();
    var price = $("#price").val().trim() * 100;
    var remark = $("#remark").val().trim();
    var lessons_count = $("#lessons-count").val().trim();
    console.log(price);
    if(is_batch == 0){
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
          time: time,
          price: price,
          remark: remark,
          lessons_count: lessons_count
        },
        success: function( data ) {
          if(data.success){
            location.href = window.course_search;
          }
        }
      });
    }else{
      $.ajax({
        url: window.course_store,
        type: 'post',
        data: {
          _token: window.token,
          course_id: course,
          point_id: point,
          teachers: teacher,
          begin: begin,
          end: end,
          remark: remark,
          lessons_count: lessons_count
        },
        success: function( data ) {
          if(data.success){
            location.href = window.course_search;
          }
        }
      });
    }
  	
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


  $(".tip-parent").hover(function(){
    $(this).find(".tooltip-div").show();
    var link = $(this).find(".course-link").attr("data-link");
    $(this).find(".course-link").val(link);
  },function(){
    $(this).find(".tooltip-div").hide();
  });

  $(".close").click(function(){
    $(this).closest('.tooltip-div').hide();
  });

  $(".copy").click(function(){
    $('.course-link').select();
    document.execCommand("Copy");
  });
  
});