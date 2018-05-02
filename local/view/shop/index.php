<?php
error_reporting(0);
require_once "../publicWxAction/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>
<link href="http://cdn.bootcss.com/Swiper/3.0.8/css/swiper.min.css" rel="stylesheet">
<link href="css/old/style.css?03241120" rel="stylesheet">
<link  rel="stylesheet" href="./css/old/wshop.css?12311220">

 <div ng-controller="ShopCtrl as shop">
        <!--顶部搜索栏-->

        <!--Banner轮播-->
        <div class="bannerzoon" style="min-height: 130px;">
           <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" ng-repeat="list in shop.picList" load-swiper>   
                        <img ng-src="{{list.url}}@600w_337h_1e_1c" >          
                    </div>
                </div>
                <div class="swiper-pagination">   
                </div> 
            </div>
            <div class="marquee">
                <marquee scrollamount="5" id="bannertextcontain">
                  
                </marquee>
            </div>
            <div class="musicplayer" >
                <i class="fa fa-music" ng-click="shop.playbgmusic()" id="palyiconid"></i>
            </div>
        </div>
        
        <!--背景音乐播放-->
        <audio id="bgmusicaudio" hidden="true" loop="false"  ></audio>
        
         <div class="header" id="pagetophead" >
            <div class="header-bg"></div>
             <div class="input-group" style="float:left;width:98%;">
                 <div class="input-group-btn" >
                  
                </div>
                 <input type="text" class="form-control" style="border-radius: 5px;height: 33px;outline: none;" id="homeinputsearch" placeholder="输入关键字搜索商品" ng-focus="shop.searchGoodsByName()">
            </div>
<!--            <span class="header-point" onclick="gotoshophome()">
                <i class="fa fa-home"></i>
            </span>-->
        </div>
        <!--功能模块-->
        <div class="public-dommodel"  style="min-height: 100px;">

            <div class="fun-modelblock" ng-repeat="list in shop.areaList" ng-click="shop.toAreaZoon(list.seq)" ng-show="$index < shop.listShow">
            
                <img ng-src="{{list.litpic}}@60w_80h_1e_1c">
                {{list.name}}

            </div>

            <div ng-if="shop.listShow >= 7" class="fun-modelblock" style="margin-top:8%;" ng-click="shop.listShow == 7?shop.listShow=shop.areaList.length:shop.listShow=7">
                <img ng-src="{{shop.listShow == 7?'source/areamore.png':'source/areaup.png'}}" style="margin-bottom:15%;">{{shop.listShow == 7?'更多':'收起'}}
            </div>

            
        </div>
       
        
        <!--用户信息开始-->
        <div class="public-dommodel-slider" style="padding: 2% 0;" ng-click="shop.gotoBossDetail()">
            <div class="user-ico-zoon">
                <img  src="{{shop.agent.icon?shop.agent.icon:'./source/yunlogo.png'}}">
            </div>
            <div class="user-msg-zoon">
                <span class="user-msg-name">
                   {{shop.agent.shop_name}}({{shop.agent.city+shop.agent.county}})
                </span>
                <span class="user-msg-name">
                   {{shop.agent.name}}({{shop.agent.tel}})
                </span>
            </div>
            <div class="user-more-zoon">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>

        
        <div ng-if="(shop.sellType == 1||shop.sellType == 2)&&(shop.isShare == 1)" class="public-dommodel-slider" id='orderinfo' style="padding: 2% 0;" ng-click="shop.gotorder()">
            <div class="catblock-left" style="padding:0 0 0 30px;text-align:inherit;">
                <i class="fa fa-print"></i>
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
    
        <!-- 推荐商家开始 -->
        <div class="public-dommodel-slider" id="bosshotId" style="background: #e9e8e2;">
            <div class="model-header" style="background: #fff;">
                <i class="fa fa-chain-broken" ></i>&nbsp;&nbsp;<span id="top1id" style="display: inline;" >店主推荐：{{shop.areaname}}</span>
                <div style="float:right">
                    <span style="float:left;" ng-click="shop.typeChange(1)"><i class="fa fa-sort-amount-asc"></i>&nbsp;高价排序</span>
                    <span style="float:left;" ng-click="shop.typeChange(2)"><i class="fa fa-sort-amount-desc"></i>&nbsp;低价排序</span>
                </div>
                
            </div>

            <div ng-if='shop.list.length==0' style="text-align:center">
               <span>我们店铺没有推荐商品，看看别的吧</span> 
            </div>
            <div ng-if='shop.list.length>0' ng-repeat="list in shop.list">
                <div class="{{($index%2==0)?'boss-hotgoods-block-left':'boss-hotgoods-block-right'}}" ng-click="shop.toDetail(list.base_id)">
                <div class="boss-hotgoods-block-imgblock">
                <img ng-if="list.market_type > 0 && list.market_type < 5" ng-src="http://10000dp.com/wxadmin/local/source/label_{{list.market_type}}.png" class="img_mark" style="width:50px;margin-right:5px">
                <img class="boss-hotgoods-block-img"  ng-src="{{list.litpic}}"></div>
                <div class="boss-hotgoods-block-textblock">
                <p>{{list.goods_name}}<font style="color:red">({{list.attr}})</font></p>
                <span >￥{{list.goods_price}}</span>
                <span  ng-if="((shop.sellType == 1||shop.sellType == 2)&&(shop.isShare == 1))||((shop.isBoss == 1)&& (shop.isShare != 1))" style="color:#000;">{{shop.isrebate == 1?'返利￥':'进货价￥'}}:{{shop.isrebate == 1?list.rebate_money:list.wholesale_price}}</span>        
                </div></div>
        
            </div>
        </div>
        
               
         <!-- <div class="public-cover" id="public_coverid">
            <i class="icon-refresh icon-spin"></i>
                 </div> -->
         

        <script src="http://cdn.bootcss.com/Swiper/3.0.8/js/swiper.min.js"></script>
        <script src="http://cdn.bootcss.com/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

        
    </div>

    <script>
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
    </script>