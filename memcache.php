<?php
    $memcache = new Memcache;
    $memcache->connect('localhost', 11211);
    $query = "select * from test";
    $key = md5($query);
    echo $key;
    if(!$memcache->get($key)){
       $link = mysql_connect('localhost:/tmp/mysql.sock', 'root', '12345678');
       mysql_select_db('test', $link);
       $result = mysql_query($query);
       while ($row = mysql_fetch_assoc($result)) {
                 $arr[] = $row;
                 #echo $arr[1];
       }     
       $flag = 'mysql';
       #memcache_set($memcache,$key,serialize($arr),0,30);
       $memcache->add($key,serialize($arr),0,30);
       $data = $arr;
       #mysql_close($link);
    }
    else {
       $flag = 'memcache';
       $data_mem = $memcache->get($key);
       $data = unserialize($data_mem);
    }
    echo $flag;
    echo "<br>";
    foreach($data as $a){
       echo "number is <b><font color=#FF0000>$a[id]</font></b>";
       echo "name is <b><font color=#FF0000>$a[name]</font></b>";
    }
