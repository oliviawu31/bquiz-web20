<?php
include_once "db.php";

$table=$_POST['table'];
// ucfirst => 變成大寫
$db=ucfirst($table);

// 先判斷del有沒有存在
if(isset($_POST['id'])){
    foreach($_POST['id'] as $idx => $id){
        if(isset($_POST['del']) && in_array($id,$_POST['del'])){
            // $$ => 可變變量
            $$db->del($id);
        }else{
            $row=$$db->find($id);
            switch($table){
                case"title";
            $row['sh']=(isset($_POST['sh']) && $_POST['sh']==$id)?1:0;
            $row['text']=$_POST['text'][$idx];

            break;
        case "admin":
            $row['acc']=$_POST['acc'][$idx];
            $row['pw']=$_POST['pw'][$idx];
            break;
        case"menu":
            $row['text']=$_POST['text'][$idx];
            $row['href']=$_POST['href'][$idx];
            // 多選用陣列表示
            $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;

            break;
        default:

        $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;
        if(isset($_POST['text'])){
            $row['text']=$_POST['text'][$idx];
        }

        }
        $$db->save($row);
        }
    }
}

to("../admin.php?do=$table");

?>