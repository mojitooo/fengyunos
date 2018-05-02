
	<?php
	error_reporting(0);
	require_once "../publicWxAction/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
	?>
	<link href="http://cdn.bootcss.com/Swiper/3.0.8/css/swiper.min.css" rel="stylesheet">
	<link href="css/old/goodsblock.css?14291608" rel="stylesheet">

	<!-- <body onload="loadcomply()" style="-webkit-transition:-webkit-transform 1s ease-in-out;-webkit-text-size-adjust: 100%!important"> -->
	<div   ng-controller="DetailCtrl as detail"  style="-webkit-transition:-webkit-transform 1s ease-in-out;-webkit-text-size-adjust: 100%!important">

		<!-- 顶部商品相册轮播开始-->
		<!-- <div class="goods-photo-contain"> -->
			<div class="swiper-container">
				<div class="swiper-wrapper"  >
					
					<div class="swiper-slide"  ng-repeat="list in detail.picList track by $index"  load-swiper>
						<img ng-src="{{list}}">
						<!-- <div class="swiper-lazy-preloader"></div> -->
					</div>

				</div>
				<div class="swiper-pagination"></div>
			</div>

			<div class="goodslabel-contain" ng-if="list.market_type > 0  && list.market_type < 5" ng-repeat="list in detail.goodsList">
				<img ng-src="http://10000dp.com/wxadmin/local/source/label_{{list.market_type}}.png">
			</div>
		<!-- </div> -->

		<!-- 商品相册结束，商品信息开始-->
		<div class="goods-msg-contain">
			<span class="goods-msg-name" id="goodsinfo_name">{{detail.goodsList[detail.indexChange].goods_name}}</span>
			<span class="goods-msg-desc" id="goodsinfo_describe" style="display: inline">{{detail.goodsList[detail.indexChange].goods_describe}}</span>

			<span  class="goods-msg-price" style="display: inline">优惠价:￥<span style="font-size: 20px;font-weight: bold;display:inline">{{detail.goodsList[detail.indexChange].goods_price.toFixed(2)}}</span>

			<div ng-if="((detail.sellType == 1||detail.sellType == 2)&&(detail.isShare == 1))||((detail.isBoss == 1)&& (detail.isShare != 1)&&((detail.boxId != null)||(vm.aid=== vm.aidUrl))&&(detail.isRebate!=1))" style="display: inline;">
				<span class="price-whosale-price" style="display: inline">进价：￥<span id="goodsinfo_whoprice" style="display: inline">{{detail.goodsList[detail.indexChange].wholesale_price}}</span> </span>
			</div>
			<div ng-if="((detail.isRebate==1)&&((detail.isBoss == 1)&& (detail.isShare != 1)))" style="display: inline;">
				<span class="price-whosale-price" style="display: inline">返利：￥<span id="rakeback_money"style="display: inline">{{detail.goodsList[detail.indexChange].rebate_money}}</span> </span>
			</div> 
		    </span>
			<button ng-if="((detail.sellType == 2)&&(detail.isShare == 1))||((detail.isBoss == 1)&& (detail.isShare != 1))" type="button" class="btn btn-default btn-xs" style="float:right;margin-top: 2%" data-toggle="modal" data-target="#editPriceModal" ng-click="detail.openModal()">
			修改价格
			</button>

			<span class="price-price" id="goodslabel_tejia">原价：￥<span id="goodsinfo_oldprice"> - - - </span></span>
			
		</div>
		<div class="goods-msg-contain" >
			<div id="choose-baitiao" class="li choose-baitiao" style="">
				<div class="baitiao-list J-baitiao-list">
						<div ng-if="detail.installList!=''" class="item" ng-repeat="list in detail.installList">
							<b></b>
							<a href="#none">{{list.name}}</a>
							<div class="baitiao-tips hide">
								<ul><li>无手续费</li></ul>
							</div>
						</div>
				</div>
				<div class="baitiao-list J-baitiao-list">
						<div ng-if="detail.installtwiceList!=''" class="item" ng-repeat="list in detail.installtwiceList">
							<b></b>
							<a href="#none">{{list.name}}</a>
							<div class="baitiao-tips hide">
								<ul><li>无手续费</li></ul>
							</div>
						</div>
				</div>	
			</div>
		</div>

		<!-- 商品信息结束，商品属性开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				版本
			</div>
			<div class="attr-value-div">
				<div ng-if="list.is_show == 1" class="value-block-{{detail.indexChange == $index?'achive':'normal'}}" ng-repeat="list in detail.goodsList" ng-click="detail.indexChange = $index;detail.setInstall(list.goods_alias_id)">
					<!-- <a style="display:none">{{detail.indexChange = $index}}</a> -->
					<p aliasid="{{list.goods_alias_id}}" supplyid="{{list.supply_id}}" gprice="{{list.goods_price}}"  wprice="{{list.wholesale_price}}" class="value-block-achive-p">{{list.attr}}</p>
				    <i ng-if="detail.indexChange == $index" class="fa fa-check"></i>
				</div>
                
			</div>
		</div>

		<!--商品属性结束，配送服务开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				已选
			</div>
			<div class="attr-value-div">
				<p style="display:none">{{detail.supplyid = detail.goodsList[detail.indexChange].supply_id}}</p>
				<p style="display:none">{{detail.goodprice = detail.goodsList[detail.indexChange].goods_price}}</p>
				<p class="value-block-p">
					{{detail.goodsList[detail.indexChange].attr}}
				</p>
				x1
			</div>
		</div>
		<!--配送服务结束，店铺开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				店主
			</div>
			<div class="attr-value-div">
				<p class="value-block-p">
					{{detail.agent.name+" "+detail.agent.tel}}
					
				</p>
				<i class="fa fa-creative-commons" style="color:#44264e"></i>
			</div>
			<a id="publictelhiden" style="display:none"></a>
		</div>
		<!--商品属性结束，配送服务开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				服务
			</div>
			<div class="attr-value-div">
				<p class="value-block-p">
					由<span style="display:inline-block;">{{detail.agent.shop_name}}</span>发货并提供技术服务
				</p>
				<p class="value-block-p">
					<i class="fa fa-clock-o" style="color:#44264e"></i>&nbsp;次日达&nbsp;&nbsp; <i class="fa fa-credit-card" style="color:#44264e"></i>&nbsp;货到付款&nbsp;&nbsp; <i class="fa fa-archive" style="color:#44264e"></i>&nbsp;支持自提
				</p>
			</div>
		</div>
		<!--支付-->
	<!-- 	<div class="goods-attr-contain">
		<div class="attr-name">
			支付
		</div>
		<div class="attr-value-div paylink" onclick="javascrtpt:window.location.href='http://x.eqxiu.com/s/YlrhQhtj?eqrcode=1'">
			<p class="value-block-p" id="goodsinfo_attrconfirm">
				点击查看如何线上支付
			</p>
		</div>
	</div> -->
		<!-- 属性服务结束，店铺信息开始-->
		<div class="shop-info-contain">
			<div class="shop-info-achive">
				<div class="shop-info-ico">
					<img id="agentinfo_iconid" src="source/yunlogo.png">
				</div>
				<div class="shop-info-msg" onclick="toBossShop()">
					<p class="value-block-p">
						<strong id="shopinfo_shopnameid">{{detail.agent.shop_name}}</strong>
					</p>
					<p class="value-block-p"style="color:#f15353">
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
					</p>
				</div>
				<div class="shop-info-more">
					<i class="fa fa-angle-right" style="color:#44264e"></i>
				</div>

				<div class="public-contain" style="margin-top: 4%;">
					<div class="shop-horner-contain">
						<div class="shop-horner-block">
							商品 <span class="shop-info-score">5.0</span><span class="shop-info-level">优</span>
						</div>
						<div class="shop-horner-block">
							服务 <span class="shop-info-score">5.0</span><span class="shop-info-level">优</span>
						</div>
						<div class="shop-horner-block">
							时效 <span class="shop-info-score">5.0</span><span class="shop-info-level">优</span>
						</div>
					</div>
					<div class="shop-horner-contain">
						<div class="shop-value-block">
							<span class="shop-value-num">{{detail.report.visitShopCount}}</span>
							<span class="shop-value-name">浏览次数</span>
						</div>
						<div class="shop-value-block">
							<span class="shop-value-num">{{detail.report.orderIntentCount}}</span>
							<span class="shop-value-name">交易量</span>
						</div>
						<div class="shop-value-block">
							<span class="shop-value-num">{{detail.report.agentCustomerCount}}</span>
							<span class="shop-value-name">关注人数</span>
						</div>

					</div>
					<div class="shop-horner-contain">
						<a type="button" class="btn btn-default"  id="bossTelspan2" href="tel:{{detail.agent.tel}}">
							<i class="fa fa-comments-o"></i>&nbsp;联系店主
						</a>
						<a type="button" class="btn btn-default" ng-click="detail.toBossShop()">
							<i class="fa fa-bank"></i>&nbsp;进入店铺
						</a>
					</div>
				</div>
			</div>
		</div>

		<!--开始图文详细-->
		<div class="goods-tuwen-contain" style="text-align: center;" id="goodscontainId">
			<p class="value-block-p" style="width: 100%;">
				<i class="fa fa-chevron-up"></i>&nbsp;上拉查看图文详情
			</p>
			<div ng-bind-html="detail.goodsList[0].content"></div>
			
		</div>
		<div style="float: left;width: 100%;height: 68px;"></div>
		<!-- 商品详情结束，底部菜单开始-->
		<div class="footer-div">
			<div class="footer-block-1" style="text-align: center;">
				<a id="bottomcallboss" href="tel:{{detail.agent.tel}}">
					<i class="fa fa-comment-o" style="font-size: 120%;"></i>
					<span>店主</span>
				</a>
			</div>
			<div class="footer-block-1" ng-click="detail.toBossShop()">
				<i class="fa fa-home"></i>
				<span>进店</span>
			</div>
			<div class="footer-block-1" ng-click="detail.showStoreBanner()">
				<i class="fa fa-heart-o"></i>
				<span>收藏</span>
			</div>
			<!-- <button ng-if="!((detail.sellType == 1||detail.sellType == 2)&&(detail.isShare == 1))||((detail.isBoss == 1)&& (detail.isShare != 1)&&((detail.boxId != null)||(detail.aid=== detail.aidUrl))&&(detail.isRebate!=1)||((detail.isRebate==1)&&((detail.isBoss == 1)&&(detail.isShare!= 1))))" class="footer-block-2" data-toggle="modal" data-target="#editCutomer"  id="customerBuyBtnid">
			<span class="buy_now_btn" >立即购买</span>
			</button>
			<button  ng-if="((detail.sellType == 1||detail.sellType == 2)&&(detail.isShare == 1))||((detail.isBoss == 1)&& (detail.isShare != 1)&&((detail.boxId != null)||(detail.aid=== detail.aidUrl))&&(detail.isRebate!=1))" class="footer-block-2" ng-click="detail.toPGood()">
			<span class="buy_now_btn">立即备货</span>
			</button> -->
			<!-- <button ng-if="((detail.isfanli==undefined)||((detail.isfanli==1)&&(detail.isBoss==1)))" class="footer-block-2" data-toggle="modal" data-target="#editCutomer">
			<span class="buy_now_btn" >立即购买</span>
			</button> -->
			<button id="customerBuyBtnid" ng-if="((detail.isfanli==1)&&(detail.isBoss==1))||(detail.isBoss!=1)" class="footer-block-2"  data-toggle="modal" data-target="#editCutomer">			
			<span class="buy_now_btn" >立即购买</span>
			</button>
			<button ng-if="((detail.isfanli!=1)&&(detail.isBoss==1))" class="footer-block-2" ng-click="detail.toPGood()">
			<span class="buy_now_btn">立即备货</span>
			</button>
		</div>

		<!-- 模态框（Modal） -->
		<div class="modal fade" id="editCutomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog editcustomer" style="margin-top: 44%;">
				
				<div ng-if="detail.supplyid == 1" class="modal-content customermodal-content" >
						<div class="modal-header customer-header">
							<h5 class="modal-title" id="myModalLabel"> 确认购买？ </h5>
						</div>
						<div class="modal-body">
							<div class="" style="padding: 10px;position:relative">
								<img src="../local/source/weixin.png" width="40px" height="40px" style="margin-left: 8px;">
								<span style="margin-left: 6px;color: #8f8f94;display:inline">微信支付</span>
								<input class="radio" name="pay" type="radio" value="2" checked/>
					       </div>
						</div>
						<div class="modal-footer"style="padding: 3%;text-align: center;">
							<button type="button" class="btn btn-default" data-dismiss="modal" style="width:25%">
							关闭
							</button>
							<button type="button" class="btn btn-success" ng-click="detail.confirm()">
							立即下单
							</button>
						</div>
				</div><!-- /.modal-content -->


				<div ng-if="detail.supplyid !=1" class="modal-content customermodal-content" >
					<div class="modal-header customer-header">
						<h5 class="modal-title" id="myModalLabel"> 您好， 完善您的信息，我们尽快与您联系 </h5>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon">姓名</span>
							<input type="text" class="form-control" placeholder="怎么称呼？" id="order_name">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">电话</span>
							<input type="number" class="form-control" placeholder="您常用的联系方式？" id="order_phone">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">备注</span>
							<input type="text" class="form-control" placeholder="有什么需要留言咨询的吗" id="order_address">
						</div>
						<br>
						<span style="color:red;display: none" id="alerttext_toast" ></span>
						<br>
						<span>承诺，以上信息我们会严格保密，不会透露您的个人隐私</span>
					</div>
					<div class="modal-footer"style="padding: 3%">
						<button type="button" class="btn btn-default" data-dismiss="modal">
						关闭
						</button>
						<button type="button" class="btn btn-success" ng-click="detail.confirmFakeOrder()" >
						立即下单
						</button>
					</div>
				</div>

			</div><!-- /.modal -->



		</div>

<!-- 		<div class="modal fade" id="confirmTip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog editcustomer" style="margin-top: 44%;">
		<div class="modal-content customermodal-content" >
			<div class="modal-header customer-header">
				<h5 class="modal-title" id="myModalLabel"> 温馨提示 </h5>
			</div>
			<div class="modal-body">
				<div class="" style="padding: 10px;position:relative;text-align: center;">
					<span style="margin-left: 6px;color: #8f8f94;display:inline">此属性商品暂不支持购买</span>
		       </div>
			</div>
			<div class="modal-footer"style="padding: 3%;text-align: center;">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="width:25%">
				关闭
				</button>
			</div>
		</div>
	</div>
</div> -->


		<div class="modal fade" id="editOldCutomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog editcustomer">
				<div class="modal-content customermodal-content" >
					<div class="modal-header customer-header">
						<h5 class="modal-title" id="myModalLabel"> 您好， 完善您的信息，我们尽快与您联系 </h5>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon">姓名</span>
							<input type="text" class="form-control" placeholder="怎么称呼？" id="order_name">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">电话</span>
							<input type="number" class="form-control" placeholder="您常用的联系方式？" id="order_phone">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">备注</span>
							<input type="text" class="form-control" placeholder="有什么需要留言咨询的吗" id="order_address">
						</div>
						<br>
						<span style="color:red;display: none" id="alerttext_toast" ></span>
						<br>
						<span>承诺，以上信息我们会严格保密，不会透露您的个人隐私</span>
					</div>
					<div class="modal-footer"style="padding: 3%">
						<button type="button" class="btn btn-default" data-dismiss="modal">
						关闭
						</button>
						<button type="button" class="btn btn-success" ng-click="detail.confirmFakeOrder()" >
						立即下单
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal -->
		</div>

		<!--修改零售价模态框-->
		<div class="modal fade" id="editPriceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog editcustomer">
				<div class="modal-content customermodal-content" >
					<div class="modal-header customer-header">
						<h5 class="modal-title"> 您好，您可以修改本商品的销售价格 </h5>
					</div>
					<div class="modal-body">
						<div class="input-group" >
							<span class="input-group-addon">选版本</span>
							<select type="text" class="form-control" ng-init="detail.selectValue='0';" ng-model='detail.selectValue' ng-change="detail.changeOption(detail.selectValue)">
								<option  ng-repeat="list in detail.goodsList" value='{{$index}}'>{{list.attr}}</option>
							</select>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">{{detail.isRebate==1?'返利':'进货价'}}</span>
							<input type="number" class="form-control" disabled="" value="{{detail.isRebate==1?detail.goodsList[detail.selectValue].rebate_money.toFixed(2):detail.goodsList[detail.selectValue].wholesale_price.toFixed(2)}}">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">零售价</span>
							<input type="number" class="form-control" placeholder="输入商品零售价" value="{{detail.goodsList[detail.selectValue].goods_price}}" ng-model="detail.goods_price" >
							<span class="input-group-btn">
							<button class="btn btn-success" type="button" ng-click="detail.atomId=detail.goodsList[detail.selectValue].goods_atom_id;detail.setAttrPriceAction()">
							保存
							</button> 
						    </span>
						</div>
						<br>
						<span ng-if="(detail.reshow!=undefined )||(detail.reshow!=null)" style="color:#f15353" id="editalerttext_toast" >{{detail.reshow==0 ?'修改成功':'修改失败，请重新登录后再试'}}</span>
					</div>
					<div class="modal-footer"style="padding: 3%">
						<button type="button" class="btn btn-default" data-dismiss="modal" ng-click="detail.refresh()">
						关闭
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal -->
		</div>

		<div class="scroll" id="scroll" style="display:none;">
			<i class="fa fa-angle-double-up"></i>
		</div>

		<!-- <div class="public-cover" id="public_coverid">
			<i class="fa fa-circle-o-notch fa-spin"></i>
		</div> -->

		<section class="storesectionclass" id="storesectionid" ng-click="detail.missStoreBanner()">
			<img src="source//shoucangbanner.png" width="100%">
		</section>
		

	</div>

	<script >
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

</script>>
