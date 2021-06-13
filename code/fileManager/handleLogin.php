 <?php
    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('./DB/test.db');
        }
    }
    if (isset($_GET["exit"])) {
        session_start();
        if (isset($_SESSION['login'])) {
            unset($_SESSION['login']);
        }
        header('Location: login.html');
    } else {
        $db = new MyDB();
        if (!$db) {
            echo $db->lastErrorMsg();
        } else {
            echo "Opened database successfully\n";
        }
        $sql = 'SELECT * FROM user where userId="' . $_POST["name"] . '" and pwd="' . $_POST["pwd"] . '"';

        $ret = $db->query($sql);
        if($row = $ret->fetchArray(SQLITE3_ASSOC))
        {
            //var_dump($row);
            session_start();
            $_SESSION['login'] = "true";
            $_SESSION['userId'] = $row["userId"];
            $_SESSION['homePath'] = $row["homePath"];
            header('Location: index.php?dir_name=home');
        }
        else 
        {
            $db->close();
            echo "登录失败!<br>正在跳转回登陆页面....";
            header("refresh:3;url=login.html");
        }
        $db->close();
       
    }
    ?>