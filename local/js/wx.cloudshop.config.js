var globSessionStorage = window.sessionStorage;
var globLocalStorage = window.localStorage;

/*var Home_host = window.location.host;*/
var Comm_Config =  "http://10000dp.com/ydserver/";
/*var Comm_Config =  " http://172.18.15.119:8080/ydserver/";*/

var GLOB_AID= globSessionStorage ["sessionAid"] ;
var	GLOB_ALIAS= globSessionStorage ["sessionAlias"];
var	GLOB_SHOPID=  globSessionStorage ["sessionshopid"];
var	GLOB_SELLTYPE=  sessionStorage["sessionselltype"];
var	GLOB_ISBOSS= globSessionStorage["sessionisboss"];
var token = globSessionStorage["sessionistoken"]

var ShareShopPublicLink = "http://10000dp.com";

var ShreShopCommonLink = "http://10000dp.com/wxadmin/local/index.html#/shop";
/**
 * 
 * @type String
 * 商品分享链接的公共头部
 */
var ShareGoodsPublicLink = "http://10000dp.com/wxadmin/local/index.html#/detail";


var ShreShopCardCommonLink = "http://10000dp.com/wxadmin/local/view/boss/wshop_boss.php";

var GetRandomNum = function()
{
    var Min = 0;
    var Max = 10000;
    var Range = Max - Min;
    var Rand = Math.random();
    return(Min + Math.round(Rand * Range));
}

var request =
{
    QueryString : function(val)
    {
        var uri = window.location.search;
        var re = new RegExp("" +val+ "=([^&?]*)", "ig");
        return ((uri.match(re))?(uri.match(re)[0].substr(val.length+1)):null);
    }
}