<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link href="../../css/base.css" rel="stylesheet" type="text/css" />
	<link href="../../css/page.css" rel="stylesheet" type="text/css" />
	<title><?=$this->pageTile?></title>
	<script src="../../js/jquery-1.9.0.min.js" type="text/javascript"></script>
	<script src="../../js/my.js" type="text/javascript"></script>
	<script type="text/javascript">
		var STIME = <?=getTime();?>;
		var CTIME = new Date().getTime();
		var BASEURL = <?=json_encode(Yi::app()->baseUrl)?>;
		var BASEURI = <?=json_encode(Yi::app()->baseUri)?>;
		$(function(){
			$('.jsto_home').click(function(){
				State.forward('Main','Main');
			});
		});
	</script>
</head>
<body>
	<div class="pw m0a head">
		<h1 class="jsto_home">sidney</h1>
		<div>
			<a href="<?=Yi::app()->url('Main','Tools')?>">web开发工具</a>
		</div>
	</div>
	<div id="maindiv" class="pw m0a page">
		<?=$content?>
	</div>
	<div class="pw msa foot ac">
		<p>Copyright © 2013-<?=date('Y')?> SidneyYi All Rights Reserved</p>
	</div>
</body>
