function reset_element_width(dom){
    if(typeof dom=="string"){
        dom=document.getElementById(dom);
    }
    var w=0;
    $(dom).children().each(function(){
        w+=$(this).width();
        if(/^[0-9]*/.test($(this).css("margin-left"))) w+=parseInt($(this).css("margin-left").replace("px",""));
        if(/^[0-9]*/.test($(this).css("margin-right"))) w+=parseInt($(this).css("margin-right").replace("px",""));
    });
    $(dom).css({
        "width":w+"px"
        });
}

function makeEventAble(me){
    me.event_map={};
    me.bind=function(n,h){if(!this.event_map[n]){this.event_map[n]=[];}this.event_map[n].push(h);return this}
    me.unbind=function(n){this.event_map[n]=undefined;return this}
    me.trigger=function(n,e){if(this.event_map[n]){for(var i=0;i<this.event_map[n].length;i++){this.event_map[n][i].call(this,e)}}return this}
}

function QMoveAble(ele,option){
    option||(option={});
    if(ele){
        if(typeof ele == "string"){
            this.element_id=ele;
        }else{
            this.element=ele;
        }
    }
    this.move_mode=option.move_mode;
    if(!this.move_mode){
        this.move_mode=$.browser.webkit?2:($.browser.msie && $.browser.version>=9)?3:$.browser.mozilla?4:1;
    }
    this.overbound_mode=[1,1];
    this.left=option.left?option.left:0;
    this.top=option.top?option.top:0;
    this.forward=option.forward?option.forward:0;
    if(option.callback){
        if(typeof option.callback=="function"){
            this.callback=option.callback;
        }
        else if(option.callback=="arrow_l_r"){
            var l=$(this.dom()).parent().parent().find(".arr4").first();
            var r=$(this.dom()).parent().parent().find(".arr4").last();
            this.callback=function(loc,width){
                if(width<=0){
                    l.css('margin-left','-999999em');
                    r.css('margin-left','-999999em');
                    return;
                }
                var per=loc/width;
                if(per>=0){
                    l.css('margin-left','-999999em');
                    r.css('margin-left','0');
                }else if(per<=-1){
                    r.css('margin-left','-999999em');
                    l.css('margin-left','0');
                }else{
                    l.css('margin-left','0');
                    r.css('margin-left','0');
                }
            };
        }
    }
    if(option.callback_onstart){
        if(typeof option.callback_onstart=="function"){
            this.callback_onstart=option.callback_onstart;
        }
    }
    if(option.callback_onmove){
        if(typeof option.callback_onmove=="function"){
            this.callback_onmove=option.callback_onmove;
        }
    }
    if(option.callback_onend){
        if(typeof option.callback_onend=="function"){
            this.callback_onend=option.callback_onend;
        }
    }
    if(option.callback_onmoveend){
        if(typeof option.callback_onmoveend=="function"){
            this.callback_onmoveend=option.callback_onmoveend;
        }
    }
    this.touchmove=false;
    this.synscroll=option.synscroll===undefined?false:option.synscroll;
    makeEventAble(this);
}
QMoveAble.prototype={
    dom:function(){
        if(!this.element){
            this.element=document.getElementById(this.element_id);
        }
        return this.element;
    },
    move:function(x,y){
        var box=this.box();
        var dom=this.dom();
        if(this.forward==1 && box[3]<=0){
            return this;
        }
        if(this.forward==0 && box[2]<=0){
            return this;
        }
        this.moveTo(box[0]+x,box[1]+y);
        return this;
    },
    moveTo:function(x,y){
        var mode=this.overbound_mode;
        var dom   =this.dom();
        var box=this.box();
        this.left=this.forward?0:mode[0]?Math.min(0,Math.max(-box[2],x)):x;
        this.top=this.forward?mode[1]?Math.max(-box[3],Math.min(0,y)):y:0;
        if(this.move_mode==1){

            dom.style.left=this.left+"px";
            dom.style.top=this.top+"px";
        }else if(this.move_mode==2){
            dom.style.webkitTransform='translate3d('+(this.left)+'px,'+(this.top)+'px,0px)';
            dom.webkitTransformX=this.left;
            dom.webkitTransformY=this.top;
        }else if(this.move_mode==3){
            dom.style.msTransform='translate('+(this.left)+'px,'+(this.top)+'px)';
        }else if(this.move_mode==4){
            dom.style.MozTransform='translate('+(this.left)+'px,'+(this.top)+'px)';
        }else if(this.move_mode==5){
            dom.style.webkitTransform='translate('+(this.left)+'px,'+(this.top)+'px)';
        }
        this.trigger("move");
        return this;
    },
    moveToEnd:function(){
        if (this.forward==0){
            if (this.box()[2]<0)
                return;
            this.moveTo(-this.box()[2],0);
        }
        else{
            if (this.box()[3]<0)
                return;
            this.moveTo(0,-this.box()[3]);
        }
    },
    checkPosition:function(){
        this.forward==0&&reset_element_width(this.dom());
        this.checkLocation();
    },
    checkLocation:function(){
        if(this.callback) this.forward==0?this.callback(this.box()[0],this.box()[2]):this.callback(this.box()[1],this.box()[3]);
    },
    checkLocationOnStart:function(){
        if(this.callback_onstart) this.forward==0?this.callback_onstart(this.box()[0],this.box()[2]):this.callback_onstart(this.box()[1],this.box()[3]);
    },
    checkLocationOnMove:function(){
        if(this.callback_onmove) this.forward==0?this.callback_onmove(this.box()[0],this.box()[2]):this.callback_onmove(this.box()[1],this.box()[3]);
    },
    checkLocationOnEnd:function(){
        if(this.callback_onend) this.forward==0?this.callback_onend(this.box()[0],this.box()[2]):this.callback_onend(this.box()[1],this.box()[3]);
    },
    checkLocationOnMoveEnd:function(){
        if(this.callback_onmoveend) this.forward==0?this.callback_onmoveend(this.box()[0],this.box()[2]):this.callback_onmoveend(this.box()[1],this.box()[3]);
    },
    makeDragAble:function(option){

        option||(option={});
        this.speed=option.speed?option.speed:[1,1];
        this.mouse_mode=option.mouse_mode;
        var distance=option.distance?option.distance:false;
        if(!this.mouse_mode){
            this.mouse_mode=document.body.ontouchstart===undefined?1:2;
        }

        var TestSpeedTime = [10,10];
        var stopAutoMotion=function() {
            $(dom).trigger( 'webkitTransitionEnd',1);
        };
        var startAutoMotion=function(speed,forward){
            if(speed[forward]==0){
                return;
            }
            var box=me.box();
            var v =Math.min(Math.abs(speed[forward]),1.2-forward*0.5);
            var a   = -1/600;//加速度
            var full_x   = -v*v/(2*a);
            var max_x    = speed[forward]>0?-box[forward]:box[2+forward]+box[forward];
            if(max_x==0){
                return;
            }
            if(max_x>full_x){
                t=-v/a;
                start_speed=2;
                end_speed=0;
            }else{
                t=-v/a -Math.sqrt(v/a*v/a+2*max_x/a);
                start_speed=v*t/max_x;
                end_speed= (v*t+a*t*t)/max_x;
            }
            var bezier=[0.2,start_speed*0.2,0.58,1-end_speed*(1-0.58)];
            var motionStart;
            var motionEnd;
            var motionStartTime;
            $(dom).css({
                webkitTransitionProperty:"-webkit-transform,left,top",
                webkitTransitionDuration:t+"ms",
                webkitTransitionTimingFunction: "cubic-bezier("+bezier[0]+","+bezier[1]+","+bezier[2]+","+bezier[3]+")"
            }).one('webkitTransitionEnd',
                function(e,user_stop){
                    if(user_stop){
                        var current=motionStart+CubicBezierAtTime( Math.min(1,(new Date().getTime()-motionStartTime+20)/t),bezier[0],bezier[1],bezier[2],bezier[3],1000)*(motionEnd-motionStart);
                        forward==0?me.moveTo(Math.round(current),0):me.moveTo(0,Math.round(current));
                        $(dom).css({
                            webkitTransitionProperty:"none"
                        });
                    }else{
                        $(dom).css({
                            webkitTransitionProperty:"none"
                        });
                    }
                    me.checkLocation();
                }
                );
            motionStartTime=new Date().getTime();
            motionStart=me.box()[forward];
            var pos=Math.round(speed[forward]>0?full_x:-full_x);
            forward==0?me.move(pos,0):me.move(0,pos);
            motionEnd=me.box()[forward];
            if(motionEnd==motionStart){
                $(dom).trigger( 'webkitTransitionEnd');
            }
        };
        var dom=this.dom();
        var pressed=false;
        var pos=null;
        var remain=[0,0];
        var mouse_pos_list=null;
        var me=this;
        var start_pos=[];
        var onmove=function(x,y){
            if(!pressed){
                return;
            }
            me.touchmove=true;
            var m=[(x-pos[0])*me.speed[0]+remain[0],(y-pos[1])*me.speed[1]+remain[1]];
            pos=[x,y];
            var t=new Date().getTime();
            mouse_pos_list.push([x,y,t]);
            if(mouse_pos_list.length>100){
                mouse_pos_list.shift();
            }
            remain=[m[0]-Math.floor(m[0]),m[1]-Math.floor(m[1])];
            me.move(Math.floor(m[0]),Math.floor(m[1]));
            me.checkLocation();
            me.checkLocationOnMove();
        };
        var onstart=function(x,y){
            pressed=true;
            me.touchmove=false;
            stopAutoMotion();
            start_pos=pos=[x,y];
            var t=new Date().getTime();
            mouse_pos_list=[];
            mouse_pos_list.push([x,y,t]);
            me.checkLocationOnStart();
        };
        var onend=function(){
            if(!pressed){
                return;
            }
            var speed=[0,0];
            if(mouse_pos_list && mouse_pos_list.length>1){
                for(var i=0;i<2;i++){
                    var end=mouse_pos_list[mouse_pos_list.length-1];
                    var start;
                    for(var j=mouse_pos_list.length-1;j-- >0;){
                        start=mouse_pos_list[j];
                        if(end[2]-start[2]>TestSpeedTime[i]){
                            break;
                        }
                    }
                    if(end[2]-start[2]>0){
                        speed[i]=(end[i]-start[i])/(end[2]-start[2])*me.speed[i];
                    }
                }
            }
            if(distance){
                var motionStart=mouse_pos_list.pop()[0];
                var t=motionStart-start_pos[0];
                var add=0;
                var speed_forward = Math.abs(me.forward==0?speed[0]:speed[1]);
                var distance_max = Math.min(distance*0.4,speed_forward>1.1?0:distance);
                if(Math.abs(t)>distance_max){
                    add=t>0?1:-1;
                }
                var timing_function=Math.abs(t)>distance_max?"ease-out":"ease-out";
                var dom_pos=Math.floor((me.forward==0?me.box()[0]:me.box()[1])/distance);
                dom_pos+=t>=0?0:1;
                dom_pos+=add;
                var motionStartTime=new Date().getTime();
                var motionEnd=dom_pos*distance;
                var n=me.box()[0]/me.box()[2];
                var motionTime=Math.sqrt(Math.abs((me.forward==0?me.left:me.top)-motionEnd))*(Math.abs(t)>distance_max?18:30)*0.7;
                //var motionTime=Math.abs(t)>distance_max?(Math.max(100,Math.min(500,(1.69*Math.abs((me.forward==0?me.left:me.top)-motionEnd)/speed_forward)))):(Math.sqrt(Math.abs((me.forward==0?me.left:me.top)-motionEnd))*30);
                if(n!=0&&n!=-1){
                    $(dom).css({
                        webkitTransitionProperty:"-webkit-transform,left,top",
                        webkitTransitionDuration:motionTime+"ms",
                        webkitTransitionTimingFunction:timing_function
                    }).one('webkitTransitionEnd',
                        function(e,user_stop){
                            $(dom).css({
                                webkitTransitionProperty:"none"
                            });
                            me.checkLocation();
                            me.checkLocationOnMoveEnd();
                        });
                    me.moveTo(motionEnd,0);
                }
            }else{
                startAutoMotion(speed,me.forward);
            }
            me.checkLocation();
            me.checkLocationOnEnd();
            mouse_pos_list=null;
            pressed=false;
            pos=null;
        };
        if(this.mouse_mode==1){
            var handle_e=function(e){
                e.preventDefault?e.preventDefault():e.returnValue = true;
            };
            $(dom.parentNode).mousemove(function(e) {
                onmove(e.pageX,e.pageY);
            })
            .mousedown(function(e) {
                if(e.button>0)return;
                onstart(e.pageX,e.pageY);
            })
            .mouseup(function(e) {
                onend();
            })
            .mouseleave(function(e){
                onend();
            });
        }else if(this.mouse_mode==2){
            dom.addEventListener("touchmove",function(e) {
                if (!me.synscroll && (me.forward!=1 || (-me.box()[1]) != me.box()[3])){
                    e.preventDefault?e.preventDefault():e.returnValue = true;
                }
                onmove(e.targetTouches[0].pageX,e.targetTouches[0].pageY);
            },false);
            dom.addEventListener("touchstart",function(e){
                onstart(e.targetTouches[0].pageX,e.targetTouches[0].pageY);
            },false);
            dom.addEventListener("touchend",function(e){
                onend();
            },false);
        }
        return this;
    },
    box:function(){
        var dom   =this.dom();

        return [this.left,this.top,
        dom.clientWidth-dom.parentNode.clientWidth,dom.clientHeight-dom.parentNode.clientHeight
        ];
    },
    moveEffect:function(option){
        option||(option={});
        var time=option.time?option.time:320;
        var move_dis=option.move_dis?option.move_dis:[-640,0];
        var onstart_callback_trag=option.onstart_callback_trag?option.onstart_callback_trag:1;
        var me=this;
        var dom=this.dom();
        $(dom).css({
            webkitTransitionProperty:"-webkit-transform,left,top",
            webkitTransitionDuration:time+"ms",
            webkitTransitionTimingFunction: "ease-out"
        }).one('webkitTransitionEnd',
            function(){
                $(dom).css({
                    webkitTransitionProperty:"none"
                });
                me.checkLocation();
            });
        me.move(move_dis[0],move_dis[1]);
        if (onstart_callback_trag==1){
            me.checkLocation();
        }
    },
    moveToEffect:function(option){
        option||(option={});
        var time=option.time?option.time:320;
        var move_tar=option.move_tar?option.move_tar:[0,0];
        var onstart_callback_trag=option.onstart_callback_trag?option.onstart_callback_trag:1;
        var me=this;
        var dom=this.dom();
        $(dom).css({
            webkitTransitionProperty:"-webkit-transform,left,top",
            webkitTransitionDuration:time+"ms",
            webkitTransitionTimingFunction: "ease-out"
        }).one('webkitTransitionEnd',
            function(){
                $(dom).css({
                    webkitTransitionProperty:"none"
                });
                me.checkLocation();
            });
        me.moveTo(move_tar[0],move_tar[1]);
        if (onstart_callback_trag==1){
            me.checkLocation();
        }
    },
    moveToEndEffect:function(option){
        option||(option={});
        var time=option.time?option.time:320;
        var onstart_callback_trag=option.onstart_callback_trag?option.onstart_callback_trag:1;
        var me=this;
        var dom=this.dom();
        $(dom).css({
            webkitTransitionProperty:"-webkit-transform,left,top",
            webkitTransitionDuration:time+"ms",
            webkitTransitionTimingFunction: "ease-out"
        }).one('webkitTransitionEnd',
            function(){
                $(dom).css({
                    webkitTransitionProperty:"none"
                });
                me.checkLocation();
            });
        me.moveToEnd();
        if (onstart_callback_trag==1){
            me.checkLocation();
        }
    }
};