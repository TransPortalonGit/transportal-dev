<?php
    $mysql = new mysqli('localhost','root','kodin','transportal', 3306);
    $result = $mysql->query("select * from users");
    $rows = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $rows[] = array_map("utf8_encode", $row);
    }
    echo json_encode($rows);
    $result->close();
    $mysql->close();

?>