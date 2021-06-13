 <?php
// echo $_POST['path'];
// echo $_POST['path'];
header('Content-Type:application/json; charset=utf-8');
 $arr = array();
 if(file_exists($_POST['dir_name']))
 $arr['res']='已存在该文件夹！';
 else
 $arr['res']=mkdir($_POST['dir_name']);
 exit(json_encode($arr)); 
?>