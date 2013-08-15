<?php
chdir('../');
require('protected/includes/functions.inc.php');
fwrite(STDOUT, 'please input the path of images:');
// get input
$path = trim(fgets(STDIN));
mergePngs($path);
echo 'finish! please to see the merge.png in the path,and the merge.txt record some useful infomation.';