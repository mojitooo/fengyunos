/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */

var GLOB_AID;
var GLOB_SHOPID;
var GLOB_SELLTYPE;
var GLOB_alias;
var GLOB_SHOPTYPE;
//底部事件标注
var WIN_BOM_EVENT = 0;
//商品列表类型 1:品牌查找 2：集合查找  3：关键字查找 4：区域查找
var GLOB_SEARFLAG = 3;
//页面标志
var GLOB_PAGE = 1;
//按品牌查找时 全局品牌ID
var GLOB_BRANDID = 1;
//按区域获取商品时，全局区域seq的值
var GLOB_SEQ = 1;
var GLOB_KEYWORDS;

var GLOB_ISBOSS;
var GLOB_ISSHARE;
//本地数据存储
var GLOB_localStorage = window.localStorage;
var GLOB_sessionStorage = window.sessionStorage;

//分享参数
var SHARE_TITTLE = "这是我的小店，快来看看吧";
var SHARE_TEXT = "这是我的小店，快来看看吧";
var IndexPage = 1;
var WIN_BOM_EVENT = 0;

var GLOB_ORDER = 0;//0不排序，1升序，2降序

GLOB_AID = request.QueryString("aid");
GLOB_alias = request.QueryString("alias");
GLOB_SHOPID = request.QueryString("shopid");
GLOB_ISBOSS = GLOB_sessionStorage["sessionisboss"];
GLOB_SELLTYPE = request.QueryString("selltype");
GLOB_ISSHARE = request.QueryString("isshare");
GLOB_SEARFLAG = 5;
var MainShopParam = {};
var Globmusic = [];

//getAreamsg();//获取banner和分类


function getShopInit() {

    //扫描电视二维码获取代理商boxid
    if ((null == GLOB_AID) || ('null' == GLOB_AID)) {
        var boxid = request.QueryString("boxid");
        createpagebyboxid(boxid);
    }
    else {
        getAgentInfo();
    }

}

function shopready() {
   // $("#public_coverid").fadeOut();
     loadbosshotgoods();
    // _shoploadallarealist();//加载全部区域
}

function visitorshopsharelog(shopname)
{
    //访问浏览次数
    $.ajax({
        type: "get",
        url: "" + Comm_Config + "wx/addVisitShop.do",
        data: {"agentid": GLOB_AID, "agentname": shopname},
        success: function(data) {
            //分享日志统计，成功与否，不做反馈
        }
    });
}

function createpagebyboxid(boxid)
{
    $.ajax({
        type: "get",
        url: "" + Comm_Config + "wx/getShopByMac.do",
        data: {"mac": boxid},
        async: false,
        success: function(data) {
            var d = eval(data);
            GLOB_AID = d.resultValue[0].agent_id;
            GLOB_SHOPID = d.resultValue[0].id;
            getAgentInfo();
        }
    });
}

function searchready()
{
    GLOB_AID = request.QueryString("aid");
    GLOB_alias = request.QueryString("alias");
    GLOB_ISBOSS = GLOB_sessionStorage["sessionisboss"];
    GLOB_ISSHARE = request.QueryString("isshare");
    GLOB_SHOPID = request.QueryString("shopid");
    loadheistry();
}


function getAreamsg(){
    $("#public_coverid").fadeOut();
    $.ajax({
        type: "POST",
        url: "" + Comm_Config + "client/getAreaListByMac.do",
        data: {"agentid": GLOB_AID,"shopid":GLOB_SHOPID,"alias":GLOB_alias},
        success: function(data) {
            
            var d = eval(data);
            var maxcatelen = d.resultValue.length;
            if(d.resultValue.length>7){
                maxcatelen = 7;
            }
            MainShopParam.catedata = d.resultValue;
            var catesource = $("#cateblock-template").html();
            var catetemplate = Handlebars.compile(catesource);
            //if(GLOB_SHOPTYPE == 1){
            //    $("#cateblockdiv").append("<div class=\"fun-modelblock\" style=\"\" onclick=\"toNiceMobile()\"><img src=\"http://static.51dh.com.cn/51yd/area_litpic/20150928/20150928125705586.png\" style=\"\">靓号专区</div>");
            //}
            for(j=0;j<maxcatelen;j++){
                var html = catetemplate(d.resultValue[j]);
                $("#cateblockdiv").append(html);
            }
            
            $("#cateblockdiv").append("<div class=\"fun-modelblock\" style=\"margin-top:8%;\" onclick=\"setCateShow(0)\"><img src=\"source/areamore.png\" style=\"margin-bottom:15%;\">更多</div>");
             $("img.lazzyload").lazyload({
                 effect: "fadeIn"
             });
           
        }
    });
     loadbosshotgoods();
     loadBannerList();
     loadBannerText();
     loadBannerMusic();
}

function toNiceMobile(){
    window.location.href ="./niceMobile/html/index.html?agentid="+GLOB_AID+"&shopid="+GLOB_SHOPID;
}
function loadBannerList(){
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getPicInfo.do",
        data: {"agent_id": GLOB_AID,"alias":GLOB_alias,"shopid":GLOB_SHOPID},
        success: function(data) {
            
            var d = eval(data);
            var source   = $("#shopbanner-template").html();
            var template = Handlebars.compile(source);
            
            for(i=0;i<d.resultValue.length;i++){
                d.resultValue[i].url =  d.resultValue[i].url+"@600w_337h_1e_1c";
                var html = template(d.resultValue[i]);
                $("#shopbannerdiv").append(html);
            }
            initbanner();
        }
    });
}

function loadBannerText(){
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getTxtInfo.do",
        data: {"agent_id": GLOB_AID,"alias":GLOB_alias,"shopid":GLOB_SHOPID},
        success: function(data) {
            var d = eval(data);
            var bannerText = "";
            for(i=0;i<d.resultValue.length;i++){
                if(d.resultValue[i].is_show == 1){
                    bannerText = bannerText+"&nbsp;&nbsp;&nbsp"+d.resultValue[i].content;
                }
            }
            $("#bannertextcontain").html(bannerText);
        }
    });
}

function loadBannerMusic(){
     $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getMusicInfo.do",
        data: {"agent_id": GLOB_AID,"alias":GLOB_alias,"shopid":GLOB_SHOPID},
        success: function(data) {
            var d = eval(data);
            if(d.resultValue.length<1){
                $("#palyiconid").hdie();
                return;
            }
            MainShopParam.isplaybg = 1;
            MainShopParam.bglength = d.resultValue.length;
            for(i=0;i<d.resultValue.length;i++){
                if(d.resultValue[i].is_show == 1){
                    Globmusic[i] = d.resultValue[i].url;
                }
               
            }
        }
    });
}


function playbgmusic() {

    
    if (1 != MainShopParam.isplaybg) {
        return;
    }
    if ("" == document.getElementById('bgmusicaudio').src) {
        MainShopParam.playindex = 0;
        document.getElementById('bgmusicaudio').src = Globmusic[MainShopParam.playindex];
    }
    var myAuto = document.getElementById('bgmusicaudio');
    myAuto.loop = false;
    if (1 != MainShopParam.isplay) {

        MainShopParam.isplay = 1;
        $("#palyiconid").attr("class", "fa fa-music fa-spin");
        myAuto.play();
    }
    else {
        MainShopParam.isplay = 0;
        $("#palyiconid").attr("class", "fa fa-music");
        myAuto.pause();
    }
    var GlobmyAuto = document.getElementById('bgmusicaudio');
    GlobmyAuto.addEventListener('ended', function() {
        console.log("over:" + MainShopParam.playindex);
        MainShopParam.playindex++;
        if (MainShopParam.playindex < MainShopParam.bglength) {
            document.getElementById('bgmusicaudio').src = Globmusic[MainShopParam.playindex];
        }
        else{
            MainShopParam.playindex = 0;
            document.getElementById('bgmusicaudio').src = Globmusic[MainShopParam.playindex];
        }
        GlobmyAuto.play();
    }, false);
}


function setCateShow(flag) {
   
    var d = eval(MainShopParam.catedata);
    var maxcatelen = d.length;
    var tailblock_litpic = "source/areaup.png";
    var tailblock_tittle = "收起";
    var tailblick_action = 1;
    if (flag) {
        if (d.length > 7) {
            maxcatelen = 7;
        }
        tailblock_litpic = "source/areamore.png";
        tailblock_tittle = "更多";
        tailblick_action = 0;
        window.location.href="#pagetophead";
    }
    else{
         window.location.href="#cateblockdiv";
    }
    $("#cateblockdiv").html("");
    var catesource = $("#cateblock-template").html();
    var catetemplate = Handlebars.compile(catesource);
    //if(GLOB_SHOPTYPE == 1){
    // $("#cateblockdiv").append("<div class=\"fun-modelblock\" style=\"\" onclick=\"toNiceMobile()\"><img src=\"http://static.51dh.com.cn/51yd/area_litpic/20150928/20150928125705586.png\" style=\"\">靓号专区</div>");
    // }
    for (j = 0; j < maxcatelen; j++) {
        var html = catetemplate(d[j]);
        $("#cateblockdiv").append(html);
    }
    $("#cateblockdiv").append("<div class=\"fun-modelblock\" style=\"margin-top:8%;\" onclick=\"setCateShow("+tailblick_action+")\"><img src="+tailblock_litpic+"  style=\"margin-bottom:15%;\">"+tailblock_tittle+"</div>");
     $("img.lazzyload").lazyload({
                 effect: "fadeIn"
             });
}


function initbanner() {
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        loop: true,
        lazyLoading : true,
        autoplay: 3000
    });
}

/**
 * 
 * @returns {undefined}
 * 获取代理商数据
 */
function getAgentInfo()
{
    var shopname;
    var ajaxData = {"agentid": GLOB_AID};
    var ajaxUrl = "wx/getAgentByAgentId.do";
    var ajaxType = "GET";
    if (GLOB_SHOPID) {
        ajaxData = {"agentid": GLOB_AID, "id": GLOB_SHOPID};
        ajaxUrl = "public/getShop.do";
        ajaxType = "POST";
    }
    $.ajax({
        type: ajaxType,
        url: "" + Comm_Config + "" + ajaxUrl + "",
        data: ajaxData,
         async: false,
        success: function(data) {
            var d = eval(data);
            //有效店铺信息
            if(d.resultValue.icon) $("#imgshopico").attr('src',d.resultValue.icon); 
            if (IsPC()&&(document.body.scrollWidth>900))
            {
                if (GLOB_SHOPID) {
                    window.location.href = "http://10000dp.com/App/Modules/rYshop/rYshop.html?aid=" + d.resultValue.agent_id + "?alias=" + d.alias + "?shopid=" + d.resultValue.id + "";
                    return;
                }
                window.location.href = "http://10000dp.com/App/Modules/rYshop/rYshop.html?aid=" + d.resultValue.id + "?alias=" + d.resultValue.alias_id + "?shopid=" + d.shopid + "";
                return;
            }

            if (d.shopid) {
                GLOB_SHOPID = d.shopid;
                getAgentInfo();
                return;
            }
            if (d.alias) {
                GLOB_alias = d.alias;
            }
                GLOB_SHOPTYPE = d.resultValue.shop_type;
            
            document.title = d.resultValue.shop_name;
            SHARE_TITTLE = "这是" + d.resultValue.shop_name + "的云店铺";
            SHARE_TEXT = "更多优惠商品，尽在" + d.resultValue.shop_name;
            shopname = d.resultValue.shop_name;
            $("#spanshopname").html(d.resultValue.shop_name+"("+d.resultValue.city+"-"+d.resultValue.county+")"); ;
            $("#spanbossname").html(d.resultValue.name+"("+d.resultValue.tel+")");
            if (1 == GLOB_ISSHARE){
                visitorshopsharelog(shopname);
            }
           
                

        }
    });

}
/**
 * 
 * @returns {undefined}
 */
function getshoturl()
{
    var url = location.href.split('#')[0];

    $.ajax({
        type: "POST",
        url: "http://dwz.cn/create.php",
        data: {"url": url},
        dataType: 'json',
        success: function(data) {
            var d = eval(data);
            alert(data.tinyurl);
        },
        error: function(data)
        {
            alert("12313");
        }
    });
}

function voicepageinit()
{

    document.getElementById('textlistid').innerHTML = "";

    document.getElementById('speakloudy').innerHTML = "点击麦克风图标开始说话";
    document.getElementById('tipsspanid').style.display = "none";
    document.getElementById('voiceicoId').style.display = "none";
    document.getElementById('mircoonId').style.display = "none";
    document.getElementById('mircooffid').style.display = "";

}
/**
 * 
 * @returns {undefined}
 */
function stoprecord()
{

    $("#stopRecord").click();//结束录音
    document.getElementById('speakloudy').innerHTML = "录音结束，正在分析";
    document.getElementById('voiceicoId').style.display = "";
    document.getElementById('mircoonId').style.display = "none";
    document.getElementById('preloaddiv').style.display = "none";
    document.getElementById('mircoonId').style.display = "preloaddiv";

}

function analysresult()
{

}
function closevoicepage(flage)
{

    $("#voicepageid").slideUp(800);
    if (1 == flage)
    {
        document.getElementById('shopcontain').style.display = "";
    }
    else if (2 == flage)
    {
        document.getElementById('goodsLitContainId').style.display = "";
    }

}

function startvoicepage(flage)
{
    if (!isWeiXin())
    {
        alert("此功能在微信浏览器中才有效哦")
        return;
    }
    $("#voicepageid").slideDown(800);
    if (1 == flage)
    {
        document.getElementById('shopcontain').style.display = "none";
    }
    else if (2 == flage)
    {
        document.getElementById('goodsLitContainId').style.display = "none";
    }
    voicepageinit();
}

function showStoreBanner()
{
    if (!isWeiXin())
    {
        alert("此功能在微信浏览器中才有效哦")
        return;
    }
    document.getElementById('storesectionid').style.display = "block";
}

function isWeiXin() {
    var ua = window.navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == 'micromessenger') {
        return true;
    } else {
        return false;
    }
}

function missStoreBanner()
{
//    document.getElementById('bosshotId').style.display = "";
    document.getElementById('storesectionid').style.display = "none";
}

/*
 * 
 * 进入店铺详情页面
 */
function gotoBossDetail()
{
    if (GLOB_SHOPID) {
        window.location = "wshop_boss.php?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare=" + GLOB_ISSHARE;
    }
    else {
        window.location = "wshop_boss.php?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE;
    }
}
/*
 * 
 * 进入订单详情页面
 */
function gotorder()
{
   var ss = GetRandomNum();
    if (GLOB_SHOPID) {
        window.location.href="ordercommand.html?aid="+GLOB_AID+"&shopid=" + GLOB_SHOPID +"&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE+ "&alias="+GLOB_alias+"?"+ ss + "";
    }
    else {
        window.location.href="ordercommand.html?aid="+GLOB_AID+"&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE + "&alias="+GLOB_alias+"?"+ ss + "";
    }
   
}
/**
 * 
 * @returns {undefined}
 * 开始录音
 */
function startvoice()
{
    document.getElementById('mircoonId').style.display = "";
    document.getElementById('preloaddiv').style.display = "";
    document.getElementById('mircooffid').style.display = "none";
    document.getElementById('speakloudy').innerHTML = "大声说出你心仪的宝贝名字<br><small>说完点击图标停止</small>";
    //开始录音
    $("#startRecord").click();

}
/**
 * 
 * @returns {undefined}
 * 获取到用户录音
 */
function getuservoice(str)
{
    var textlistid = $("#textlistid");
    if ((null == str) || ("" == str) || ('uservoiceundefine' == str))
    {
        //录音失败
        document.getElementById('speakloudy').innerHTML = "没听清，再试一次";
        document.getElementById('mircooffid').style.display = "";

        document.getElementById('voiceicoId').style.display = "none";
    }
    else
    {
        var param = "代理商：" + GLOB_AID + ";语音搜索:" + voicetext;
        _hmt.push(['_trackEvent', '云店铺', '语音搜索', param]);
        var voicetext = stripscript(str);
        textlistid.append("<span>“" + voicetext + "”</span>");
        textlistid.append("<span style=\"color:#000;font-size:80%;display:block\">“亲，正在帮您搜索：" + voicetext + "”</span>");
        setTimeout("voicesearch('" + voicetext + "');", 1000);
    }


}


function stripscript(s) {
    var pattern = new RegExp("[`~!@#$^&*()=|{}':;',[].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
    var rs = "";
    for (var i = 0; i < s.length; i++) {
        rs = rs + s.substr(i, 1).replace(pattern, '');
    }
    return rs;
}

function voicesearch(str)
{
    $("#homeinputsearch").val(str);
    handelKeyWords(str);
}

function showslider()
{
    _shoploadallarealist();//加载全部区域
    $("#sliderpage").show();
    $("#sliderpage").animate({left: '0px'});
    ;
}

function hidenslider()
{

    $("#sliderpage").animate({left: '-100%'});
}


/**
 * 
 * @returns {undefined}
 * 加载全部区域列表
 */
function _shoploadallarealist()
{
    var sliderpageul = $("#sliderpageul");
    document.getElementById('sliderpageul').innerHTML = "";
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getAreaListByAgentNoPage.do",
        data: {"agentid": GLOB_AID, "alias": GLOB_alias},
        success: function(data) {
            var d = eval(data);
            for (i = 0; i < d.resultValue.length; i++)
            {
                if (d.resultValue[i].litpic)
                {
                    sliderpageul.append("<div class=\"sliderpage-li\" onclick=\"toAreaZoon(" + d.resultValue[i].seq + ")\"><img class=\"lazyload\" data-original=" + d.resultValue[i].litpic + " src=\"source/example_area.png\" width=\"30%;\"><p>" + d.resultValue[i].name + "</p></div>");
                }
            }
             $("img.lazzyload").lazyload({
                 effect: "fadeIn"
             });
        }
    });
}

/**
 * 
 * @param {type} seq
 * @returns {undefined}
 * 根据seq获取商品列表
 */
function toAreaZoon(seq)
{
    if (GLOB_SHOPID) {
        window.location = "wshop_list.php?seq=" + seq + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare=" + GLOB_ISSHARE + "";
        return;
    }
    window.location = "wshop_list.php?seq=" + seq + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias +"&selltype=" + GLOB_SELLTYPE +  "&isshare=" + GLOB_ISSHARE + "";
}

function loadbosshotgoods()
{    
    if (((1 == GLOB_SELLTYPE)||(2 == GLOB_SELLTYPE)) && (1 == GLOB_ISSHARE))
    {
        $("#orderinfo").show();
    }
    var booshotgoodsListId = $("#booshotgoodsListId");
    var classflag = 1;
    var classvalue = "boss-hotgoods-block-left";
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getTopGoodsList.do",
        data: {"agentid": GLOB_AID, "alias": GLOB_alias,"shopid": GLOB_SHOPID,"page": IndexPage, "orderType": GLOB_ORDER},
        success: function(data) {
            var d = eval(data);
            var whosalePrice = "";

            if (1 == IndexPage) {
                WIN_BOM_EVENT = 1;
                document.getElementById('top1id').innerHTML = "店主推荐：" + d.areaname;
                if (0 == d.resultValue.length)
                {
                    booshotgoodsListId.append("<span>我们店铺没有推荐商品，看看别的吧</span>");
                    return;
                }
            }
            if (10 > d.resultValue.length) {
                WIN_BOM_EVENT = 0;
            }
            for (i = 0; i < d.resultValue.length; i++)
            {
                if (classflag)
                {
                    classvalue = "boss-hotgoods-block-left";
                    classflag = 0;
                }
                else
                {
                    classvalue = "boss-hotgoods-block-right";
                    classflag = 1;
                }
                if ((1 == GLOB_ISBOSS) && (1 != GLOB_ISSHARE))
                {
                    if(d.is_rebate == 1){
                         whosalePrice = "<br><span style=\"color:#000;\">返利:￥" + d.resultValue[i].rebate_money + ".00</span>"
                    }else{
                         whosalePrice = "<br><span style=\"color:#000;\">进货价:￥" + d.resultValue[i].wholesale_price + ".00</span>"
                    }
                   
                }
                if (((1 == GLOB_SELLTYPE)||(2 == GLOB_SELLTYPE)) && (1 == GLOB_ISSHARE))
                {
                    if(d.is_rebate == 1){
                         whosalePrice = " <br><span style=\"color:#000;\">返利:￥" + d.resultValue[i].rebate_money + "</span>"
                    }else{
                         whosalePrice = " <br><span style=\"color:#000;\">进货价:￥" + d.resultValue[i].wholesale_price + ".00</span>"
                    }
                }
                booshotgoodsListId.append("<div class=" + classvalue + " onclick=\"hrefgoodsDetail('" + d.resultValue[i].base_id + "')\">\n\
                <div class=\"boss-hotgoods-block-imgblock\">\n\
                " + showimagemark(d.resultValue[i].market_type) +
                        "<img class=\"boss-hotgoods-block-img\"  data-original=" + d.resultValue[i].litpic + " src=\"source/example.png\" ></div>\n\
                <div class=\"boss-hotgoods-block-textblock\">\n\
                <p>" + d.resultValue[i].goods_name + "<font style=\"color:red\">(" + d.resultValue[i].attr + ")</font></p>\n\
                <span >￥" + d.resultValue[i].goods_price + ".00</span>" + whosalePrice + "</div></div>");
            }
            $("img.boss-hotgoods-block-img").lazyload({effect: "fadeIn"});
            
        }
    });
}
/**
 * 显示新品，特价，热销等
 * @param {type} item
 * @returns {String}
 */
function showimagemark(item) {
    var imgmark = "";
    switch (item) {
        case 0:   //普通
            imgmark = "";
            break;
        case 1:   //新品
            imgmark = "<img src=\"source/label_xinpin.png\" class=\"img_mark\" style=\"width:50px;margin-right:5px\">";
            break;
        case 2:   //品牌
            imgmark = "<img src=\"source/label_zhengpin.png\" class=\"img_mark\" style=\"width:50px;margin-right:5px\">";
            break;
        case 3:   //特价
            imgmark = "<img src=\"source/label_tejia.png\" class=\"img_mark\" style=\"width:50px;margin-right:5px\">";
            break;
        case 4:   //热销
            imgmark = "<img src=\"source/type_rexiao.png\" class=\"img_mark\" style=\"width:50px;margin-right:5px\">";
            break;
    }
    return imgmark;
}

/**
 * 
 * @returns {undefined}
 * 店铺首页模式
 */
function shopHomeModel()
{
    document.getElementById('shopHomeTopid').style.display = "";
    document.getElementById('goodsListTopId').style.display = "none";

    document.getElementById('shopcontain').style.display = "block";

    $("#goodsLitContainId").animate({width: '0%', opacity: '0.5'}, "slow");
    document.getElementById('goodsLitContainId').style.display = "none";
    WIN_BOM_EVENT = 0; //底部事件失效

}
/**
 * 
 * @returns {undefined}
 * s商品列表模式
 */
function goodsListModel()
{
    document.getElementById('shopHomeTopid').style.display = "none";
    document.getElementById('goodsListTopId').style.display = "";

    document.getElementById('shopcontain').style.display = "none";

    document.getElementById('goodsLitContainId').style.display = "block";
    $("#goodsLitContainId").animate({width: '100%', opacity: '1'}, "slow");
    WIN_BOM_EVENT = 1; //底部事件生效
    //document.getElementById('goodsLitContainId').style.display = "block";

}

/**
 * 
 * @param {type} brandid
 * @returns {undefined}
 * 前端点击品牌商品  进入商品列表模式
 */
function reGetBrandList(brandid)
{
    var param = "代理商：" + GLOB_AID + ";云店铺特色品牌搜索";
    _hmt.push(['_trackEvent', '云店铺', '云店铺特色品牌搜索', param]);
    if (GLOB_SHOPID) {
        window.location = "wshop_list.php?brandid=" + brandid + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare=" + GLOB_ISSHARE + "";
        return;
    }
    window.location = "wshop_list.php?brandid=" + brandid + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE + "";
}

function reGetCateList(cateflag)
{
    var param = "代理商：" + GLOB_AID + ";云店铺分类搜索";
    _hmt.push(['_trackEvent', '云店铺', '云店铺分类搜索', param]);
    if (GLOB_SHOPID) {
        window.location = "wshop_list.php?cateflag=" + cateflag + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare=" + GLOB_ISSHARE + "";
        return;
    }
    window.location = "wshop_list.php?cateflag=" + cateflag + "&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE + "";
}




/**
 * 
 * @returns {undefined}
 * 获取代理商数据
 */
function searchListgetAgentInfo()
{
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getAgentByAgentId.do",
        data: {"agentid": GLOB_AID},
        success: function(data) {
            var d = eval(data);
            SHARE_TITTLE = "这是" + d.resultValue.shop_name + "的云店铺";
            SHARE_TEXT = "这是" + d.resultValue.shop_name + "的云店铺";
        }
    });
}
/**
 * 
 * @returns {undefined}
 * 商品列表页面js  
 */
function  xshopListReady(order)
{
    GLOB_ORDER = order;
    var brandid = request.QueryString("brandid");
    var seq = request.QueryString("seq");
    var keywords = request.QueryString("keywords");
    var cateflag = request.QueryString("cateflag");

    GLOB_ISBOSS = GLOB_sessionStorage["sessionisboss"];
    GLOB_ISSHARE = request.QueryString("isshare");
    GLOB_alias = request.QueryString("alias");
    GLOB_AID = request.QueryString("aid");
    GLOB_SHOPID = request.QueryString("shopid");
    //重置 页码
    GLOB_PAGE = 1;
    //clear 父div
    document.getElementById('goodslistdiv').innerHTML = "";
    //底部事件生效
    WIN_BOM_EVENT = 1;

    //获取代理商信息
    searchListgetAgentInfo();

    //开始获取商品接口
    if (brandid)
    {
        //品牌查找模式
        GLOB_SEARFLAG = 1;
        //全局品牌ID
        GLOB_BRANDID = brandid;
        getBrandList();
        return;
    }
    if (seq)
    {
        //区域查找模式
        GLOB_SEARFLAG = 4;
        //全局seq
        GLOB_SEQ = seq;
        getSeqList();
        return;
    }
    if (keywords)
    {
        GLOB_SEARFLAG = 3;
        GLOB_KEYWORDS = GLOB_sessionStorage["keywordsvalue"]
        $("#goodsListinputId").val(GLOB_KEYWORDS);
        getKeyWordslist();
    }
    if (cateflag)
    {
        GLOB_SEARFLAG = 2;
        getCatelist();
    }

}
/**
 * 
 * @returns {undefined}
 * 获取品牌下加入云店的商品
 */
function getBrandList()
{
    var goodslistdiv = $("#goodslistdiv");
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getGoodsListByBrands.do",
        data: {"agentid": GLOB_AID, "alias": GLOB_alias, "brands": GLOB_BRANDID, "page": GLOB_PAGE, "orderType": GLOB_ORDER,"shopid":GLOB_SHOPID},
        success: function(data) {
            goodsDataHandel(data);
        }
    });
}
/**
 * 
 * @returns {undefined}
 * 获取区域下的商品列表
 */
function getSeqList()
{
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getGoodsListBySetting.do",
        data: {"areaseq": GLOB_SEQ, "agentid": GLOB_AID, "page": GLOB_PAGE,"shopid":GLOB_SHOPID, "alias": GLOB_alias, "orderType": GLOB_ORDER},
        success: function(data) {
            goodsDataHandel(data);
        }
    });
}

/**
 * 
 * @returns {undefined}
 * 根据关键字查找商品
 */
function getKeyWordslist()
{
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getGoodsListByName.do",
        data: {"name": GLOB_KEYWORDS, "agentid": GLOB_AID, "page": GLOB_PAGE,"alias": GLOB_alias, "orderType": GLOB_ORDER,"shopid":GLOB_SHOPID},
        success: function(data) {
            goodsDataHandel(data);
        }
    });
}


/**
 * 
 * @returns {undefined}
 * 获取最新商品列表
 */
function getCatelist()
{
    $.ajax({
        type: "GET",
        url: "" + Comm_Config + "wx/getPersonalGoodsListOnSale.do",
        data: {"agentid": GLOB_AID, "page": GLOB_PAGE, "alias": GLOB_alias,"shopid":GLOB_SHOPID},
        success: function(data) {
            goodsDataHandel(data);
        }
    });
}
/**
 * 
 * @param {type} data
 * @returns {undefined}
 * 处理商品列表结果函数
 */
function goodsDataHandel(data)
{
    var goodslistdiv = $("#goodslistdiv");
    var whosalePrice = "";
    var d = eval(data);
    if ((!d.resultValue) || (1 == d.resultValue))
    {
        WIN_BOM_EVENT = 0;
        return;
    }

    document.getElementById('goodsNumberSpanId').innerHTML = d.goodsCount;
    for (i = 0; i < d.resultValue.length; i++)
    {
        if ((1 == GLOB_ISBOSS) && (1 != GLOB_ISSHARE))
        {
            if(d.is_rebate == 1){
                whosalePrice = " <br><span style=\"color:#000;\">返利:￥" + d.resultValue[i].rebate_money + "</span>"
            }else{
                whosalePrice = " <br><span style=\"color:#000;\">进货价:￥" + d.resultValue[i].wholesale_price.toFixed(2) + "</span>"
            }
        }
        if (((1 == GLOB_SELLTYPE)||(2 == GLOB_SELLTYPE)) && (1 == GLOB_ISSHARE))
        {
           if(d.is_rebate == 1){
                whosalePrice = " <br><span style=\"color:#000;\">返利:￥" + d.resultValue[i].rebate_money + "</span>"
            }else{
                whosalePrice = " <br><span style=\"color:#000;\">进货价:￥" + d.resultValue[i].wholesale_price.toFixed(2) + "</span>"
            }
        }
        if (1 == d.resultValue[i].is_show)
        {
            goodslistdiv.append("<section class=\"goodssecion-list\" onclick=\"hrefgoodsDetail('" + d.resultValue[i].base_id + "')\">\n\
                    <div class=\"sectionlist-img\">" + showimagemark(d.resultValue[i].market_type) + "<img class=\"lazzyload\" data-original=" + d.resultValue[i].litpic + " src=\"source/example.png\"></div>\n\
                    <div class=\"sectionlist-text\"> \n\
                    <p class=\"sectionlist-name\">" + d.resultValue[i].goods_name + d.resultValue[i].attr + "</p>\n\
                    <p class=\"sectionlist-desc\">" + d.resultValue[i].goods_describe + "</p>\n\
                    <span>￥" + d.resultValue[i].goods_price.toFixed(2) + "</span>" + whosalePrice + "</div> </section>");
        }

    }
    $("img.lazzyload").lazyload();
}

function hrefgoodsDetail(id)
{
    var ss = GetRandomNum();
    var isshare = request.QueryString("isshare");

    if (isshare == 1)
    {
        if (GLOB_SHOPID) {
            if(GLOB_SELLTYPE){
                window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "?isshare=1&shopid=" + GLOB_SHOPID + "&selltype=" + GLOB_SELLTYPE + "&origin=5?" + ss + "";
            }else{
                window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "?isshare=1&shopid=" + GLOB_SHOPID + "&origin=5?" + ss + "";
            }
            
        }
        else {
            if(GLOB_SELLTYPE){
               window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "?isshare=1&selltype=" + GLOB_SELLTYPE + "&origin=5?" + ss + "";
            }else{
               window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "?isshare=1&origin=5?" + ss + "";
            }
            
        }

    }
    else
    {
        if (GLOB_SHOPID) {

            window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "&shopid=" + GLOB_SHOPID + "&origin=5?" + ss + "";
        }
        else {
            window.location.href = "goodsBlock.php?baseid=" + id + "&aid=" + GLOB_AID + "&origin=5?" + ss + "";
        }

    }


}

/**
 * 
 * @returns {undefined}
 * 店铺分享日志
 */
function shopsharelog()
{

    //店铺分享页面
    var aid = request.QueryString("aid");
    $.ajax({
        type: "get",
        url: "" + Comm_Config + "wx/addShareShop.do",
        data: {"agentid": aid},
        success: function(data) {
            //分享日志统计，成功与否，不做反馈
        }
    });
}



function GetRandomNum()
{
    var Min = 0;
    var Max = 10000;
    var Range = Max - Min;
    var Rand = Math.random();
    return(Min + Math.round(Rand * Range));
}
/**
 * 
 * @param {type} param
 * 页面到底部事件
 */
$(window).scroll(function() {
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowHeight = $(this).height();
    if (scrollTop + windowHeight == scrollHeight) {
        if (WIN_BOM_EVENT)
        {
            //底部事件生效
            switch (GLOB_SEARFLAG)
            {
                case 1:
                    {
                        GLOB_PAGE++;
                        getBrandList();
                        //品牌查找模式
                        break;
                    }
                case 2:
                    {
                        //集合查找模式
                        GLOB_PAGE++;
                        getCatelist();
                        break;
                    }
                case 3:
                    {
                        //模糊查找模式
                        GLOB_PAGE++;
                        getKeyWordslist();
                        break;
                    }
                case 4:
                    {
                        GLOB_PAGE++;
                        getSeqList();
                        break;
                        //区域查找模式
                    }
                case 5:
                    {
                        IndexPage++;
                        loadbosshotgoods();
                        break;
                        
                    }
                  
                default:
                    break;
            }
        }
//        if (indexPageFlag) {
//           
//        }

    }
});

/**
 * 
 * @returns {undefined}
 * 返回店铺首页
 */
function gotoshophome()
{
    if (GLOB_SHOPID) {
        window.location.href = "wshop.php?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "";
        return;
    }
    window.location.href = "wshop.php?aid=" + GLOB_AID + "&selltype=" + GLOB_SELLTYPE + "&alias=" + GLOB_alias + "";
}

/**
 * 
 * @returns {undefined}
 * input 获取焦点 onfouce事件
 */
function searchGoodsByName()
{
    if (GLOB_SHOPID) {
        window.location.href = "wshop_search.php?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare" + GLOB_ISSHARE + "";
        return;
    }
    window.location.href = "wshop_search.php?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare" + GLOB_ISSHARE + "";
}

function searchByKeyWord()
{
    handelKeyWords($("#keywordinput").val());

}

function handelKeyWords(words)
{
    if ("" == words)
    {
        return;
    }
    GLOB_sessionStorage["keywordsvalue"] = words;
    $("#keywordinput").val(words);
    var param = "代理商：" + GLOB_AID + ";文字搜索:" + words;
    _hmt.push(['_trackEvent', '云店铺', '文字搜索', param]);
    storesearchList();

    if (GLOB_SHOPID) {
        window.location = "wshop_list.php?keywords=1&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&shopid=" + GLOB_SHOPID + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE + "";
        return;
    }
    window.location = "wshop_list.php?keywords=1&aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE + "";
}
function storesearchList()
{
    var stroeagestr;
    var keywordarry = new Array(); //定义一数组
    stroeagestr = GLOB_localStorage["keywordlist"];
    if (stroeagestr)
    {

        keywordarry = stroeagestr.split(","); //字符分割
        var arrylen = keywordarry.length;
        keywordarry[arrylen] = $("#keywordinput").val();
        GLOB_localStorage["keywordlist"] = keywordarry;
    }
    else
    {
        keywordarry[0] = $("#keywordinput").val();
        GLOB_localStorage["keywordlist"] = keywordarry;
    }

}


function loadheistry()
{
    document.getElementById('heistrylistId').innerHTML = "";
    var keywordarry = new Array(); //定义一数组
    var heistrylistId = $("#heistrylistId");
    stroeagestr = GLOB_localStorage["keywordlist"];
    if (stroeagestr)
    {

        keywordarry = stroeagestr.split(","); //字符分割
        for (i = 0; i < keywordarry.length; i++)
        {
            heistrylistId.append(" <div onclick=\"handelKeyWords('" + keywordarry[i] + "')\"class=\"localsearchlist-list\"><i class=\"  icon-time icon-large\"></i>&nbsp;" + keywordarry[i] + "</div>");
        }
        heistrylistId.append(" <div style=\"text-align:center;\"><a  onclick=\"clearhistery()\"class=\"btn btn-default\" role=\"button\" >清空搜索记录</a></div>");
    }

}

function clearhistery()
{
    GLOB_localStorage.removeItem("keywordlist")
    loadheistry();
}
/**
 * 店铺名片页面JS
 */
 
function bossPageReady()
{
    GLOB_AID = request.QueryString("aid");
    GLOB_alias = request.QueryString("alias");
    GLOB_SHOPID = request.QueryString("shopid");
    GLOB_ISSHARE = request.QueryString("isshare");
    getAgentMsg();
    getErderCode();
}

function gotoshopDetail()
{
    if (GLOB_SHOPID) {
        window.location = "http://10000dp.com/wxadmin/local/index.html#/shop?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&shopid=" + GLOB_SHOPID + "&isshare=" + GLOB_ISSHARE;
    }
    else {
        window.location = "http://10000dp.com/wxadmin/local/index.html#/shop?aid=" + GLOB_AID + "&alias=" + GLOB_alias + "&selltype=" + GLOB_SELLTYPE + "&isshare=" + GLOB_ISSHARE;
    }

}


function getAgentMsg()
{
    var ajaxData = {"agentid": GLOB_AID};
    var ajaxUrl = "wx/getAgentByAgentId.do";
    var ajaxType = "GET";
    if (GLOB_SHOPID) {
        ajaxData = {"agentid": GLOB_AID, "id": GLOB_SHOPID};
        ajaxUrl = "public/getShop.do";
        ajaxType = "POST";
    }
    $.ajax({
        type: ajaxType,
        url: "" + Comm_Config + "" + ajaxUrl + "",
        data: ajaxData,
        success: function(data) {
            var d = eval(data);
            if ((GLOB_AID == d.resultValue.id) || (GLOB_AID == d.resultValue.agent_id))
            {
                //有效店铺信息

                if (d.resultValue.icon)
                {
                    document.getElementById('shopico').setAttribute("src", d.resultValue.icon);
                }
                document.getElementById('tittleshopname').innerHTML = d.resultValue.shop_name;
                document.getElementById('msgshopName').innerHTML = d.resultValue.name;
                document.getElementById('msgshopshopname').innerHTML = d.resultValue.shop_name;
                document.getElementById('msgshoptel').innerHTML = d.resultValue.tel;
                document.getElementById('msgshophreftel').setAttribute("href", "tel:" + d.resultValue.tel);
                document.getElementById('msgshopqq').innerHTML = d.resultValue.qq;
                document.getElementById('msgshopwechat').innerHTML = d.resultValue.wechat;
                document.getElementById('msgshopaddr').innerHTML = d.resultValue.city + d.resultValue.county + d.resultValue.address;
                document.title = d.resultValue.shop_name;
                SHARE_TITTLE = "这是" + d.resultValue.shop_name + "的店铺名片";
                SHARE_TEXT = "这是" + d.resultValue.shop_name + "的店铺名片";
            }
            else
            {
                //店铺信息获取失败
            }
        }
    });
}

/*function getErderCode() {

    var qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 226, //设置宽高
        height: 226
    });
    var currenturl;
    if (GLOB_SHOPID) {
        currenturl = "" + ShreShopCommonLink + "?alias=" + GLOB_alias + "?aid=" + GLOB_AID + "?isshare=1?shopid=" + GLOB_SHOPID + "";
    }
    else {
        currenturl = "" + ShreShopCommonLink + "?alias=" + GLOB_alias + "?aid=" + GLOB_AID + "?isshare=1";
    }
    $.get("../publicWxAction/shotaddr.php?longurl=" + currenturl + "", function(data, status) {
        if (('success' == status) && (data.length < 100))
        {
            currenturl = data;
        }
        qrcode.makeCode(currenturl);
    });


}*/

function getErderCode(){
    loadAgentErCode()
    function loadAgentErCode(){
       
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    width : 226,//设置宽高
                    height : 226
                });
                var currenturl = ""+ShreShopCommonLink+"?alias="+GLOB_alias+"&aid="+GLOB_AID+"&shopid="+ GLOB_SHOPID +"&isshare=1";
                qrcode.makeCode(currenturl);    
       
    }
}
/**
 * 按照价格进行排序
 * @param {type} index
 *                   1 表示升序
 *                   2 表示降序
 * @returns {undefined}
 */
function selectgoodsbyincrease(index) {
    GLOB_ORDER = index;
    GLOB_PAGE = 1;
    WIN_BOM_EVENT = 1;
    IndexPage = 1;
    if (WIN_BOM_EVENT)
    {
        //底部事件生效
        switch (GLOB_SEARFLAG)
        {
            case 1:
                {
                    document.getElementById('goodslistdiv').innerHTML = "";
                    getBrandList();
                    //品牌查找模式
                    break;
                }
            case 2:
                {
                    //集合查找模式
                    document.getElementById('goodslistdiv').innerHTML = "";
                    getCatelist();
                    break;
                }
            case 3:
                {
                    //模糊查找模式
                    document.getElementById('goodslistdiv').innerHTML = "";
                    getKeyWordslist();
                    break;
                }
            case 4:
                {
                    document.getElementById('goodslistdiv').innerHTML = "";
                    getSeqList();
                    //区域查找模式
                }
                break;
            case 5:
                document.getElementById('booshotgoodsListId').innerHTML = "";
                loadbosshotgoods();
                break;
            default:
                break;
        }
    } else {

    }
//    alert(indexPageFlag)
//    if (indexPageFlag) {
//        alert(22222)
//        document.getElementById('booshotgoodsListId').innerHTML = "";
//        loadbosshotgoods();
//    }
}