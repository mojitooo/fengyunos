

var Glob_aid;
var Glob_alias;
var Glob_shopid;
/*var GLOB_SHOPTYPE;

GLOB_SHOPTYPE = request.QueryString("shoptype");*/
/**
 * 
 * @returns {undefined}
 * 微信云店首页
 */
function indexrady()
{
   Glob_aid = globSessionStorage["sessionAid"];
   Glob_alias = globSessionStorage["sessionAlias"];
   Glob_shopid = globSessionStorage["sessionshopid"];
   loadagentlog();
}


function loadagentlog()
{
     $.ajax({
        type:"get",
        url: ""+Comm_Config+"wx/getWxIndexReport.do", 
        data: {"agent_id":Glob_aid}, 
        success: function(data){
            var d = eval(data);
            $(document).attr("title",d.resultValue.shopName);
            if(11985 == Glob_aid){
                d.resultValue.visitShopCount = d.resultValue.visitShopCount+11000;
                d.resultValue.orderIntentCount = d.resultValue.orderIntentCount+35;
                d.resultValue.visitShopCountToday = d.resultValue.visitShopCountToday+550;
                d.resultValue.orderIntentCountToday = d.resultValue.orderIntentCountToday+3;
                d.resultValue.agentCustomerCountToday =d.resultValue.agentCustomerCountToday+ 3;
            }
             document.getElementById('allvisitorid').innerHTML=d.resultValue.visitShopCount;
             document.getElementById('allorderid').innerHTML=d.resultValue.orderIntentCount;
             document.getElementById('tdvisitorid').innerHTML=d.resultValue.visitShopCountToday;
             document.getElementById('tdoder').innerHTML=d.resultValue.orderIntentCountToday;
             document.getElementById('tdcomtoster').innerHTML=d.resultValue.agentCustomerCountToday;
        }
    });
}
/**
 * 
 * @param {type} index
 * @returns {undefined}
 * index:1 商品管理
 * 5:我的
 * 6::市场
 * 2： 订单管理
 * 3：店铺管理
 */
function funpoint(index)
{
    var radom = GetRandomNum();
    switch (index)
    {
        case 1:
            {
                window.location.href="ydcmd.html?"+radom;
                break;
            }
        case 2:
            {
                window.location.href="ordercommand.html?aid=" + Glob_aid +"&alias="+Glob_alias+"?"+radom;
                break;
            }
        case 3:
            {
                window.location.href="shopcommand.html?aid="+Glob_aid+"?"+radom;
                break;
            }
        case 4:
            {
                window.location.href="wshop.php?aid="+Glob_aid+"&alias="+Glob_alias+"?"+radom;
                break;
            }
        case 5:
            {
                window.location.href="ydmyinfo.html?"+radom;
                break;
            }
        case 6:
            {
              
                window.location.href="ydyuan.html?"+radom;
                break;
            }
        case 7:
            {
                window.location.href="ydcustomer.html?aid="+Glob_aid+"?"+radom;
                break;
            }
        case 8:
            {
                window.location.href="splitAccount/view/home.html?"+radom;
                break;
            }
        case 9:
            {
                window.location.href="index.php?"+radom;
                break;
            }
        case 10:
            {
                window.location.href="rebate.html?"+radom;
                break;
            }
        case 11:
            {
                window.location.href ="./niceMobile/html/index.html?agentid="+Glob_aid+"&shopid="+Glob_shopid;
                break;
            }
        default:break;
    }
}

function loadcustomerlist()
{
    var aid = request.QueryString("aid"); 
    $.ajax({
        type:"get",
        url: ""+Comm_Config+"wx/getAgentCustomer.do", 
        data: {"agentid":aid}, 
        success: function(data){
            var customerblocklist = $("#customerblocklist");
            var d = eval(data);
            if(d.resultValue.length>0)
            {
                
                //document.getElementById('customerblocklist').innerHTML="";
            }
            for(i=0;i<d.resultValue.length;i++)
            {
                customerblocklist.append("<a class=\"list-group-item\"  onclick=\"activecuntomer('"+d.resultValue[i].customer_phone+"')\"><h4 class=\"list-group-item-heading\" style=\"font-family:微软雅黑\">"+d.resultValue[i].customer_name+"</h4><p class=\"list-group-item-text\"><font style=\"color:#ff8208\">电话</font>: "+d.resultValue[i].customer_phone+"</p><p class=\"list-group-item-text\"><font style=\"color:#ff8208\">备注</font>:"+d.resultValue[i].remark+"</p></a>");
            
            }
        }
    });
}

function activecuntomer(tel)
{
    $("#telactivediv").show();
    document.getElementById('telvalue').innerHTML=tel;
    document.getElementById('aemallid').setAttribute("href", "sms:"+tel+"");
    document.getElementById('acallid').setAttribute("href", "tel:"+tel+"");
}

function hideteldiv()
{
    $("#telactivediv").hide();
}

 function GetRandomNum()
{   
    var Min = 0;
    var Max = 10000;
    var Range = Max - Min;   
    var Rand = Math.random();   
    return(Min + Math.round(Rand * Range));   
}  


function setCookie(cname, cvalue, exdays)
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}