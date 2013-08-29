var ybind;
var yunbind;
(function(){
    var handlers = {};
    ybind = function(type,dom,callback){
        if(!handlers[type+dom.selector]){
            handlers[type+dom.selector] = {};
        }
        handlers[type+dom.selector][callback] = function(event){
            var tar = event.target;
            dom.each(function(){
                if(this==tar){
                    callback.call(this);
                }
            });
        }

        if(type=='click'){
            yclick(dom,callback);
        }else{
            $(document).bind(type,handlers[type+dom.selector][callback]);
        }
    }

    yunbind = function(type,dom,callback){
        if(!handlers[type+dom.selector]){
            return dom;
        }
        if(type=='click'){
            yunbind_click(dom,callback);
        }else{
            if(!callback){//解绑所有
                $.each(handlers[type+dom.selector],function(k,func){
                    $(document).unbind(type,func);
                });
            }else{
                $(document).unbind(type,handlers[type+dom.selector][callback]);
            }
        }
    }

    var yunbind_click=function(dom,callback){
        var type = 'click';
        if(!handlers[type+dom.selector]){
            return dom;
        }
        var touch=document.body.ontouchstart!==undefined;
        var me=document;
        function removeEvent(funcs){
            if(touch){
                me.removeEventListener("touchstart",funcs[0], false);
                me.removeEventListener("touchmove", funcs[1], false);
                me.removeEventListener("touchend", funcs[2], false);
            }else{
                $(me).unbind('mousedown',funcs[0]);
                $(me).unbind('mousemove',funcs[1]);
                $(me).unbind('mouseup',funcs[2]);
            }
        }
        if(!callback){//解绑所有的
            $.each(handlers[type+dom.selector],function(k,funcs){
                removeEvent(funcs);
            });
            handlers[type+dom.selector] = null;
        }else{
            removeEvent(handlers[type+dom.selector][callback]);
            handlers[type+dom.selector][callback] = null;
        }
        return dom;
    }

    var yclick = function(dom,callback){
        var touch=document.body.ontouchstart!==undefined;
        var p;
        var move_len_x;
        var move_len_y;
        function pageX(dom){
            return $(dom).offset().left;
        }
        function pageY(dom){
            return $(dom).offset().top;
        }
        function onstart(point,e){
            dom.each(function(){
                if(e.target!=this){
                    return;
                }
                p=[point.pageX,point.pageY];
                if(APP_DEBUG==1){
                    // var s='<div class="js_btn_test_area pen" style="z-index:1000;position:absolute;left:'+(pageX(this))+'px;top:'+(pageY(this)-4)+'px;width:'+(this.offsetWidth)+'px;height:'+(this.offsetHeight)+'px;border:2px solid red;"></div>';
                    // $('body').append(s);
                }
                move_len_x=0;
                move_len_y=0;
            });
        }
        function onmove(point,e){
            if(!p){
                return;
            }
            dom.each(function(){
                if(e.target!=this){
                    return;
                }
                if(APP_DEBUG==1){
                    // $('.js_btn_test_area').remove();
                    // var s='<div class="js_btn_test_area pen" style="z-index:1000;position:absolute;left:'+(pageX(this))+'px;top:'+(pageY(this)-4)+'px;width:'+(this.offsetWidth)+'px;height:'+(this.offsetHeight)+'px;border:2px solid red;"></div>';
                    // $('body').append(s);
                }
                var new_p=[point.pageX,point.pageY];
                move_len_x+=Math.abs(new_p[0]-p[0]);
                move_len_y+=Math.abs(new_p[1]-p[1]);
                p=new_p;
            });
        }
        function onend(point,e){
            if(!p){
                return;
            }
            if(APP_DEBUG==1){
                $('.js_btn_test_area').remove();
            }
            dom.each(function(){
                if(e.target!=this){
                    return;
                }
                if(point){
                    p=[point.pageX,point.pageY];
                }
                var x=p[0]-(pageX(this));
                var y=p[1]-(pageY(this));
                if( (move_len_x+move_len_y)<20 && x>=0 && x<=this.offsetWidth && y>=0 && y<=this.offsetHeight){
                    if(callback){
                        callback.call(this,e);
                    }
                }
            });
            p=null;
        }
        var me=document;
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
            $(me).mousemove(touch_move);
            $(me).mouseup(touch_end);
        }
        
        if(!handlers['click'+dom.selector]){
            handlers['click'+dom.selector] = {};
        }
        handlers['click'+dom.selector][callback] = [touch_start,touch_move,touch_end];
        return dom;
    }
})();

var Header = function(){
    this.is_fresh = false;
    this.show = function(){
        var html = '';
        if(!this.is_fresh){
            html+='<div class="js_header"></div>';
            document.write(html);
        }
        html+=' <a class="js_to_tools">web开发工具</a>';
        html+=' <a class="js_to_demo">展示平台</a>';
        if(USER){
            html+=' <a class="js_to_add_blog">写博客</a>';
        }
        html+= '<a class="'+(USER?'js_logout':'js_login')+' fr" style="border:none;">&nbsp;&nbsp;&nbsp;&nbsp;</a>';
        $('.js_header').html(html);

        ybind('click',$('.js_to_add_blog'),function(){State.forward('Blog','AddBlog');});
        ybind('click',$('.js_to_tools'),function(){State.forward('Main','Tools');});
        ybind('click',$('.js_to_demo'),function(){State.forward('Demo','Main');});
        USER || ybind('click',$('.js_login'),function(){
            var content = '';
                content += '<div class="mpop--normal m0a mbs w200">';
                content += '    <div class="content"><input class="mpwd" type="password" id="pwd" placeholder="请输入密码"/></div>';
                content += '</div>';
                content += '<div class="m0a w100 cleb"><a class="fl" id="login">登录</a><a class="js_only_close fr">取消</a></div>';
            var pop = mpop(content,function(){
                ybind('click',$('#login'),function(){
                    var o_pwd = $('#pwd');
                    if($('#pwd').val().trim()==''){
                        o_pwd.parent().addClass('mpwd--error');
                        return;
                    }
                    yajax('AjaxMain','Login',{pwd:$('#pwd').val()},function(obj){
                        if(obj.code==1){
                            USER = obj.user;
                            hdMod.refresh();
                            maindiv.refresh();
                            pop.close();
                        }else{
                            o_pwd.parent().addClass('mpwd--error');
                        }
                    },this)
                });
            });
        });
        !USER || ybind('click',$('.js_logout'),function(){
            var content = '';
                content += '<div class="mpop--normal m0a mbs w200">';
                content += '    <div class="content">确定要登出？</div>';
                content += '</div>';
                content += '<div class="m0a w100 cleb"><a class="fl" id="logout">确定</a><a class="js_only_close fr">取消</a></div>';
            var pop = mpop(content,function(){
                ybind('click',$('#logout'),function(){
                    yajax('AjaxMain','Logout',{},function(obj){
                        if(obj.code==1){
                            USER = null;
                            hdMod.refresh();
                            maindiv.refresh();
                            pop.close();
                        }
                    },this)
                });
            });
        });    
    }

    this.refresh = function(){
        this.is_fresh = true;
        this.show();
        this.is_fresh = false;
    }
}
Header.prototype = {};

//页面实体
var maindiv,template,page_params,page_controller,page_bind;
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

    this.refresh = function(){
        page_controller && page_controller(page_params);
        var html = template.render(page_params);
        $('#maincontent').html(html);
        page_bind && page_bind();
    }

    this.page_print = function(){
        var html = '<div id="maincontent"></div>';
        document.write(html);
        this.refresh();
    }
}
MainFrame.prototype={};
maindiv=new MainFrame("maindiv");

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

    bind && bind();

    console.log($(dom).find(".js_close"));
    ybind('click',$(dom).find(".js_close"), function(){
        maindiv.removeLayer(1025).removeLayer(1030);
        callback && callback(this);
    });
    ybind('click',$(dom).find(".js_only_close"), function(){
        console.log(33);
        maindiv.removeLayer(1025).removeLayer(1030);
    });
    dialogToCenter("msg_dlg");
    return {
        close:function(){
            maindiv.removeLayer(1025).removeLayer(1030);
        },
        dom:dom
    }
}

(function(){
    // chrome shipped without the time arg in m10
    var timeundefined = false;
    if (window.webkitRequestAnimationFrame){
        webkitRequestAnimationFrame(function(time){
            timeundefined = (time == undefined);
        });
    }
    window.requestAnimFrame = (function(){
        return window.requestAnimationFrame ||
            (!timeundefined && window.webkitRequestAnimationFrame) ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function(callback, element){
                return window.setTimeout(function(){
                    callback(+new Date);
                }, 1000 / 60);
            };
    })();
})();

function draw_anim(Dom,width,height,cls,count,speed,skip) {
    return new function() {
        skip = skip ? skip : 1;
        speed = speed ? speed : 2000;
        var dom,frame_index;
        this.set = function() {
            Dom.css({width:width,height:height});
            frame_index = 0;
            typeof dom=='object' && dom.remove();
            dom = $('<span class="'+cls+' '+cls+formatNum(frame_index,4)+'"></span>');
            dom.appendTo(Dom);
            return this;
        }
        this.play = function(callback) {
            this.set();
            var last_index = 'start';
            var last_time = 0;
            setTimeout(run,0);
            function run(){
                var now=new Date().getTime();
                if(now-last_time > speed/count){
                    if(frame_index==count){
                        callback && callback();
                        return;
                    }
                    if (skip==1 || frame_index%skip==0) {
                        dom.attr('class',dom.attr('class').replace(cls+formatNum(last_index,4),cls+formatNum(frame_index,4)));
                        last_index = frame_index;
                    }
                    frame_index++;
                    last_time=now;
                }
                requestAnimFrame(run);
            }
        }
    }
}

function formatNum(num,f){
    var c=f-num.toString().length;
    for(var i=0;i<c;i++){
        num = '0'+num;
    }
    return num;
}

function dealLang(lang){
    if(lang=='dev'){
        lang='zh_cn';
    }
    if(/^zh_/.test(lang)){
        lang = lang.replace(/^zh_(.*)/, 'zh_'+lang.match(/^zh_(.*)/)[1].toUpperCase()); 
    }
    return lang;
}

function showTip(str,callback){
    var obj = $('<div style="color:#000;text-align:center;position:fixed;heigth:10%;top:50%;margin-top:-5%;width:20%;left:50%;margin-left:-10%;font-size:2em;font-weight:bold;">'+str+'</div>').appendTo('body');
    setTimeout(function(){
        obj.css({
            '-webkit-transition':'3s',
            '-webkit-transform': 'translate3d(0,-100px,0)',
            'opacity':0
        }).bind('webkitTransitionEnd',function(){
            obj.remove();
            callback && callback();
        });
    },0);
}

function dateFormat(time,flag){
    var date = new Date(time*1000);
    var ret = '';
    if(!flag || flag==1){
        ret += date.getFullYear();
        ret += '-';
        ret += date.getMonth()+1;
        ret += '-';
        ret += date.getDate();
    }else if(flag==2){
        ret += date.getFullYear();
        ret += '-';
        ret += date.getMonth()+1;
        ret += '-';
        ret += date.getDate();
        ret += ' ';
        ret += date.getHours();
        ret += ':';
        ret += date.getMinutes();
        ret += ':';
        ret += date.getSeconds();
    }
    return ret;
}

function time(){
    return Math.floor(STIME+(new Date().getTime()-CTIME)/1000);
}

function getUrl(c,a,p){
    if(a===undefined){
        var file;
        if(c.substr(0,3)=="js/" || c.substr(0,9)=="template/"){
            file=LANG+"/"+c;
        }else{
            file=c;
        }
        var pieces=c.split("/");
        var arr=URLCACHE;
        for(var i=0;i<pieces.length;i++){
            if(arr[pieces[i]]){
                arr=arr[pieces[i]];
            }
        }
        return BASEURL+"/"+file+"?v="+arr;
    }else {
        var url,param;
        if(typeof(a)=="string"){
            url=BASEURI+"/"+c+"/"+a;
            param=p;
        }else{
            url=BASEURI+"/"+c;
            param=a;
        }
        if(param){
            url+="?";
            for(var k in param){
                url+=encodeURIComponent(k)+"="+encodeURIComponent(param[k])+"&";
            }
        }
        return url;
    }
}

var State = {
    forward:function(c,a,p){
        if(LANG=='dev'){
            location.href = getUrl(c,a,p);
            return;
        }
        mloading.start();
        yajax('AjaxPage','Page',{page:c+'/'+a,params:p||'null'},function(obj){
            if(obj.code==1){
                mloading.end();
                var p_list=[],p_ss = '';
                if(p){
                    $.each(p,function(k,v){
                        p_list.push(k+'='+v);
                    });
                    p_ss = '?'+p_list.join('&');
                }
                history.pushState({params:obj.params,content:obj.content},0,BASEURI+'/'+c+'/'+a+p_ss);
                page_params = obj.params;
                eval(obj.content);
                maindiv.refresh();
            }
        },$(document));
    },
    back:function(n){
        history.go(-n);
    },
    go:function(n){
        history.go(n);
    }
}

function yajax(c,a,data,succ_callback,dom){
    if(dom){
        var k_disable=0;
        $(dom).each(function(){
            if($(this).data("k_disable")){
                k_disable=1;
            }
        });
        if(k_disable){
            return;
        }else{
            $(dom).data("k_disable",1);
        }
    }

    function show_error(error){
        alert(error?error:'data load error!');
    }

    var succ=function(obj){
        dom && $(dom).data("k_disable",0);
        if(obj==null || typeof(obj)!="object" || !obj.code || obj.code==-1){
            console.log(obj);
            show_error(1);
        }else{
            succ_callback(obj);
        }
    }
    var fail=function(jqXHR, textStatus, errorThrown){
        dom && $(dom).data("k_disable",0);
        if (jqXHR.status == 0 && textStatus=="error") {
            show_error();
        } else if(textStatus=="parsererror"){
            show_error();
        }else if(textStatus=="servererror"){
            show_error();
        }else{
            show_error();
        }
    };
    setTimeout(function(){
        $.ajax({
            url:getUrl(c,a),
            data:data,
            dataType:"json",
            type: "POST",
            success:succ,
            error:fail
        });
    },0);
}

function Mloading(){
    this.mstyle = $('<style class="loadingstyle">.loading{width: 50px; height: 50px; position: fixed; -webkit-animation: auto-circle 1s linear infinite ;top: 47%;left: 47%;} .loading span{display: block; background: #616161; -webkit-border-radius: 100%; position: absolute;} .loading span:nth-child(1){width: 18%; height: 18%; left: 50%; top: 0%; margin-left: -9%;} .loading span:nth-child(2){width: 16.5%; height: 16.5%; top: 15%; left: 28%; margin-left: -8.25%; margin-top: -8.25%;} .loading span:nth-child(3){width: 15%; height: 15%; top: 30%; left: 12%; margin-left: -7.5%; margin-top: -7.5%;} .loading span:nth-child(4){width: 13.5%; height: 13.5%; left: 0%; top: 50%; margin-top: -6.75%;} .loading span:nth-child(5){width: 12%; height: 12%; bottom: 28%; left: 12%; margin-left: -6%; margin-bottom: -6%;} .loading span:nth-child(6){width: 10.5%; height: 10.5%; bottom: 12%; left: 28%; margin-left: -5.25%; margin-bottom: -5.25%;} .loading span:nth-child(7){width: 9%; height: 9%; left: 50%; bottom: 0%; margin-left: -4.5%;} .loading span:nth-child(8){width: 7.5%; height: 7.5%; right: 25%; bottom: 10%; margin-right: -3.75%; margin-bottom: -3.75%;} .loading span:nth-child(9){width: 6%; height: 6%; bottom: 26%; right: 8%; margin-right: -3%; margin-bottom: -3%;} .loading span:nth-child(10){width: 4.5%; height: 4.5%; top: 50%; right: 0%; margin-left: -2.25%;} .loading span:nth-child(11){width: 3%; height: 3%; top: 30%; right: 9%; margin-right: -1.5%; margin-top: -1.5%;} .loading span:nth-child(12){width: 1.5%; height: 1.5%; top: 14%; right: 26%; margin-right: -0.75%; margin-top: -0.75%;} @-webkit-keyframes auto-circle{from{-webkit-transform: rotate(0deg);} to{-webkit-transform: rotate(360deg);}}.fadeOutDown{-webkit-animation:fadeOutDown 1s .2s ease both;} @-webkit-keyframes fadeOutDown{0%{opacity:1; -webkit-transform:translateY(0) rotate(0deg);} 10%{opacity:1; -webkit-transform:translateY(-50px);} 100%{opacity:0; -webkit-transform:translateY(450px) rotate(360deg);} }</style>'); 
    $('.loadingstyle').remove();
    this.mstyle.appendTo('head');
    this.obj = $('<div class="loading" style="display:none;"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>');
    this.obj.appendTo('body');
    this.start = function(){
        this.obj.removeClass('fadeOutDown');
        this.obj.show();
    }
    this.end = function(){
        this.obj.addClass('fadeOutDown');
    }
}
Mloading.prototype = {};