<?php
$c = new mysqli('localhost','root','','cuti_db');
$r = $c->query('SELECT title,url FROM user_sub_menu WHERE menu_id=3 OR menu_id=2 OR menu_id=1 OR menu_id=4 OR menu_id=5');
while($row = $r->fetch_assoc()){
    echo json_encode($row) . "\n";
}
