// comment ajax
$(document).ready(function() {
  $("body").on('click', '.submit_comment', function() {
    var content = $(".comment_content").val();
    var userid = $(".comment_content").attr("uid");
    var member = $(".comment_content").attr("member");
    var id = $(".submit_comment").attr("new_id");
    if(content != ""){
    $.ajax({
      url: '/templates/share/ajax/commentAjax.php',
      type: 'post',
      cache: false,
      async: true,
      data: {
        acontent: content,
        auserid: userid,
        amember: member,
        aid: id
      },
      success: function(data){
        // console.log(data);
        if(data[2] == "l"){
          if($("#binhluan li").length == 0){
            $("#binhluan").html(data);
          }else{
            $("#binhluan li:eq(0)").before(data);
          }
          $(".comment_content").val("");
        }else if(data[2] == "i"){
          $(".kqua").html(data);
        }
      },
      error: function(){
        alert("Có lỗi xảy ra");
      }
    });
    return false;
  }
  });
});
//show comment
$(document).ready(function(){
  $("body").on('click', '.showcmt', function(){
    var id = $(this).attr("idshow");
    $(".repcomment"+id).slideToggle();
    $("#showcmt"+id).hide();
    $(".replay_cmt"+id).slideToggle();
    $("#rep-ashow"+id).hide();
    $("#rep-ahide"+id).show();
  });
});

$(document).ready(function(){
  $(".rep-ahide").hide();
  $("body").on('click', '.rep-ashow', function(){
    var id = $(this).attr("id-repshow");
    $(".replay_cmt"+id).slideToggle();
    $("#rep-ashow"+id).hide();
    $("#rep-ahide"+id).show();
    $(".repcomment"+id).slideToggle();
    $("#showcmt"+id).hide();
  });
  $("body").on('click', '.rep-ahide', function(){
    var id = $(this).attr("id-rephide");
    $(".replay_cmt"+id).slideToggle();
    $("#rep-ashow"+id).show();
    $("#rep-ahide"+id).hide();
    $(".repcomment"+id).slideToggle();
    $("#showcmt"+id).show();
  });
});

// replay_comment
$(document).ready(function(){
  $("body").on('click', '.submit_replay', function(){
    var idnews = $(this).attr("id_news");
    var idcmtrep = $(this).attr("idcmtrep");
    var contentrep = $(".content_replay"+idcmtrep).val();
    var useridrep = $(".replay_cmt"+idcmtrep).attr("userid");
    var total = $(".replay_cmt"+idcmtrep).attr("total");
    var member = $(".replay_cmt"+idcmtrep).attr("member");
    if(contentrep != ""){
    $.ajax({
      url: '/templates/share/ajax/repCommentAjax.php',
      type: 'post',
      cache: false,
      async: true,
      data: {
        atotal: total,
        aidnews: idnews,
        aidcmtrep: idcmtrep,
        acontentrep: contentrep,
        auseridrep: useridrep,
        amember: member,
      },
      success: function(data){
        if(data[2] == "l"){
          var rs = data.split("**");
          $(".repcomment"+idcmtrep).append(rs[0]);
          $("#total"+idcmtrep).html(rs[1]);
          $(".replay_cmt"+idcmtrep).attr("total", rs[1]);
          $(".content_replay"+idcmtrep).val("");
        }else if(data[2] == "i"){
          $(".kquarep"+idcmtrep).html(data);
        }
      },
      error: function(){
        alert("Có lỗi xảy ra");
      }
    });
    return false;
    }
  });
});

// search ajax
$(document).ready(function(){
  function load_data(search)
  {
    $.ajax({
      url:"/templates/admin/ajax/searchAjax.php",
      method:"post",
      data:{search:search},
      success:function(data)
      {
        $('#dataTables-example').html(data);
      }
    });
  }
  $('#search_text').keyup(function(){
    var search = $(this).val();
    if(search != '')
    {
      load_data(search);
    }
    else
    {
      load_data();      
    }
  });
});
// checkselected ajax
$(function (){
    $("#checkall").click (function () {
        var checkedStatus = this.checked;
        $("#dataTables-example tbody tr").find(":checkbox").each(function () {
            $(this).prop("checked", checkedStatus);
        });
    });
});
// active news ajax
$(document).ready(function() {
  $("body").on('click', '.active', function(){
    var vitri = $(this);
    var id = $(this).attr("id");
    var active = $(this).attr("active");
    if(active == 1){
        $(this).attr("active", 0);
    }else{
        $(this).attr("active", 1);
    }
    // alert(active);
    $.ajax({
        url: '/templates/admin/ajax/activeAjax.php',
        type: 'get',
        cache: false,
        data: {
            aid: id,
            aactive: active
        },
        success: function(data){
          var result = data.split("-");
          $(vitri).children("img").attr("src", result[0]);
          if(result[1] == 0){
            $("#resultdeactive").hide();
          }else{
            $("#resultdeactive").html(result[1]);
            $("#resultdeactive").show();
          }
        },
        error: function(){
            alert("Có lỗi xảy ra");
        }
    });
  });    
});

// active comment ajax
$(document).ready(function() {
  $("body").on('click', '.activecomment', function(){
      var vitri = $(this);
      var id = $(this).attr("id");
      var active = $(this).attr("active");
      if(active == 1){
          $(this).attr("active", 0);
      }else{
          $(this).attr("active", 1);
      }
      $.ajax({
          url: '/templates/admin/ajax/activeCommentAjax.php',
          type: 'get',
          cache: false,
          data: {
            aid: id,
            aactive: active
          },
          success: function(data){
            var result = data.split("**");
              $(vitri).children("img").attr("src", result[0]);
              if(result[1] == 0){
                $("#resultcomment").hide();
              }else{
                $("#resultcomment").html(result[1]);
                $("#resultcomment").show();
              }
          },
          error: function(){
              alert("Có lỗi xảy ra");
          }
      });
  });    
});

// active user ajax
$(document).ready(function() {
  $("body").on('click', '.activeuser', function(){
      var vitri = $(this);
      var id = $(this).attr("id");
      var active = $(this).attr("active");
      if(active == 1){
          $(this).attr("active", 0);
      }else{
          $(this).attr("active", 1);
      }
      $.ajax({
          url: '/templates/admin/ajax/activeUserAjax.php',
          type: 'get',
          cache: false,
          data: {
              aid: id,
              aactive: active
          },
          success: function(data){
            var result = data.split("***");
            $(vitri).children("img").attr("src", result[0]);
            if(result[1] == 0){
              $("#resultuser").hide();
            }else{
              $("#resultuser").html(result[1]);
              $("#resultuser").show();
            }
          },
          error: function(){
            alert("Có lỗi xảy ra");
          }
      });
  });    
});

$(document).ready(function(){
  $(".tkus").mouseenter(function(){
    $(".drop-down").slideToggle();
  });
});

//pagination cat ajax
$(document).ready(function() {
  var cat_id = $(".single_post_content_left").attr("cat_id");
  load_data();
  function load_data(page){
    $.ajax({
      url: '/templates/share/ajax/paginationCatAjax.php',
      method: 'post',
      data:{
        cat_id: cat_id,
        page: page
      },
      success: function(data){
        $("#results1").html(data);
      }
    });
  } 
  // $(".loading-div").show();
  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    $(".loading-div").show(); 
    var page = $(this).attr("data-page");
    setTimeout(function hidediv(){
      $(".loading-div").hide();
    }, 400); 
    load_data(page);
  });
});

//pagination search ajax
$(document).ready(function() {
  var search = $(".single_post_content_left").attr("search");
  load_data();
  // alert(search);
  function load_data(page){
    $.ajax({
      url: '/templates/share/ajax/paginationSearchAjax.php',
      method: 'get',
      data:{
        search: search,
        page: page
      },
      success: function(data){
        $("#results").html(data);
      }
    });
  } 
  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    $(".loading-div").show(); 
    var page = $(this).attr("id");
    setTimeout(function hidediv(){
      $(".loading-div").hide();
    }, 400); 
    load_data(page);
  });
});
