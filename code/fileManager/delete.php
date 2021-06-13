 <?php
    // echo $_POST['path'];
    // echo $_POST['path'];
    //设置需要删除的文件夹
    //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
    function deldir($dir)
    {
        //先删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
        //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
    //调用函数，传入路径
    header('Content-Type:application/json; charset=utf-8');
    $arr = array();
    if (file_exists($_POST['dir_name'])) {
        if (is_dir($_POST['dir_name'])) {
            $arr['res'] = deldir($_POST['dir_name']);
        } else
            $arr['res'] = unlink($_POST['dir_name']);
    } else
        $arr['res'] = '不存在该文件或文件夹！';
    exit(json_encode($arr)); 
    ?>