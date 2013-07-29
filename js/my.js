(function() {
    var initializing = false,
        fnTest = /xyz/.test(function() {
            xyz
        }) ? /\b_super\b/ : /.*/;
    this.Class = function() {};
    Class.extend = function(prop) {
        var _super = this.prototype;
        initializing = true;
        var prototype = new this;
        initializing = false;
        for (var name in prop) prototype[name] = typeof prop[name] == "function" && typeof _super[name] == "function" && fnTest.test(prop[name]) ? function(name, fn) {
            return function() {
                var tmp = this._super;
                this._super = _super[name];
                var ret = fn.apply(this, arguments);
                this._super = tmp;
                return ret
            }
        }(name, prop[name]) :
            prop[name];

        function Class() {
            if (!initializing && this.init) this.init.apply(this, arguments)
        }
        Class.prototype = prototype;
        Class.prototype.constructor = Class;
        Class.extend = arguments.callee;
        return Class
    }
})();

var EventUtil = {
    addHandler: function(element, type, handler) {
        if (element.addEventListener) element.addEventListener(type, handler, false);
        else if (element.attachEvent) element.attachEvent("on" + type, handler);
        else element["on" + type] = handler
    },
    removeHandler: function(element, type, handler) {
        if (element.removeEventListener) element.removeEventListener(type, handler, false);
        else if (element.datachEvent) element.datachEvent("on" + type, handler);
        else element["on" + type] = null
    },
    getEvent: function(event) {
        return event ? event : window.event
    },
    getTarget: function(event) {
        return event.target || event.srcElement
    },
    preventDefault: function(event) {
        if (event.preventDefault) event.preventDefault();
        else event.returnValue = false
    },
    stopPropagation: function() {
        if (event.stopPropagation) event.stopPropagation();
        else event.cancelBubble = true
    }
};

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
        alert(error?error:'数据载入出错！');
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
    var ret;
    if(a){
        ret = BASEURI+'/'+c+'/'+a+'?';
        if(p){
            for(var k in p){
                ret += encodeURIComponent(k)+'='+encodeURIComponent(p[k])+'&';
            }
        }
    }else{
        ret = BASEURI+'/'+c;
    }
    return ret;
}

var State = {
    forward:function(c,a,p){
        location.href = getUrl(c,a,p);
    }
}
