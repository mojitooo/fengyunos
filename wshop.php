<?php
error_reporting(0);
require_once "./publicWxAction/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>我的云店铺</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <meta http-equiv="x-dns-prefetch-control" content="on">
        <link rel="dns-prefetch" href="http://cdn.bootcss.com">
        <link rel="dns-prefetch" href="http://static.51dh.com.cn">
        <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="//cdn.bootcss.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://cdn.bootcss.com/Swiper/3.0.8/css/swiper.min.css" rel="stylesheet">
        <link href="css/style.css?03241120" rel="stylesheet">
        <link  rel="stylesheet" href="./css/wshop.css?12311220">   
    </head>
    <body onload="getAreamsg()">
        <!--顶部搜索栏-->

        <!--Banner轮播-->
        <div class="bannerzoon" style="min-height: 130px;">
            <div class="swiper-container" >
                <div class="swiper-wrapper" id="shopbannerdiv" >
                </div>
                <script id="shopbanner-template" type="text/x-handlebars-template">
                    <div class="swiper-slide" >
                        <div class="swiper-lazy-preloader"></div>
                        <img data-src="{{url}}" class="swiper-lazy">          
                    </div>
                    
                </script>
                <div class="swiper-pagination">
                    
                </div>
                
            </div>
            <div class="marquee"id="bannertextid">
                <marquee scrollamount="5" id="bannertextcontain"></marquee>
            </div>
            <div class="musicplayer" >
                <i class="fa fa-music" onclick="playbgmusic()" id="palyiconid"></i>
            </div>
        </div>
        
        <!--背景音乐播放-->
        <audio id="bgmusicaudio" hidden="true" loop="false"  ></audio>
        
         <div class="header" id="pagetophead" >
            <div class="header-bg"></div>
             <div class="input-group" style="float:left;width:98%;">
                 <div class="input-group-btn" >
                  
                </div>
                 <input type="text" class="form-control" style="border-radius: 5px;height: 33px;outline: none;" id="homeinputsearch" placeholder="输入关键字搜索商品" onfocus="searchGoodsByName()">
            </div>
<!--            <span class="header-point" onclick="gotoshophome()">
                <i class="fa fa-home"></i>
            </span>-->
        </div>
        <!--功能模块-->
        <div class="public-dommodel" id="cateblockdiv" style="min-height: 100px;">
            
        </div>
        <script id="cateblock-template" type="text/x-handlebars-template">
            <div class="fun-modelblock" onclick="toAreaZoon({{seq}})">
            
                <img class="lazzyload" data-original={{litpic}} src="source/areaload.png">
                {{name}}
            </div>
        </script>
        
        <!--用户信息开始-->
        <div class="public-dommodel-slider" style="padding: 2% 0;" onclick="gotoBossDetail()">
            <div class="user-ico-zoon">
                <img id="imgshopico" src="./source/yunlogo.png">
            </div>
            <div class="user-msg-zoon">
                <span class="user-msg-name" id="spanshopname">
                    加载中...
                </span>
                <span class="user-msg-name" id="spanbossname">
                   加载中...
                </span>
            </div>
            <div class="user-more-zoon">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
        <div class="public-dommodel-slider" id='orderinfo' style="padding: 2% 0;display:none" onclick="gotorder()">
            <div class="catblock-left">
                <i class=" icon-print"></i>
            </div>
            <div class='order-info'>
                <span >
                    订单管理
                </span>
            </div>
            <div class="user-more-zoon" style='padding-top:2%'>
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
        <!--推荐商家开始-->
        <div class="public-dommodel-slider" id="bosshotId" style="background: #e9e8e2;">
            <div class="model-header" style="background: #fff;">
                <i class="fa fa-chain-broken"></i>&nbsp;&nbsp;<span id="top1id">店主推荐</span>
                <div style="float:right">
                    <span onclick="selectgoodsbyincrease(1)"><i class="fa fa-sort-amount-asc"></i>&nbsp;高价排序</span>
                    <span onclick="selectgoodsbyincrease(2)"><i class="fa fa-sort-amount-desc"></i>&nbsp;低价排序</span>
                </div>
                
            </div>

            <div id="booshotgoodsListId" >

            </div>
        </div>

       
         <div class="public-cover" id="public_coverid">
            <i class="icon-refresh icon-spin"></i>
        </div>
        <script src="http://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
        <script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="http://cdn.bootcss.com/handlebars.js/4.0.4/handlebars.min.js"></script>
        <script src="http://cdn.bootcss.com/Buttons/2.0.0/js/buttons.min.js"></script>
        <script src="http://cdn.bootcss.com/Swiper/3.0.8/js/swiper.min.js"></script>
        <script src="http://cdn.bootcss.com/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
        <script src="./commonJs/config.js?010716063"></script>
        <script src="./js/wshopjs.js?20165599"></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script>
            getShopInit();
            wx.config({
                appId: '<?php echo $signPackage["appId"]; ?>',
                timestamp: <?php echo $signPackage["timestamp"]; ?>,
                nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
                signature: '<?php echo $signPackage["signature"]; ?>',
                jsApiList: [
                    // 所有要调用的 API 都要加到这个列表中
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareWeibo',
                    'getNetworkType'
                ]
            });
            wx.ready(function() {
                // 在这里调用 API
                readyshare();
            });

            function readyshare()
            {

                var randommun = GetRandomNum();
                var sharelink = ShreShopCommonLink + "?alias=" + GLOB_alias + "&aid=" + GLOB_AID + "?isshare=1?" + randommun;
                if (GLOB_SHOPID) {
                    sharelink = ShreShopCommonLink + "?alias=" + GLOB_alias + "&aid=" + GLOB_AID + "&shopid=" + GLOB_SHOPID + "?isshare=1?" + randommun;
                }
                wx.onMenuShareTimeline({
                    title: SHARE_TITTLE,
                    link: sharelink,
                    imgUrl: "" + ShareShopPublicLink + "/App/Modules/weixin/weixinportal/images/shareshopico.png",
                    success: function(res) {
                        var param = "代理商朋友圈分享";
                        _hmt.push(['_trackEvent', '云店铺', '云店铺分享', param]);
                        shopsharelog();
                    }
                });




                wx.onMenuShareAppMessage({
                    title: SHARE_TITTLE,
                    desc: SHARE_TEXT,
                    link: sharelink,
                    imgUrl: "" + ShareShopPublicLink + "/App/Modules/weixin/weixinportal/images/shareshopico.png",
                    success: function(res) {
                        var param = "代理商指定好友分享";
                        _hmt.push(['_trackEvent', '云店铺', '云店铺分享', param]);
                        shopsharelog();
                    }
                });



                wx.onMenuShareQQ({
                    title: SHARE_TITTLE,
                    desc: SHARE_TEXT,
                    link: sharelink,
                    imgUrl: "" + ShareShopPublicLink + "/App/Modules/weixin/weixinportal/images/shareshopico.png",
                    success: function(res) {
                        var param = "代理商分享到QQ";
                        _hmt.push(['_trackEvent', '云店铺', '云店铺分享', param]);
                        shopsharelog();
                    }
                });



                wx.onMenuShareWeibo({
                    title: SHARE_TITTLE,
                    desc: SHARE_TEXT,
                    link: sharelink,
                    imgUrl: "" + ShareShopPublicLink + "/App/Modules/weixin/weixinportal/images/shareshopico.png",
                    success: function(res) {
                        var param = "代理商分享到微博";
                        _hmt.push(['_trackEvent', '云店铺', '云店铺分享', param]);
                        shopsharelog();
                    }
                });
                
                 wx.getNetworkType({
                    success: function (res) {
                      if(res.networkType.indexOf("wifi")>-1){
                          playbgmusic();
                      }
                    },
                    fail: function (res) {
                      alert(JSON.stringify(res));
                    }
              });
            }
        </script>

        
    </body>

</html>
