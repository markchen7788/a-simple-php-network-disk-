 <?php
    header('Content-Type:application/json; charset=utf-8');
    $arr = array();
    if (!$_FILES['upload']['error']) {
        if ($_FILES['upload']['size'] < 3200000) { //文件传到文件夹中，可以拼接时间戳，用户名等防止文件名重复
            $file_name = $_POST['path'] . '/' . $_FILES['upload']['name'];
            if (!file_exists($file_name)) {
                move_uploaded_file($_FILES['upload']['tmp_name'], $file_name);
                $arr['res']=true;
                //                $filename=iconv("UTF-8","",$file_name);
            } else {
                $arr['res']='文件名重复！';
            }
        } else {
            $arr['res']='文件过大！';
        }
    } else {
        $arr['res']='上传失败！';
    }
    exit(json_encode($arr)); 
    ?>