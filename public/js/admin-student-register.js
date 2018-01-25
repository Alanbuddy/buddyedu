$(document).ready(function(){
  
  $(".close").click(function(){
    $("#addModal").modal("hide");
    $("#addModal").find("input").val("");
  });

  var total = 0;
  var pageIndex = 0;     //页面索引初始值
  var pageSize = 10;     //每页显示条数初始化，修改显示条数，修改这里即可
  $(".add-icon").click(function(){
    InitTable(0);
    function PageCallback(index, jq) {
      InitTable(index);
      return false;
    }
    function InitTable(pageIndex) {
      $.ajax({
          type: "get",
          url: window.students_index,      //提交到一般处理程序请求数据
          data: "page=" + (pageIndex + 1),          //提交两个参数：pageIndex(页面索引)，pageSize(显示条数)
          success: function(data) {
            total = data.data.total;
            $(".checkbox-items .checkbox").remove();
            for(var i=0;i<data.data.data.length;i++){
              var check_item = $('<div class="checkbox f14d">' +
                                    '<label style="width: 150px">' +
                                      '<input type="checkbox" name="lesson-check" value=' + data.data.data[i].id + ' data-text="' + data.data.data[i].name + '"/>' + data.data.data[i].name +
                                    '</label>' +
                                    '<span class="ml40">' + data.data.data[i].phone + '</span>' +
                                '</div>');
              $(".checkbox-items").append(check_item);
            }
            $("#Pagination").pagination(total, {
              callback: PageCallback,  //PageCallback() 为翻页调用次函数。
              prev_text: "«上一页",
              next_text: "»下一页",
              items_per_page: pageSize,
              num_edge_entries: 2,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: pageIndex,   //当前页索引
              link_to: "",
            });
          }
      });
    }
    
    $("#addModal").modal("show");
  });

  function search(){
    var value = $("#search-input").val();
    location.href = window.register_search + "?key=" + value;
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

  $(".delete").click(function(){
    var sid = $(this).attr("data-id");
    var destroy = "DELETE";
    var _this = $(this);
    $.ajax({
      url: window.student_delete.replace(/-1/, sid),
      type: 'post',
      data: {
        _method: destroy,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          _this.closest('tr').remove();
        }
      }
    });
  });

  function modal_search(){
    var value = $("#modal-search-input").val();
    var total = 0;
    var pageIndex = 0;     //页面索引初始值
    var pageSize = 10;
    InitTable(0);
    function PageCallback(index, jq) {
      InitTable(index);
      return false;
    }
    function InitTable(pageIndex) {
      $.ajax({
          type: "get",
          url: window.students_index + "?key=" + value,      //提交到一般处理程序请求数据
          data: "page=" + (pageIndex + 1),          //提交两个参数：pageIndex(页面索引)，pageSize(显示条数)
          success: function(data) {
            total = data.data.total;
            $(".checkbox-items .checkbox").remove();
            for(var i=0;i<data.data.data.length;i++){
              var check_item = $('<div class="checkbox f14d">' +
                                    '<label style="width: 150px">' +
                                      '<input type="checkbox" name="lesson-check" value=' + data.data.data[i].id + ' data-text="' + data.data.data[i].name + '"/>' + data.data.data[i].name +
                                    '</label>' +
                                    '<span class="ml40">' + data.data.data[i].phone + '</span>' +
                                '</div>');
              $(".checkbox-items").append(check_item);
            }
            $("#Pagination").pagination(total, {
              callback: PageCallback,  //PageCallback() 为翻页调用次函数。
              prev_text: "«上一页",
              next_text: "»下一页",
              items_per_page: pageSize,
              num_edge_entries: 2,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: pageIndex,   //当前页索引
              link_to: "",
            });
          }
      });
    }
  }
    
  $("#modal-search-btn").click(function(){
    modal_search();
    $(".back").show();
  });

  $("#modal-search-input").keydown(function(event){
    var code = event.which;
    if (code == 13){
      modal_search();
      $(".back").show();
    }
  });

  $(".back").click(function(){
    $("#addModal").find("input").val("");
    InitTable(0);
    function PageCallback(index, jq) {
      InitTable(index);
      return false;
    }
    function InitTable(pageIndex) {
      $.ajax({
          type: "get",
          url: window.students_index,      //提交到一般处理程序请求数据
          data: "page=" + (pageIndex + 1),          //提交两个参数：pageIndex(页面索引)，pageSize(显示条数)
          success: function(data) {
            total = data.data.total;
            $(".checkbox-items .checkbox").remove();
            for(var i=0;i<data.data.data.length;i++){
              var check_item = $('<div class="checkbox f14d">' +
                                    '<label style="width: 150px">' +
                                      '<input type="checkbox" name="student-check" value=' + data.data.data[i].id + ' data-text="' + data.data.data[i].name + '"/>' + data.data.data[i].name +
                                    '</label>' +
                                    '<span class="ml40">' + data.data.data[i].phone + '</span>' +
                                '</div>');
              $(".checkbox-items").append(check_item);
            }
            $("#Pagination").pagination(total, {
              callback: PageCallback,  //PageCallback() 为翻页调用次函数。
              prev_text: "«上一页",
              next_text: "»下一页",
              items_per_page: pageSize,
              num_edge_entries: 2,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: pageIndex,   //当前页索引
              link_to: "",
            });
          }
      });
    }
    $(this).hide();
  });

  $("#confirm-btn").click(function(){
    var student_arr = [];
    $("[name='student-check']:input:checked").each(function(){
        var value = $(this).val();
        student_arr.push(value);
    });
    $.ajax({
      type: 'post',
      url: window.student_choice,
      data: {
        students: student_arr
      },
      success: function(data){
        if(data.success){
          $("[name='student-check']:input:checked").each(function(){
            this.checked = false;
          });
          $("#addModal").modal("hide");
          location.href = window.students_index;
        }
      }
    });
  });
});