<?php
error_reporting(0);
require_once "./../publicWxAction/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$wxAppid = "wx6f30595592155ec9";//wx29656e8801565344
$wxSrcret = "19d00ffec9a7ce9cb08ce224f52b974c";//7497e4557f2ce8b2c0ba0a0b5edee267

$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$wxAppid&secret=$wxSrcret";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$jsoninfo = json_decode($output, true);
$access_token = $jsoninfo["access_token"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>图片测试</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <style>
    body{
      font-family: "微软雅黑";
    }
    

       
    </style>
</head>
<body>

  <div class="modal-body" id="showvideocontent" style="padding:0px">
    <img src="img/videoPlayer.png" width="100%" onclick="toVideo()">
    <!-- <embed src="http://yuntv.letv.com/bcloud.swf" allowfullscreen="true" quality="high" width="100%" height="180" align="middle" allowscriptaccess="always" flashvars="uu=a347b98664&vu=04ef464238&auto_play=1&gpcflag=1&width=320&height=180" type="application/x-shockwave-flash"></embed> -->
<!-- <video width="100%" height="180" src="http://yuntv.letv.com/bcloud.html?uu=a347b98664&vu=04ef464238" autoplay="autoplay" controls="controls"></video> -->
  </div>

<div style="width:100%" class="imgshow">
<!-- <img src="img/muwu.jpg" width="100%"> -->
<div>

<input  type="button" value="上传图片" onclick="add()"/><br/>
<span>本地localid:</span><br/>
<textarea class="local"  style="height: 69px;width: 80%;"></textarea><br/>
<span>mediaId(serverId):</span><br/>
<textarea class="media"  style="height: 69px;width: 80%;"></textarea><br/>
<span>微信下载url:</span><br/>
<textarea class="test"  style="height: 69px;width: 80%;"></textarea><br/>



<!--音乐搜索页面 end-->

<script src="http://cdn.bootcss.com/Sortable/1.4.2/Sortable.min.js"></script>
<script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">

  wx.config({
      appId: '<?php echo $signPackage["appId"]; ?>',
      timestamp: '<?php echo $signPackage["timestamp"]; ?>',
      nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
      signature: '<?php echo $signPackage["signature"]; ?>',
      jsApiList: [
          // 所有要调用的 API 都要加到这个列表中
          'getLocation',
          'chooseImage',
          'uploadImage',
          'downloadImage',
          'hideAllNonBaseMenuItem'
      ]
  });





  var localIds = [];


  function add(){

          wx.chooseImage({
                  count: 1, 
                  success: function (res) {
                    

                      localIds = res.localIds;

                      syncUpload();

                    
                              
                  }
          });
   }


   var syncUpload = function() {
                 
                     var localId = localIds.pop();
            
                      $(".local").val(localId) 

                      wx.uploadImage({
                        localId:localId,
                        success: function(res) {
                          downImg(res.serverId);
                        }
                      });
                   
                  
                  
                 };

    var downImg = function(serverId){

   $(".media").val(serverId)
             wx.downloadImage({
                serverId: serverId, 
                isShowProgressTips: 1, 
                success: function (res) {
                    var localId = res.localId; 
                    imgshow(localId)
                }
            });
              
          };

    function imgshow(data){
         $(".test").val(data);

         $(".imgshow").append("<img src=\""+data+"\" width=\"100%\">");
   
                     
    }

    function toVideo(){

      window.location.href="http://yuntv.letv.com/bcloud.html?uu=a347b98664&vu=04ef464238"
    }

  

</script>
</body>
</html>
