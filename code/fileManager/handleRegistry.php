 <?php
    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('./DB/test.db');
        }
    }

    $db = new MyDB();
    if (!$db) {
        echo $db->lastErrorMsg();
    } else {
        echo "Opened database successfully\n";
    }
    $sql = 'INSERT INTO user (userId,pwd,homePath) VALUES ("' . $_POST["name"] . '","' . $_POST["pwd"] . '","home/'.$_POST["name"].'")';

    $ret = $db->exec($sql);
    if ($ret) {
        mkdir('home/'. $_POST["name"]);
        echo "<script>alert('注册成功!')</script>";
    } else {
        echo "<script>alert('注册失败!')</script>";
    }
    $db->close();
    echo "<script>window.location='./login.html'</script>";
    ?>
