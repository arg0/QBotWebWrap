<?php
function pstatus($pid){
    $command = 'ps -p '.$pid;
    exec($command,$op);
    if (!isset($op[1])) return false;
    else return true;
}
require_once('function/sqllink.php');
if(!isset($_POST['id'])) die('{"retcode":999,"msg":"CAN NOT FIND ID IN THE PARAMETER"}');
$link=sqllink();
if(!$link) die('{"retcode":99,"msg":"DATABASE ERROR"}');
$res=sqlexec('SELECT * FROM `process` where `sid`=?',array($_POST['id']),$link);
$result=$res->fetch(PDO::FETCH_ASSOC);
if ($result==FALSE)  die('{"retcode":0,"msg":"SUCC"}'); //don't tell malicious person the id does not exist
if(pstatus($result['pid'])) shell_exec("kill ".$result['pid']);
die('{"retcode":0,"msg":"SUCC"}');
?>
