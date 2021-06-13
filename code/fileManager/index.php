<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>小陈云盘</title>
    <link rel="stylesheet" href="./layui/css/layui.css">
    <link href="./contextMenu/bootstrap-combined.min.css" rel="stylesheet">
    <style>
        .bigger:hover {
            transform: scale(1.1, 1.1);
        }

        .filename {
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #filename:hover {
            overflow: auto;
        }

        * {
            margin: 0;
            padding: 0;
        }

        p {
            margin-top: 200px;
        }

        ul li {
            list-style-type: none;
            margin: 10px 0;
            text-align: center;
        }

        html {
            margin: 0px;
            padding: 0px;
            height: 100%;
        }

        body {
            margin: 0px;
            padding: 0px;
            height: 100%;
            background: url("./filePic/bg.jpg") no-repeat 0px 0px;
            background-size: cover;
            background-attachment: fixed;
            opacity: 0.7;
        }

        #menu {
            border: 1px solid #ccc;
            background: #eee;
            position: absolute;
            width: 80px;
            height: 70px;
            display: none;
        }
    </style>
    <script src="./layui/layui.js"></script>
    <script>
        var cur_path = <?php
                        session_start();
                        $home = $_SESSION['homePath'];
                        $local = $_GET['dir_name'];
                        $local = str_replace("home", $home, $local);
                        echo '"' . $local . '"';
                        ?>

        function create_dir() {
            layui.use(['layer', 'jquery'], function() {
                const $ = layui.jquery;
                layer.prompt({
                    formType: 2,
                    value: '新文件夹',
                    title: '请输入文件夹名',
                    area: ['200px', '50px'] //自定义文本域宽高
                }, function(value, index, elem) {
                    var _index = layer.load()
                    // alert(value); //得到value
                    $.ajax({
                        url: 'mkdir.php',
                        type: 'post',
                        data: {
                            "dir_name": cur_path + '/' + value
                        },
                        success: function(res) {
                            if (res.res == true) {
                                layer.msg("新建文件夹成功！");
                                location.reload();
                            } else
                                layer.msg(JSON.stringify(res.res));
                                layer.close(_index);
                        }
                        //…
                    });
                    layer.close(index);
                });

            });
        }

        function deleteFile(fileName) {
            var _index = layer.load()
            $.ajax({
                url: 'delete.php',
                type: 'post',
                data: {
                    "dir_name": cur_path + '/' + fileName
                },
                success: function(res) {
                    if (res.res == true) {
                        layer.msg("删除成功！");
                        location.reload();
                    } else
                        lay.msg(JSON.stringify(res.res));
                        layer.close(_index);
                }
                //…
            });
        }
    </script>
</head>

<body id="context2" data-toggle="context" data-target="#context-menu2">
    <blockquote class="layui-elem-quote">
        <i class="layui-icon layui-icon-prev" style="color: #009688;"><b><a href='javascript:history.back()' style="color:#009688;">上一级<a></b></i>&nbsp;
        <a href='index.php?dir_name=home' style="color:#009688;"><i class="layui-icon layui-icon-home" style="color: #009688;"><b>主页</b></i></a>&nbsp;
        <a href='javascript:changeSize(1)' style="color:#009688;"><i class="layui-icon layui-icon-add-circle" style="color: #009688;"><b>放大</b></i></a>&nbsp;
        <a href='javascript:changeSize(-1)' style="color:#009688;"><i class="layui-icon layui-icon-reduce-circle" style="color: #009688;"><b>缩小</b></i></a>
        <a href='handleLogin.php?exit=yes' style="color:#009688;"><i class="layui-icon layui-icon-logout" style="color: #009688;"><b>退出</b></i></a>
        <i class="layui-icon layui-icon-time " style="color: #009688;align:right"><b id='timer'></b></i>
        <span class="layui-badge-rim layui-bg-orange">
            <?php
            // var_dump($_GET);
            function get_device_type()
            {
               // return 'mobile';
                $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
                if (strpos($agent, 'iphone') || strpos($agent, 'ipad') || strpos($agent, 'android')) {
                    $type = 'mobile';
                } else {
                    $type = 'computer';
                }
                return $type;
            }
           
            if (!($_SESSION['login']==="true"))  echo '<script>location.href="login.html"</script>';

            echo '欢迎您，用户' . $_SESSION['userId'] . '!&nbsp;&nbsp;&nbsp;当前您所在的路径是：';


            $pic = array("php" => "php", "pdf" => "pdf", "txt" => "txt", "jpeg" => "pic");

            if (array_key_exists('dir_name', $_GET)) {
                echo $_GET['dir_name'] . '<br>';

            ?>
        </span>
    </blockquote>
    <div>
        <div class="layui-row layui-col-space15" id="ggg" style="padding: 20px;">
            <?php
                $local = $_GET['dir_name'];
                $local = str_replace("home", $home, $local);
                if (strpos($_GET['dir_name'], '.') === false && file_exists(@$local) && $_GET['dir_name'][0] != '/' && $_GET['dir_name'][0] != '\\') {
                    $dir = dir(@$local);
                    if (get_device_type() == 'computer') {
                        while ($item = $dir->read()) {
                            if ($item !== '.' && $item !== '..') {
                                echo '<div class="layui-col-md1 layui-col-xs3 bigger"><div class="layui-panel" align="center" value="' . $item . '" title="' . $item . '"><div style="padding: 30px;">';
                                $arr = explode('.', $item);
                                if (sizeof($arr) > 1) {
                                    echo '<a href="' . $local . '/' . $item . '" download="' . $item . '">';
                                    if (array_key_exists($arr[1], $pic)) {
                                        echo '<img src="./filePic/' . $pic[$arr[1]] . '.jpeg" width="100%">';
                                    } else {
                                        echo '<img src="./filePic/file.jpeg" width="100%">';
                                    }
                                    echo '</a>';
                                    echo '<div class="filename">' . $item . '</div>';
                                } else {

                                    echo '<a href="index.php?dir_name=' . $_GET['dir_name'] . '/' . $item . '">';
                                    echo '<img src="./filePic/dir.jpeg" width="100%"></a>';
                                    echo '<div class="filename">' . $item . '</div>';
                                }
                                echo '</div></div></div>';
                            }
                        }
                    } else {
            ?>
                    <div>
                        <table class="layui-table">
                            <colgroup>
                                <col width="80%">
                                <col width="10%">
                                <col width="10%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        文件名
                                    </td>
                                    <td>
                                        <button type="button" class="layui-btn layui-btn-primary layui-btn-fluid" onclick="document.getElementById('upload').click();"><i class="layui-icon layui-icon-upload"></i></button>
                                    </td>
                                    <td>
                                        <button type="button" class="layui-btn layui-btn-primary layui-btn-fluid" onclick="create_dir()"><i class="layui-icon layui-icon-add-1"></i></button>
                                    </td>
                                </tr>
                                <?php
                                while ($item = $dir->read()) {
                                    if ($item !== '.' && $item !== '..') {
                                        $arr = explode('.', $item);
                                        if (sizeof($arr) > 1) {
                                            echo '<tr><td><a href="' . $_GET['dir_name'] . '/' . $item . '" download="' . $item . '">';
                                            echo '<i class="layui-icon layui-icon-file"></i>';
                                            echo $item . '</a></td>';
                                        } else {
                                            echo '<tr><td><a href="index.php?dir_name=' . $_GET['dir_name'] . '/' . $item . '">';
                                            echo '<i class="layui-icon layui-icon-export"></i>';
                                            echo $item . '</a></td>';
                                        }
                                        echo '<td colspan="2"><button type="button" class="layui-btn layui-btn-fluid" onclick="deleteFile(\'' . $item . '\')"><i class="layui-icon layui-icon-delete"></i></button></td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
        <?php
                    }
                } else {
                    echo '<script>layer.msg("路径非法")</script>';
                }
            }
        ?>

        </div>
    </div>
    <div id="context-menu2">
        <ul class="dropdown-menu" role="menu">
            <li id='deleteBt' class="layui-hide"><a tabindex="-1" href="#">删除</a></li>
            <li><a tabindex="-1" href='javascript:document.getElementById("upload").click();'>上传文件</a></li>
            <li><a tabindex="-1" href='javascript:create_dir()'>新建文件夹</a></li>
         <?php if($_SESSION['userId']==='admin') echo '<li><a tabindex="-1" href="DB">管理用户信息</a></li>'; ?>
        </ul>
    </div>
    <form method="post" id="uploadForm" class="layui-hide" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="upload" id="upload" onchange="uploadFile()">
        <input type="text" name="path" value="<?php echo   $local;   ?>">
        <!-- <input type="submit" id="submitFile"> -->
    </form>
    <script src="./contextMenu/jquery-1.10.2.min.js"></script>
    <script src="./contextMenu/bootstrap-contextmenu.js"></script>
    <script>
        var currentSize = 1;
        getCurrentDate();
        $('#context-menu2').on('hidden.bs.context', function(e) {
            $("#deleteBt").attr("class", "layui-hide");
        });

        function uploadFile() {
            layui.use(['layer'],function(){
            var index = layer.load();
            var formData = new FormData($('#uploadForm')[0]);
            $.ajax({
                type: 'post',
                url: "upload.php", //上传文件的请求路径必须是绝对路劲
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
            }).success(function(data) {
                if (data.res == true) {
                    layer.msg('上传成功');
                    location.reload();
                } else
                    layer.msg(data.res);
                    layer.close(index);
            }).error(function() {
                alert("上传失败");
                layer.close(index);
            });
                
            });
        }

        function getCurrentDate() {
            var timeStr = '';
            var curDate = new Date();
            var curYear = curDate.getFullYear();
            var curMonth = curDate.getMonth() + 1; //获取当前月份(0-11,0代表1月)
            var curDay = curDate.getDate(); //获取当前日(1-31)
            var curHour = curDate.getHours(); //获取当前小时数(0-23)
            var curMinute = curDate.getMinutes(); // 获取当前分钟数(0-59)
            if (curHour < 10) curhour = '0' + curHour;
            if (curMinute < 10) curMinute = '0' + curMinute;
            timeStr = curYear + '/' + curMonth + '/' + curDay + '&nbsp' + curHour + ':' + curMinute;
            //$("#time").text(timeStr);
            document.getElementById("timer").innerHTML = timeStr;
        }

        function changeSize(num) {
            layui.use('jquery', function() {
                const $ = layui.jquery;
                $("#ggg").children('.layui-col-md' + currentSize).each(function() {
                    var text = $(this).attr('class');
                    currentSize = parseInt(text.charAt(12) + text.charAt(13)) + num;
                    if (currentSize == 0 || currentSize == 13) currentSize = 1;
                    $(this).attr('class', 'layui-col-md' + currentSize + ' bigger');
                })
            });
        }



        window.onload = function() {
            var aObj = document.getElementsByClassName("layui-panel");
            for (var i = 0; i < aObj.length; i++) {
                aObj[i].oncontextmenu = function() {
                    $("#deleteBt").attr("class", "");
                    var tmp = document.getElementById("context-menu2").children['0'].children['0'].children['0'];
                    if (this.getAttribute('value')) {
                        tmp.setAttribute("href", 'javascript:deleteFile("' + this.getAttribute('value') + '");');
                    }
                    return false;
                }
            }
            document.oncontextmenu = function() {
                return false;
            }
        }
    </script>
</body>

</html>