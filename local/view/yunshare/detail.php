<?php error_reporting(0);
require_once "./../../../publicWxAction/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk -> GetSignPackage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/app.css"/>
    <link rel="stylesheet" href="css/mui.min.css">
    <link rel="stylesheet" href="css/main.css?0002">    
    <style>

    .mui-preview-image.mui-fullscreen {
        position: fixed;
        z-index: 20;
        background-color: #000;
      }
      .mui-preview-header,
      .mui-preview-footer {
        position: absolute;
        width: 100%;
        left: 0;
        z-index: 10;
      }
      .mui-preview-header {
        height: 44px;
        top: 0;
      }
      .mui-preview-footer {
        height: 50px;
        bottom: 0px;
      }
      .mui-preview-header .mui-preview-indicator {
        display: block;
        line-height: 25px;
        color: #fff;
        text-align: center;
        margin: 15px auto 4;
        width: 70px;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 12px;
        font-size: 16px;
      }
      .mui-preview-image {
        display: none;
        -webkit-animation-duration: 0.5s;
        animation-duration: 0.5s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
      }
      .mui-preview-image.mui-preview-in {
        -webkit-animation-name: fadeIn;
        animation-name: fadeIn;
      }
      .mui-preview-image.mui-preview-out {
        background: none;
        -webkit-animation-name: fadeOut;
        animation-name: fadeOut;
      }
      .mui-preview-image.mui-preview-out .mui-preview-header,
      .mui-preview-image.mui-preview-out .mui-preview-footer {
        display: none;
      }
      .mui-zoom-scroller {
        position: absolute;
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        -webkit-backface-visibility: hidden;
      }
      .mui-zoom {
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
      }
      .mui-slider .mui-slider-group .mui-slider-item img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
      }
      .mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
        width: 100%;
      }
      .mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
        display: inline-table;
      }
      .mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
        display: table-cell;
        vertical-align: middle;
      }
      .mui-preview-loading {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        display: none;
      }
      .mui-preview-loading.mui-active {
        display: block;
      }
      .mui-preview-loading .mui-spinner-white {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -25px;
        margin-top: -25px;
        height: 50px;
        width: 50px;
      }
      .mui-preview-image img.mui-transitioning {
        -webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
        transition: transform 0.5s ease, opacity 0.5s ease;
      }
      @-webkit-keyframes fadeIn {
        0% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }
      @keyframes fadeIn {
        0% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }
      @-webkit-keyframes fadeOut {
        0% {
          opacity: 1;
        }
        100% {
          opacity: 0;
        }
      }
      @keyframes fadeOut {
        0% {
          opacity: 1;
        }
        100% {
          opacity: 0;
        }
      }

      .mui-popover.mui-popover-action.mui-popover-bottom {
          position: fixed;
          overflow-x: hidden;
          width:100%;
      }

      .headerTitle{
          color: #727272;
          margin-top: 16px;
          padding-left: 18px;
          font-size: 22px;
          line-height: 32px;
      } 

      .imgShow{
          width: 88%;
          opacity: 1;
          margin: 0 auto;
          padding-top: 18px;
      }

      .standard{
          width: 94%;
          opacity: 1;
          margin: 0 auto;
          padding-top: 0;
          padding-bottom: 6px;
      }

      .imgShow .textDetail{
          margin-bottom: 0;
          line-height: 24px;
          width: 100%;
          word-break: break-all;
      }

      .mui-popover.mui-popover-action .mui-table-view {
          margin: 0px;
          background: #fff;
      }

      .mui-bar{
          padding-left:0;
      }

      .detailHeader{

         position: absolute;
         top:7%;    
         width: 100%;

      }
      .mui-table-view-cell:after {
         background-color: transparent;
      }
      .mui-popover.mui-popover-action .mui-table-view .mui-table-view-cell:after {
         background-color: transparent;
      }

      input[type=text]{
        
        margin-top: 20px;
        border: none;
        border-bottom: #A39E9E  1px solid;
        text-align: center;
        font-weight: bold;
      }

      input[type=number]{
        border: none;
        border-bottom: #A39E9E  1px solid;
        text-align: center;
        font-weight: bold;
      }

      #connect .mui-table-view-cell>a:not(.mui-btn).mui-active{
        background: #368228;
      }


    </style>
</head>
<body class="mui-ios mui-ios-9 mui-ios-9-1">
<header id="header" class="mui-bar mui-bar-nav">

    <h1 class="mui-title myRebate" style="left:78px;width:56%"></h1>
    <button  onclick="tomain()" class="mui-btn mui-btn-blue mui-btn-link mui-btn-nav mui-pull-left" style="color:#fff;font-weight:bolder;padding-left: 10px;"><span class="mui-icon mui-icon-left-nav backtoMain" style="color: #278AF3;"></span></button>
    <p class="mui-progressbar mui-progressbar-infinite"></p>
</header>

<div class="mui-content" style="padding-bottom:28px;min-height: 700px;">
   <div class="detailHeader">
      <p class="headerTitle">□□□□</p>
      <div class="headerInfo">
        <span class ="articleDate">□□□□</span>
        <span class="publisher">□□□□</span>
        <img class="cert" src="img/cert.png" style="display:none;width: 17%;position: absolute;">
      </div>

      <div class="musicAudio">
         <i id="palyiconid" class="fa fa-play" onclick="playbgmusic()"></i>
         <span class="musicSong"></span>
      </div>
   <audio src="" id="bgMusic"  loop="loop" hidden="true"  style="display:none"></audio>
   </div>

   <div id="detailBody">
     <div class="xx addKuang">
      <div class="imgShow mui-content-padded">
       <!-- <img src="img/1.jpg" data-preview-src="" data-preview-group="1" />
       <p class="textDetail">甄选各大热门电商网站同行业优质商品，供用户选购，将线下实体店的货源最大化</p> 
       <img src="img/2.jpg" data-preview-src="" data-preview-group="1" />
       <p class="textDetail">甄选各大热门电商网站同行业优质商品，供用户选购，将线下实体店的货源最大化</p> 
       <img src="img/3.jpg" data-preview-src="" data-preview-group="1" />
       <p class="textDetail">甄选各大热门电商网站同行业优质商品，供用户选购，将线下实体店的货源最大化</p> -->
      </div>
      <div class="supply" style="padding-bottom:1px;display:none">
        <div class="supplyGoods" onclick="connectMe()">我有货</div>
      </div>
     </div>
     
    </div>
   
   <div id="changeSkin" onclick="changeSkin()" style="display:none">
     <i class="fa  fa-star-o" style="font-size: 40px;color: #67A0C8;"></i>
   </div>
   
   <div class="detailFooter">

    <div class="footerMenu">
      <div class="zan" onclick="addZan()">
        <i class="fa fa-thumbs-o-up"></i>
        <span id="zan" style="margin-left:2px;"></span>
      </div>
    </div>
    <div class="footerMenu" style="margin-top: 14px;" onclick="shareBy()">
      <span>分享</span>
    </div>
    <div class="footerMenu" onclick="toComment()">
      <div class="detailcomment">
        <i class="fa fa-comment-o"></i>
      </div>
    </div>
    
   </div>   
</div>

<div id="delete" class="mui-popover mui-popover-action mui-popover-bottom">
      <div class="imgList">

            <div class="imgChoose" onclick="skinStyle(5)"  style="margin-left:3%">
              <img src="img/biaozhun.png" class="imgCss">
              <span class="skinName" style="color: #E5E3E3;">标准</span>
            </div>
         
            <div class="imgChoose" onclick="skinStyle(0)">
              <img src="img/fengjino.png" class="imgCss">
              <span class="skinName" style="color: #fff">风景</span>
            </div>

            <div class="imgChoose"  onclick="skinStyle(1)">
              <img src="img/wood.png" class="imgCss">
              <span class="skinName" style="color: #fff;">木纹</span>
            </div>

            <div class="imgChoose"  onclick="skinStyle(2)">
              <img src="img/paper.png" class="imgCss">
              <span class="skinName" style="left: 27%;">羊皮纸</span>
            </div>

            <div class="imgChoose"  onclick="skinStyle(3)">
              <img src="img/colorful.png" class="imgCss">
              <span class="skinName" style="color: #6C2F2F;">色彩</span>
            </div>

            <div class="imgChoose"  onclick="skinStyle(4)">
              <img src="img/black.png" class="imgCss">
              <span class="skinName" style="color: #C8C6C6;">黑奢</span>
            </div>
        

      </div>

      <ul class="mui-table-view">
        <li class="mui-table-view-cell" style="width:100%">
          <a onclick="confirmSkin()"><b>确定</b></a>
         
        </li>
      </ul>
</div>


<div id="share" class="mui-popover mui-popover-action mui-popover-bottom">
      <div class="shareList">
         <div class="shareType" onclick="shareByType(1)">
          <img src="img/pengyouquan.png" class="shareImg">
          <span class="shareName">朋友圈</span>
         </div>

         <div class="shareType" onclick="shareByType(2)">
          <img src="img/weixinf.png" class="shareImg">
          <span class="shareName" style="left: 35%;">微信好友</span>
         </div>
           

      </div>

      <ul class="mui-table-view">
        <li class="mui-table-view-cell" style="width:100%">
          <a onclick="cancel()">取消</a>
         
        </li>
      </ul>
</div>

<div id="connect" class="mui-popover mui-popover-action mui-popover-bottom">
      <div class="connectList">

        <div class="connectText">
          <input type="text" class="ownerName" placeholder="您的姓名" ><br/>
          <input type="number" class="ownerTel" placeholder="您的联系方式">
        </div>
        <div>
          <div class="tellTa">
            <span class="connectBack" onclick="cancelConnect()">取消</span>
            </div>
          <div class="tellTa">
            <span class="connectBack" style="background: #4B9724;" onclick="tellTa()">告诉TA</span>
          </div>
        </div>
         
        <!-- <div class="tellTa" onclick="tellTa()">告诉TA</div> -->

      </div>

      <!-- <ul class="mui-table-view" style="background:#368228;color:#fff">
        <li class="mui-table-view-cell" style="width:100%">
          <a onclick="cancelConnect()">取消</a>      
        </li>
      </ul> -->
</div>


<script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
<script src="js/mui.min.js"></script>
<script type="text/javascript" src="http://www.coding123.net/getip.ashx?js=1"></script>
<script src="js/mui.zoom.js"></script>
<script src="js/mui.previewimage.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/config.js"></script>
<script type="text/javascript">
  /*mui.init();
  mui('#scroll').scroll({
          indicators: true //是否显示滚动条
      });*/

   mui.previewImage();


   wx.config({
      appId: '<?php echo $signPackage["appId"]; ?>',
      timestamp:<?php echo $signPackage["timestamp"]; ?>,
      nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
      signature: '<?php echo $signPackage["signature"]; ?>',
      jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'onMenuShareQQ',
      'onMenuShareWeibo'
      ]
   });

   var contentId;
   var titleImg;
   var titleContent;
   var shareContent='';
   var isshare;
   var agentId;
   var isType;
   var ismine;
   

   initial();

   function initial(){
    
      if(QueryString("ismine")){
        $("#changeSkin").show();
      }

      contentId = QueryString("id"); 
      isshare = QueryString("isshare");
      isType = QueryString("isType");
      ismine = QueryString("ismine");

      if(isshare == 1){

        $(".mui-pull-left").hide();
        $("#changeSkin").hide();

      }
      contentShow();

   }

   function contentShow(){

     $(".imgShow").html(" ");
        $.ajax({
          type:"post",
          url: ""+Comm_Config+"meiPian/getHomePageById.do",
          /*url: "json/detail.json",*/
          data: {"id":contentId}, 
          success: function(data){

            if(data.resultValue.edit_type == "悬赏"){

                $(".supply").show();

            }

            
            $(".headerTitle").html(data.resultValue.title);
            $(".articleDate").html(data.resultValue.create_time.split(" ")[0]);
            $("#zan").html(data.resultValue.like_count);
            $(".publisher").html(data.resultValue.agent_name);
            $(".cert").show();
            if(data.resultValue.music_name != ""){
              
              $(".musicAudio").show();
              $("#bgMusic").attr("src",data.resultValue.music_url);   
              $(".musicSong").html(data.resultValue.music_name + "-" + data.resultValue.music_artist);

            }else{

                 $(".xx").css("margin-top","32%");
            }

            

            $(".headerTitle").html(data.resultValue.title);

            titleImg = data.resultValue.title_img_url;

            titleContent = data.resultValue.title;

            agentId = data.resultValue.agent_id;
            
            var d = data.resultValue.homepagelist;
            
            for(var i = 0 ; i < d.length ; i++){
              if(d[i].img_url == ""){

                $(".imgShow").append("<p class=\"textDetail\">" + d[i].content + "</p>");

              }else{

                $(".imgShow").append("<img src=\"" + d[i].img_url +"\" data-preview-src=\"\" data-preview-group=\"1\" /><p class=\"textDetail\">" + d[i].content + "</p>");
              } 

              if(d[i].content != undefined || d[i].content !=null || d[i].content != ''){

                shareContent += d[i].content;

              }              
              
            }
            skinStyle(data.resultValue.skin_type == null ? 5 : data.resultValue.skin_type);
            $(".mui-progressbar-infinite").hide();
          }
      });

       
   }

   function addZan(){
      
      ipAddress = ip.substr(1);

      $.ajax({
          type:"post",
          url: ""+Comm_Config+"meiPian/updateMeiPianLikeCount.do",
          /*url: "json/detail.json",*/
          data: {"homepageid":contentId,"ipAddress":ipAddress},

          success: function(data){
            if(data.resultValue == 1 ){
             
              mui.alert(data.msg);

            }else{

              $.ajax({
                  type:"post",
                  url: ""+Comm_Config+"meiPian/getHomePageById.do",
                  /*url: "json/detail.json",*/
                  data: {"id":contentId}, 
                  success: function(data){

                    $("#zan").html(data.resultValue.like_count);
                   
                  }
              });

            }

            

          }
      });
   }

   
   

   function tomain(){

    var newAgent = QueryString("agentId");

    if(isType == 1 || isType == 2 || isType == 3 || isType == 4){

      

      if(newAgent == null){

        window.location.href="activityList.html?type=" + isType;

      }else{

        window.location.href="activityList.html?type=" + isType + "&agentId=" + newAgent +"&ismine=1";

      }

      

    }else{

      if(newAgent == null){

        window.location.href="index.php";
        
      }else{

        window.location.href="mine.php?agentId=" + newAgent ;

      }

      

    }
      
   }

   function toComment(){

    if(isshare == 1){

      window.location.href="comment.html?id="+contentId + "&agentId=" + agentId+ "&isType=" + isType + "?isshare=1";

    }else{

      if(ismine != null){

        window.location.href="comment.html?id="+contentId + "&agentId=" + agentId +"&isType=" + isType +"&ismine=1";

      }else{

        window.location.href="comment.html?id="+contentId + "&agentId=" + agentId +"&isType=" + isType;

      }

      

    }

      

   }

   
   function GetRandomNum(){
      var Min = 0;
      var Max = 1000;
      var Range = Max - Min;
      var Rand = Math.random();
      return(Min + Math.round(Rand * Range));
   }

   function shareBy(){

     $("#share").addClass("mui-active");

   }

   function cancel(){
     
     $("#share").removeClass("mui-active");

   }

   

   function playbgmusic(){
      var myAuto = document.getElementById('bgMusic'); 

      if($("#palyiconid").hasClass('fa fa-pause')){

         $("#palyiconid").attr("class", "fa fa-play");
           myAuto.pause();

      }else{

         $("#palyiconid").attr("class", "fa fa-pause");
           myAuto.play();
      }

   }




   function changeSkin(){
     
     $("#delete").addClass("mui-active");   

   }

   function confirmSkin(){
    /* $(".mui-content").removeClass("scenerySkin woodSkin paperSkin colorSkin blackSkin");*/
    $("#delete").removeClass("mui-active");

    /*提交修改皮肤的处理*/
    var skinType = $(".mui-content").attr("skinType");

    $.ajax({
          type:"post",
          url: ""+Comm_Config+"meiPian/updateHomePageListSkinType.do",
          data: {"id":contentId,"skinType":skinType}, 
          success: function(data){

            mui.alert("修改成功");
          }
    });





    

   }


   function skinStyle(style){

    $("body").removeClass("scenerySkin woodSkin paperSkin colorSkin blackSkin");

    switch (parseInt(style))
      {
        case 0: //风景皮肤
          $(".xx").addClass('addKuang');
          $(".imgShow").removeClass('standard');
          $(".addKuang").css("background","#fff");
          $('body').addClass('scenerySkin');
          /*$(".mui-content").addClass("scenerySkin");*/
          $(".mui-content").attr("skinType","0");
          $(".headerTitle").css("color","#1681BE");
          $(".articleDate").css("color","#A5A5A5");
          $(".publisher").css("color","#31A1C");
          $(".musicSong").css("color","#035889");
          $("#palyiconid").css("color","#035889");
          $(".imgShow p").css("color","#2A303C");
          break;
        case 1://木纹皮肤
          $(".xx").addClass('addKuang');
          $(".imgShow ").removeClass('standard');
          $(".addKuang").css("background","#fff");
          $('body').addClass('woodSkin');
          /*$(".mui-content").addClass("woodSkin");*/
          $(".mui-content").attr("skinType","1");
          $(".headerTitle").css("color","#603706");
          $(".articleDate").css("color","#552D04");
          $(".publisher").css("color","#144F93");
          $(".musicSong").css("color","#512F04");
          $("#palyiconid").css("color","#532003");
          $(".imgShow p").css("color","#3A2913");  
          break;
        case 2://羊皮纸皮肤
          $(".xx").addClass('addKuang');
          $(".imgShow ").removeClass('standard');
          $(".addKuang").css("background","#fff");
          $('body').addClass('paperSkin');
          /*$(".mui-content").addClass("paperSkin");*/
          $(".mui-content").attr("skinType","2");
          $(".headerTitle").css("color","#4F2304");
          $(".articleDate").css("color","#512C07");
          $(".publisher").css("color","#357ED1");
          $(".musicSong").css("color","#572C07");
          $("#palyiconid").css("color","#5C2B08");
          $(".imgShow p").css("color","#49220B");   
          break;
        case 3://色彩皮肤
          $(".xx").addClass('addKuang');
          $(".addKuang").css("background","#C47373");
          $(".imgShow ").removeClass('standard');
          $('body').addClass('colorSkin');
          /*$(".mui-content").addClass("colorSkin");*/
          $(".mui-content").attr("skinType","3");
          $(".headerTitle").css("color","#80203D");
          $(".articleDate").css("color","#EC4C7F");
          $(".publisher").css("color","#8F2F5B");
          $(".musicSong").css("color","#C24A81");
          $("#palyiconid").css("color","#C24A81");
          $(".imgShow p").css("color","#EBE5E8");  
          break;
        case 4://黑奢皮肤
          $(".xx").addClass('addKuang');
          $(".imgShow ").removeClass('standard');
          $(".addKuang").css("background","#fff");
          $('body').addClass('blackSkin');
          /*$(".mui-content").addClass("blackSkin");*/
          $(".mui-content").attr("skinType","4");
          $(".headerTitle").css("color","#A5A9AB");
          $(".articleDate").css("color","#A1A1A1");
          $(".publisher").css("color","#357ED1");
          $(".musicSong").css("color","#D9D9D9");
          $("#palyiconid").css("color","#AAA9A9");
          $(".imgShow p").css("color","#333336");   
          break;
        case 5://标准皮肤
          $(".xx").removeClass('addKuang');
          $(".imgShow").addClass('standard');
          $(".mui-content").attr("skinType","5");
          $(".headerTitle").css("color","#3A3A3A");
          $(".articleDate").css("color","#A1A1A1");
          $(".publisher").css("color","#65809F");
          $(".musicSong").css("color","#8A8A8A");
          $("#palyiconid").css("color","#D5D5D5");
          $(".imgShow p").css("color","#8f8f94"); 
          break;
      }
   }


  function QueryString(val){
      var uri = window.location.search;
      var re = new RegExp("" +val+ "=([^&?]*)", "ig");
      return ((uri.match(re))?(uri.match(re)[0].substr(val.length+1)):null);
  }


  wx.ready(function() {
      readyshare();
   });

  function readyshare() {

    var ShareGoodsPublicLink = "http://10000dp.com/wxadmin/yunshare/detail.php";

    var shareLink = ShareGoodsPublicLink + "?id=" + contentId + "&agentId="+ agentId +"?isshare=1";
     if(shareContent == ''|| shareContent == undefined || shareContent == null){

        var SHARE_CONTENT = "店铺云享更精彩！";

     }else{

        var SHARE_CONTENT = shareContent;

     }
    

    wx.onMenuShareTimeline({
      //分享到朋友圈
      title: titleContent,
      link: shareLink,
      imgUrl: titleImg,
      success: function(res) {

      }
    });

    wx.onMenuShareAppMessage({
      //分享给微信好友
      title: titleContent,
      desc: SHARE_CONTENT,
      link: shareLink,
      imgUrl: titleImg,
      success: function(res) {

      }
    });
    wx.onMenuShareQQ({
      title: titleContent,
      desc: SHARE_CONTENT,
      link: shareLink,
      imgUrl: titleImg,
      success: function(res) {
      }
    });
    wx.onMenuShareWeibo({
      title: titleContent,
      desc: SHARE_CONTENT,
      link: shareLink,
      imgUrl: titleImg,
      success: function(res) {
      }
    });
  }

/*  function goodssharemark()
  {
      $.ajax({
          type:"get",
          url: "" + Comm_Config + "wx/addShareGoods.do",
          data: {"agentid": MaintainableJS.aid, "baseid": MaintainableJS.baseid, "alias": MaintainableJS.alias},
          success: function(data) {
              //分享日志统计，成功与否，不做反馈
          }
      });
  }*/


  function shareByType(style){
/*
    var ShareGoodsPublicLink = "http://10000dp.com/wxadmin/yunshare/detail.php";

    var shareLink = ShareGoodsPublicLink + "?id=" + contentId + "&agentId=" + agentId + "?isshare=1";

    var SHARE_CONTENT = "店铺云享更精彩！"*/

    

    switch (style)
          {
            case 1: //分享到朋友圈
               alert("点击右上角菜单分享")
   
              break;
            case 2://分享到微信好友
                alert("点击右上角菜单分享")
                 
              break;
         
          }

   }


  function connectMe(){

       $("#connect").addClass("mui-active");

   }

  function cancelConnect(){

     $("#connect").removeClass("mui-active");

  }

  function tellTa(){
    var ownerName = $(".ownerName").val();
    var ownerTel = $(".ownerTel").val();
    if(ownerName == '' || ownerTel == ''){  

      mui.alert("请将信息填写完整");

    }else{

      $.ajax({
          type:"post",
          url: "" + Comm_Config + "meiPian/sendWxOrderMsg.do",
         /* url:"http://172.18.15.119:8080/ydserver/meiPian/sendWxOrderMsg.do",*/
          data: {"name": ownerName, "phone": ownerTel,"homepageid":contentId,"agent_id":agentId,"good_name":titleContent},
          success: function(data) {

            $("#connect").removeClass("mui-active");

            mui.alert("已经将你的信息发送给悬赏人,静候佳音啦~");
              
          }
      });


    }

  }


  function GetRandomNum() {
    var Min = 0;
    var Max = 10000;
    var Range = Max - Min;
    var Rand = Math.random();
    return(Min + Math.round(Rand * Range));
  }


</script>
</body>
</html>
