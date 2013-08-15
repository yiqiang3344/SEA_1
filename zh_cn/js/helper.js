function showHead(){
	var html = '';
	html+='<div>';
    html+=' <a class="js_to_tools">web开发工具</a>';
	html+='	<a class="js_to_demo">展示平台</a>';
	html+='</div>';
	document.write(html);
    bind_click($('.js_to_tools'),function(){State.forward('Main','tools');})
    bind_click($('.js_to_demo'),function(){State.forward('Demo','Main');})
}

//弹窗
function MainFrame(id){
    var defaultscrollFunc = window.onmousewheel;
    function stopScroll(){
        $(document.body).css({'overflow-x':'hidden', 'overflow-y':'hidden'});
        var scrollFunc = function(){
            return false;
        }
        if(document.addEventListener){    
            document.addEventListener('DOMMouseScroll',scrollFunc,false);    
        }//W3C
        window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome 
    }
    function startScroll(){
        $(document.body).css({'overflow-x':'auto', 'overflow-y':'auto'});
        var scrollFunc = defaultscrollFunc;
        if(document.addEventListener){    
            document.addEventListener('DOMMouseScroll',scrollFunc,false);    
        }//W3C
        window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome 
    }
    this.element_id=id;
    this.dom=function(){
        return document.getElementById(this.element_id);
    }
    this.createLayer=function(zindex,type,opacity){
        this.removeLayer(zindex);
        stopScroll();
        type||(type=1);
        if(type==1){
            $(this.dom()).append('<div id="layer_'+zindex+'"></div>');
        }else if(type==2){
            $(this.dom()).append('<div id="layer_'+zindex+'" style="position:absolute;left:0px;top:0px;height:100%;width:100%;z-index:'+zindex+'"></div>');
        }else if(type==3){
            $(this.dom()).append('<div id="layer_'+zindex+'" style="position:absolute;left:0px;top:0px;height:100%;width:100%;background-color:rgba(0,0,0,'+(opacity!=undefined?opacity:0.2)+');z-index:'+zindex+'"></div>');
        }else if(type==4){
            $(this.dom()).append('<div id="layer_'+zindex+'" style="position:absolute;left:0px;top:0px;height:100%;width:100%;background-color:#ffffff;z-index:'+zindex+'"></div>');
        }else if(type==5){
            $(this.dom()).append('<div id="layer_'+zindex+'" style="position:absolute;left:0px;top:169px;height:100%;width:100%;background-color:rgba(0,0,0,'+(opacity!=undefined?opacity:0.2)+');z-index:'+zindex+'"></div>');
        }else{
            bug();
        }
        return document.getElementById("layer_"+zindex);
    }
    this.removeLayer=function(zindex){
        startScroll();
        $("#layer_"+zindex).remove();
        return this;
    }
    this.showLayer=function(zindex)  {
        stopScroll();
        $("#layer_"+zindex).show();
        return this;
    }
    this.hideLayer=function(zindex)  {
        startScroll();
        $("#layer_"+zindex).hide();
        return this;
    }
}
MainFrame.prototype={};
var maindiv=new MainFrame("maindiv");

function dialogToCenter(elId){
    if(typeof(elId) == "string"){
         elId=$("#"+elId);
    }else{
        elId=$(elId);
    }
    var winSize = {
        mainHeight:$('#maindiv').height(),
        mainWidth :$('#maindiv').width(),
        winHeight:$(window).height(),
        winWidth :$(window).width(),
        scrollTop:$(window).scrollTop(),
        scrollLeft:$(window).scrollLeft(),
        overlayHeight:$(document).height(),
        overlayWidth :$(document).width()
    };
    var scrollTop=winSize.scrollTop;
    var last_height=scrollTop+300;
    elId.css("top",last_height+"px");
}

function mpop(content,bind,callback){
    maindiv.createLayer(1025,3);
    var dom=maindiv.createLayer(1030,2);

    var html='<div class="mpop" id="msg_dlg">';
    html+=      '<div class="mpop--html">'+content+'</div>';
    html+='</div>';
    $(dom).append(html);

    if(typeof bind == 'object'){
        bind_click($(dom).find(bind.dom),bind.callback);
    }

    bind_click($(dom).find(".mpop__close"), function(){
        maindiv.removeLayer(1025).removeLayer(1030);
        if(callback){
            callback(this);
        }
    });
    dialogToCenter("msg_dlg");
    return {
        close:function(){
            maindiv.removeLayer(1025).removeLayer(1030);
        },
        dom:dom
    }
}

var bind_click;
var unbind_click;
(function(){
    function pageX(dom){
        return $(dom).offset().left;
    }
    function pageY(dom){
        return $(dom).offset().top;
    }
    var event_bind_list=[];
    unbind_click=function(dom,callback){
        var touch=document.body.ontouchstart!==undefined;
        $(dom).each(function(){
            var me=this;
            var new_event_bind_list=[]
            $.each(event_bind_list,function(){
                if(this[0]==me && (!callback || callback==this[1])){
                    if(touch){
                        this[0].removeEventListener("touchstart", this[2], false);
                        this[0].removeEventListener("touchmove", this[3], false);
                        this[0].removeEventListener("touchend", this[4], false);
                    }else{
                        $(this[0]).unbind('mousedown',this[2]);
                        $(document.body).unbind('mousemove',this[3]);
                        $(document.body).unbind('mouseup',this[4]);
                    }
                }else{
                    new_event_bind_list.push(this);
                }
            });
            event_bind_list=new_event_bind_list;
        });
        return dom;
    }
    bind_click=function(dom,callback){
        var touch=document.body.ontouchstart!==undefined;
        $(dom).each(function() {
            var p;
            var move_len_x;
            var move_len_y;
            var me=this;
            function onstart(point,e){
                p=[point.pageX,point.pageY];
                if(APP_DEBUG==1){
                    // var s='<div class="btn_test_area" style="z-index:1000;position:absolute;left:'+(pageX(me))+'px;top:'+(pageY(me)-4)+'px;width:'+(me.offsetWidth)+'px;height:'+(me.offsetHeight)+'px;border:2px solid red;"></div>';
                    // $('body').append(s);
                }
                move_len_x=0;
                move_len_y=0;
            }
            function onmove(point,e){
                if(!p){
                    return;
                }
                if(APP_DEBUG==1){
                    $('.btn_test_area').remove();
                    // var s='<div class="btn_test_area" style="z-index:1000;position:absolute;left:'+(pageX(me))+'px;top:'+(pageY(me)-4)+'px;width:'+(me.offsetWidth)+'px;height:'+(me.offsetHeight)+'px;border:2px solid red;"></div>';
                    // $('body').append(s);
                }
                var new_p=[point.pageX,point.pageY];
                move_len_x+=Math.abs(new_p[0]-p[0]);
                move_len_y+=Math.abs(new_p[1]-p[1]);
                p=new_p;
            }
            function onend(point,e){
                if(!p){
                    return;
                }
                if(APP_DEBUG==1){
                    $('.btn_test_area').remove();
                }
                if(point){
                    p=[point.pageX,point.pageY];
                }
                var x=p[0]-(pageX(me));
                var y=p[1]-(pageY(me));
                if( (move_len_x+move_len_y)<20 && x>=0 && x<=me.offsetWidth && y>=0 && y<=me.offsetHeight){
                    if(callback){
                        callback.call(me,e);
                    }
                }
                p=null;
            }
            var touch_start,touch_move,touch_end;
            if(touch){
                touch_start=function(e){
                    onstart({
                        pageX:e.targetTouches[0].pageX,
                        pageY:e.targetTouches[0].pageY
                        },e);
                }
                touch_move=function(e){
                    onmove({
                        pageX:e.targetTouches[0].pageX,
                        pageY:e.targetTouches[0].pageY
                        },e);
                }
                touch_end=function(e){
                    onend(e.targetTouches.length>0?{
                        pageX:e.targetTouches[0].pageX,
                        pageY:e.targetTouches[0].pageY
                        }:null,e);
                }
                me.addEventListener("touchstart",touch_start,false);
                me.addEventListener("touchmove",touch_move,false);
                me.addEventListener("touchend",touch_end,false);
            }else{
                touch_start=function(e){
                    if(e.button>0)return;
                    onstart({
                        pageX:e.pageX,
                        pageY:e.pageY
                        },e);
                }
                touch_move=function(e){
                    onmove({
                        pageX:e.pageX,
                        pageY:e.pageY
                        },e);
                }
                touch_end=function(e){
                    onend({
                        pageX:e.pageX,
                        pageY:e.pageY
                        },e);
                }
                $(me).mousedown(touch_start);
                $(document.body).mousemove(touch_move);
                $(document.body).mouseup(touch_end);
            }
            event_bind_list.push([me,callback,touch_start,touch_move,touch_end]);
        });
        return dom;
    }

    $.fn.bind_click=function(callback){
        return bind_click(this,callback);
    }
    $.fn.unbind_click=function(callback){
        return unbind_click(this,callback);
    }
})();