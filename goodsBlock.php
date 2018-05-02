<?php error_reporting(0);
require_once "./publicWxAction/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk -> GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>商品详情</title>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
		<meta name="format-detection"content="telephone=no, email=no" />
		<meta http-equiv="x-dns-prefetch-control" content="on">
		<link rel="dns-prefetch" href="http://static.51dh.com.cn/">
		<link rel="dns-prefetch" href="http://cdn.bootcss.com">
		<link href="http://cdn.bootcss.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/Swiper/3.1.7/css/swiper.min.css" rel="stylesheet">
		<link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="css/goodsblock.css?14291608" rel="stylesheet">
	</head>
	<body onload="loadcomply()" style="-webkit-transition:-webkit-transform 1s ease-in-out;-webkit-text-size-adjust: 100%!important">

		<!-- 顶部商品相册轮播开始-->
		<div class="goods-photo-contain">
			<div class="swiper-container">
				<div class="swiper-wrapper" style="min-height: 300px;" id="swiper-goodsphoto"></div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
			<div class="goodslabel-contain" id="goodsinfo_labelcontainid">
				<img  id="goodslabelimgid">
			</div>
		</div>

		<!-- 商品相册结束，商品信息开始-->
		<div class="goods-msg-contain">
			<span class="goods-msg-name" id="goodsinfo_name">- - -</span>
			<span class="goods-msg-desc" id="goodsinfo_describe"> - - - </span>

			<span class="goods-msg-price">优惠价:￥<span style="font-size: 20px;font-weight: bold" id="goodsinfo_price">- -</span>
			<div id="bossdomprice" style="display:none">
				<span class="price-whosale-price">进价：￥ <span id="goodsinfo_whoprice">--</span> </span>
			</div>
			<div id="boss_rakeback" style="display:none">
				<span class="price-whosale-price">返利：￥ <span id="rakeback_money">--</span> </span>
			</div> </span>
			<button type="button" class="btn btn-default btn-xs" style="display: none;float:right;margin-top: 2%" data-toggle="modal" data-target="#editPriceModal" id="editpriceBtn">
			修改价格
			</button>

			<span class="price-price" id="goodslabel_tejia">原价：￥<span id="goodsinfo_oldprice"> - - - </span></span>
			
		</div>
		<div class="goods-msg-contain" >
			<div id="choose-baitiao" class="li choose-baitiao" style="">
				<div class="dd">
					
				</div>
			</div>
		</div>

		<!-- 商品信息结束，商品属性开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				版本
			</div>
			<div class="attr-value-div"  id="goodsAttr_contain">

			</div>
			<script id="goodsattr-template" type="text/x-handlebars-template">
				<div class="value-block-normal" onclick="setChoiceAttr({{goods_atom_id}},{{sortid}},{{goods_alias_id}},'{{attr}}',{{wholesale_price}},{{goods_price}},'{{from_url}}')" id="attrblock{{sortid}}">
				<p class="value-block-achive-p">{{attr}}</p>
				</div>
			</script>
		</div>

		<!--商品属性结束，配送服务开始-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				已选
			</div>
			<div class="attr-value-div">
				<p class="value-block-p" id="goodsinfo_attrconfirm">
					-----
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
				<p class="value-block-p" id="shopinfo_nameid">
					加载中...
				</p><i class="fa fa-creative-commons" style="color:#44264e"></i>
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
					由<span  id="shopinfo_shopnamepid"></span>发货并提供技术服务
				</p>
				<p class="value-block-p">
					<i class="fa fa-clock-o" style="color:#44264e"></i>&nbsp;次日达&nbsp;&nbsp; <i class="fa fa-credit-card" style="color:#44264e"></i>&nbsp;货到付款&nbsp;&nbsp; <i class="fa fa-archive" style="color:#44264e"></i>&nbsp;支持自提
				</p>
			</div>
		</div>
		<!--支付-->
		<div class="goods-attr-contain">
			<div class="attr-name">
				支付
			</div>
			<div class="attr-value-div paylink" onclick="javascrtpt:window.location.href='http://x.eqxiu.com/s/YlrhQhtj?eqrcode=1'">
				<p class="value-block-p" id="goodsinfo_attrconfirm">
					点击查看如何线上支付
				</p>
			</div>
		</div>
		<!-- 属性服务结束，店铺信息开始-->
		<div class="shop-info-contain">
			<div class="shop-info-achive">
				<div class="shop-info-ico">
					<img id="agentinfo_iconid" src="source/yunlogo.png">
				</div>
				<div class="shop-info-msg" onclick="toBossShop()">
					<p class="value-block-p">
						<strong id="shopinfo_shopnameid">51云店直营店</strong>
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
							<span class="shop-value-num" id="agentinfo_visitlog">- -</span>
							<span class="shop-value-name">浏览次数</span>
						</div>
						<div class="shop-value-block">
							<span class="shop-value-num" id="agentinfo_orderlog">- -</span>
							<span class="shop-value-name">交易量</span>
						</div>
						<div class="shop-value-block">
							<span class="shop-value-num" id="agentinfo_customerlog">- -</span>
							<span class="shop-value-name">关注人数</span>
						</div>

					</div>
					<div class="shop-horner-contain">
						<a type="button" class="btn btn-default"  id="bossTelspan2">
							<i class="fa fa-comments-o"></i>&nbsp;联系店主
						</a>
						<a type="button" class="btn btn-default" onclick="toBossShop()">
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
		</div>
		<div style="float: left;width: 100%;height: 68px;"></div>
		<!-- 商品详情结束，底部菜单开始-->
		<div class="footer-div">
			<div class="footer-block-1" style="text-align: center;">
				<a id="bottomcallboss">
					<i class="fa fa-commenting-o"></i>
					<span>店主</span>
				</a>

			</div>
			<div class="footer-block-1" onclick="toBossShop()">
				<i class="fa fa-home"></i>
				<span>店铺</span>
			</div>
			<div class="footer-block-1" onclick="showStoreBanner()">
				<i class="fa fa-heart-o"></i>
				<span>收藏</span>
			</div>
			<button class="footer-block-2" data-toggle="modal" data-target="#editCutomer"  id="customerBuyBtnid">
			<span class="buy_now_btn" >立即购买</span>
			</button>
			<button class="footer-block-2" id="bossBuyBtnid" style="display:none" >
			<span class="buy_now_btn"  >立即备货</span>
			</button>
		</div>

		<!-- 模态框（Modal） -->
		<div class="modal fade" id="editCutomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<button type="button" class="btn btn-success" id="onorderBtn" >
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
						<div class="input-group">
							<span class="input-group-addon">选版本</span>
							<select type="text" class="form-control"  id="attrselectid" onchange="getAttrPrice()"></select>
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">进货价</span>
							<input type="number" class="form-control" disabled="" id="attrwhosaleprice">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon">零售价</span>
							<input type="number" class="form-control" placeholder="输入商品零售价" id="attrprice">
							<span class="input-group-btn">
							<button class="btn btn-success" type="button" onclick="setAttrPriceAction()">
							保存
							</button> </span>
						</div>
						<br>
						<span style="color:#f15353;display: none" id="editalerttext_toast" ></span>
					</div>
					<div class="modal-footer"style="padding: 3%">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeeditmodal()">
						关闭
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal -->
		</div>

		<div class="scroll" id="scroll" style="display:none;">
			<i class="fa fa-angle-double-up"></i>
		</div>

		<div class="public-cover" id="public_coverid">
			<i class="fa fa-circle-o-notch fa-spin"></i>
		</div>

		<section class="storesectionclass" id="storesectionid" onclick="missStoreBanner()">
			<img src="source//shoucangbanner.png" width="100%">
		</section>
		<script src="http://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/Swiper/3.1.7/js/swiper.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<script src="http://cdn.bootcss.com/handlebars.js/4.0.3/handlebars.min.js"></script>
		<script src="http://cdn.bootcss.com/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
		<script src="commonJs/config.js?12231542"></script>
		<script src="js/goodsblock.js?041716976"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

		<script>
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
wx.ready(function() {
	readyshare();
});

function readyshare() {
	var random = GetRandomNum();
	var shareLink = ShareGoodsPublicLink + "?baseid=" + MaintainableJS.baseid + "&aid=" + MaintainableJS.aid + "?isshare=1?" + random;
	if(MaintainableJS.shopid) {
		shareLink = ShareGoodsPublicLink + "?baseid=" + MaintainableJS.baseid + "&aid=" + MaintainableJS.aid + "?isshare=1&shopid=" + MaintainableJS.shopid + "?" + random;
	}
	wx.onMenuShareTimeline({
		title: MaintainableJS.SHARE_TITTLE,
		link: shareLink,
		imgUrl: MaintainableJS.SHRE_PIC,
		success: function(res) {
			goodssharemark();
		}
	});

	wx.onMenuShareAppMessage({
		title: MaintainableJS.SHARE_TITTLE,
		desc: MaintainableJS.SHARE_CONTENT,
		link: shareLink,
		imgUrl: MaintainableJS.SHRE_PIC,
		success: function(res) {
			goodssharemark();
		}
	});
	wx.onMenuShareQQ({
		title: MaintainableJS.SHARE_TITTLE,
		desc: MaintainableJS.SHARE_CONTENT,
		link: shareLink,
		imgUrl: MaintainableJS.SHRE_PIC,
		success: function(res) {
			goodssharemark();
		}
	});
	wx.onMenuShareWeibo({
		title: MaintainableJS.SHARE_TITTLE,
		desc: MaintainableJS.SHARE_CONTENT,
		link: shareLink,
		imgUrl: MaintainableJS.SHRE_PIC,
		success: function(res) {
			goodssharemark();
		}
	});
}

function GetRandomNum() {
	var Min = 0;
	var Max = 10000;
	var Range = Max - Min;
	var Rand = Math.random();
	return(Min + Math.round(Rand * Range));
}

$(function() {
	$("[data-toggle='tooltip']").tooltip();
});
$(function() {
	showScroll();

	function showScroll() {
		$(window).scroll(function() {
			var scrollValue = $(window).scrollTop();
			scrollValue > 100 ? $('div[class=scroll]').fadeIn() : $('div[class=scroll]').fadeOut();
		});
		$('#scroll').click(function() {
			$("html,body").animate({
				scrollTop: 0
			}, 200);
		});
	}
})
</script>
	</body>

</html>
