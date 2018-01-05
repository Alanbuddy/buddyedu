$(document).ready(function(){
  $(".tip-parent").each(function(){
    var mapContainer = $(this).find(".tooltip-div").find(".container")[0];
    var geo = $(this).attr("data-geo");
    var location = geo.slice(1, geo.length -1).split(",");
    function init() {
      var center = new qq.maps.LatLng(location[0], location[1]);
      var map = new qq.maps.Map(mapContainer,{
          center: center,
          zoom: 12
      });

      var anchor = new qq.maps.Point(6, 6),
          size = new qq.maps.Size(24, 24),
          origin = new qq.maps.Point(0, 0),
          icon = new qq.maps.MarkerImage('/icon/tick.png', size, origin, anchor);
      var marker = new qq.maps.Marker({
          icon: icon,
          map: map,
          position:map.getCenter()
        });
    }
    init();
  });

  $(".tip-parent").hover(function(){
    $(this).find(".tooltip-div").show();
  },function(){
    $(this).find(".tooltip-div").hide();
  });
  $(".tooltip-div").each(function(){
    _this = $(this);
    $(this).find(".close").click(function(){
      _this.hide();
    });
  });

  function search(){
    var value = $("#search-input").val();
    location.href = window.points_search + "?key=" + value;
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


  $(".approve").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var point_name = $(this).siblings('.point-name').text();
    var application_id = $(this).closest('tr').attr("data-id");
    $("#approveModal").modal("show");
    $("#approveModal").find(".approve-title").text('通过"' + merchant_name + '"申请添加"' + point_name + '"教学点的申请？');
    $("#approveModal").find(".application-id").text(application_id);
  });
  $(".close-approve").click(function(){
    $("#approveModal").modal("hide");
  });

  $(".reject").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var point_name = $(this).siblings('.point-name').text();
    var application_id = $(this).closest('tr').attr("data-id");
    $("#rejectModal").modal("show");
    $("#rejectModal").find(".reject-title").text('驳回"' + merchant_name + '"申请添加"' + point_name + '"教学点的申请？');
    $("#rejectModal").find(".application-id").text(application_id);
  });
  $(".close-reject").click(function(){
    $("#rejectModal").modal("hide");
  });

  $(".approve-btn").click(function(){
    var application_id = $(this).siblings('.application-id').text();
    var remark = $("#operation-info").val().trim();
    $.ajax({
      type: 'get',
      url: window.approve.replace(/-1/, application_id),
      data: {
        remark: remark
      },
      success: function(data){
        console.log(data);
        if (data.success){
          location.href = window.process_search;
        }
      }
    });
  });

  $(".reject-btn").click(function(){
    var application_id = $(this).siblings('.application-id').text();
    var remark = $("#operation-info").val().trim();
    $.ajax({
      type: 'get',
      url: window.reject.replace(/-1/, application_id),
      data: {
        remark: remark
      },
      success: function(data){
        console.log(data);
        if (data.success){
          location.href = window.process_search;
        }
      }
    });
  });
});