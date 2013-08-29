var fs = require('fs');

//判断是不是目录
exports.isDir = isDir =  function(path){
  var ret = false;
  if(fs.existsSync(path) && fs.lstatSync(path).isDirectory()){
    ret = true;
  }
  return ret;
}

//判断是不是文件
exports.isFile = isFile =  function(path){
  var ret = false;
  if(fs.existsSync(path) && fs.lstatSync(path).isFile()){
    ret = true;
  }
  return ret;
}

//遍历目录返回文件及目录列表 递归则返回文件列表
exports.scanDir = scanDir =  function(root,recursive,subPath){
  var arg = arguments;
  recursive = recursive || false;
  subPath = subPath || false;
  var res = [];
  fs.readdirSync(root).forEach(function(file){
    var pathname = root+'/'+file;
    if(file=="." || file==".." || file==".svn"){
      return;
    }else if(recursive && isDir(pathname)){
      res = res.concat(arg.callee(pathname));
    }else{
        res.push(subPath?file:pathname);
    }
  });
  return res;
}

//判断是否在数组中
exports.inArray = inArray = function(str,arr){
  var res = false;
  arr.forEach(function(v){
    if(v==str){
      res = true;
      return;
    }
  });
  return res;
}

//获取父目录
exports.dealPath = dealPath = function(path){
  if(!/^[\.|\/]/.test(path)){
    path = './'+path;
  }
  return path;
}
exports.parentDir = parentDir = function(path){
  path = dealPath(path);
  var parent_dir = path.substring(path.lastIndexOf('/'),-1);
  if(inArray(parent_dir,[''])){
    parent_dir = '/';
  }
  return parent_dir;
}

// 创建目录
exports.mkdir = mkdir = function(dirpath, mode, callback) {
  dirpath = dealPath(dirpath);
  mode = mode || 755;
  callback = callback || function(){};

  //如果上级目录存在则创建当前目录
  if(isDir(parentDir(dirpath))){
    isDir(dirpath) || fs.mkdirSync(dirpath, mode);
    callback();
    return true;
  }

  //递归创建父目录,传入回调函数
  arguments.callee(parentDir(dirpath), mode, function(){
      fs.mkdirSync(dirpath, mode);
      callback();
  });
};