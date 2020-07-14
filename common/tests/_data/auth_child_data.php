<?php
$auth_item_child = [

    ["parent" => "praktikantTask",
     "child"  => "user-stamm.login",],
    ["parent" => "customerManager",
     "child"  => "praktikantTask",],
    ["parent" => "customerManager",
     "child"  => "customerTask",],
    ["parent" => "admin",
     "child"  => "*.*",],

];
return $auth_item_child;
?>