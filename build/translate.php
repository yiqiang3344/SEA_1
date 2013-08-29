<?php
$lang_list = explode(',', file_get_contents('../build/language.properties'));
// 翻译
chdir("../translator");
require_once 'run.php';