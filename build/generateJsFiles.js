var hogan = require('hogan.js');
var fs = require('fs');
var helper = require('./helper');
var lang_list = fs.readFileSync('../build/language.properties', "utf8").split(',');

process.chdir('../protected/');
helper.scanDir('./views',false,true).forEach(function(file){
	if(helper.isDir('./views/'+file) && file!='.' && file!='..'){
		generateJsFiles(file);
	}
});
console.log('finish generate js files.');

//从views文件夹的翻译视图中提取js文件妈呀
function generateJsFiles(dir){
	lang_list.forEach(function(lang){
		if(helper.isDir('./views/'+dir+'/'+lang)){
			helper.scanDir('./views/'+dir+'/'+lang,false,true).forEach(function(file){
				if(m = file.match(/(.*)\.php$/)){
					var res = jsExtract(fs.readFileSync('./views/'+dir+'/'+lang+'/'+file,'utf8'),'js/'+dir+'/'+m[1]+'.js','../'+lang+'/template/'+dir+'/'+m[1]+'.php');
					if(res[1]){
						var fd = fs.openSync('./views/'+dir+'/'+lang+'/'+file, 'w');
						fs.writeSync(fd, res[0])
						fs.closeSync(fd);
						helper.mkdir('../'+lang+'/js/'+dir);
						fd = fs.openSync('../'+lang+'/js/'+dir+'/'+m[1]+'.js', 'w');
						fs.writeSync(fd, res[1])
						fs.closeSync(fd);
					}
				}
			});
		}
	});
	function jsExtract(content,path,tpl_path){
		var m;
		if(m=content.match(/<script\s+type\s*=\s*\"text\/javascript\"\s*>\s*\/\/static([\s\S]*?)<\/script>/im)){
			tpl = fs.readFileSync(tpl_path,'utf8');
			js='template = new Hogan.Template();template.r ='+hogan.compile(tpl,{asString:true})+';\r\n'+m[1].trim();
			content=content.replace(/<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/template([\s\S]*?)<\/script>\s*<script\s+type\s*=\s*"text\/javascript"\s*>\s*\/\/static([\s\S]*?)<\/script>/i,'<script type="text/javascript" src="<?=$this->url("'+path+'")?>"></script>');
			if(js.indexOf('<?')!==-1){
				console.log('jsExtract fail');
				process.exit;
			}
		}else{
			js=false;
		}
		return [content,js];
	}
}


// var tpl_str = hogan.compile('<div>{{test}}</div>',{asString:true});

// fs.open("tpl.js","w",0644,function(e,fd){
//     if(e) throw e;
//     fs.write(fd,tpl_str,0,'utf8',function(e){
//         if(e) throw e;
//         fs.closeSync(fd);
// 		console.log('created js file.');
//     })
// });
// var tpl = fs.readFileSync('./tpl.js', "utf8");
// var template = new Hogan.Template();
// 	template.r = tpl;
// var params = {test:'test'};
// var html = template.render(params);
// console.log(html);