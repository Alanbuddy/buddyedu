$(document).ready(function(){
  
  $(".close").click(function(){
    $("#addModal").modal("hide");
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
            console.log(data);
            total = data.total;
            $(".checkbox-items .checkbox").remove();
            for(var i=0;i<data.data.length;i++){
              var check_item = $('<div class="checkbox">' +
                                    '<label>' +
                                      '<input type="checkbox" name="lesson-check" value=' + data.data[i].id + ' data-text="' + data.data[i].name + '"/>' + data.data[i].name +
                                    '</label>' +
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
});