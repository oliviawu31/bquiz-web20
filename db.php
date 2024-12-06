<?php

    // 定義一個 DB 類別來處理資料庫操作
    // 假設抽到20號
class DB{
     // 資料庫的資料來源名稱（DSN），包括了主機名稱、編碼以及資料庫名稱
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db20";
    protected $pdo;
    protected $table;

    // 類別的建構式參數，它會在實例化物件時執行
    function __construct($table){
        // $pdo 是用來建立與資料庫的連線物件
        $this->table = $table;
        //$pdo 是用來儲存資料庫連線的 PDO 實例
        $this->pdo = new PDO($this->dsn,'root','');
    }

    /**
     * 方便使用個個聚合函式
     * 
     */
    protected function math($math,$col='id',$where=[]){
        $sql="SELECT $math(`$col`) FROM $this->table";
        if(!empty($where)){
            $tmp=$this->A2s($where);
            $sql=$sql. " WHERE ". join(" && ", $tmp);
        }
        return $this->pdo->query($sql)->fetchColum();

    }




    /**
     * 撈出全部資料 
     * 1.整張資料表
     * 2.有條件
     * 3.其他SQL功能
     */

    // function all(){
    //     $sql="SELECT * FROM $this->table ";
    // return $this->q("SELECT * FROM $this->table");

    // all() =>用來查詢資料表中的所有資料
    // ...$arg =>不定參數，這個方法可以接受不同數量的參數
   
   //1.撈出所有資料
    function all(...$arg){
        $sql="SELECT * FROM $this->table ";

    // 如果傳入的第一個參數 $arg[0] 不是空的，會根據這個參數來修改 SQL 查詢。
    // 如果 $arg[0] 是陣列，表示你傳入的是查詢條件，這時會調用 a2s() 方法將它轉換成 WHERE 子句。
    // 如果 $arg[0] 是字串，則直接將這個字串附加到 SQL 查詢中（例如，"ORDER BY id DESC"）
        if(!empty($arg[0])){
            if(is_array($arg[0])){
                $where=$this->a2s($arg[0]);
                $sql=$sql . " WHERE ". join(" && ",$where);
            }else{
                //$sql=$sql.$arg[0];
                $sql .= $arg[0];
            }
        }

        return $this->fetchAll($sql);
    }

    // 2.只撈出一筆資料
    function find($id){
        $sql="SELECT * FROM $this->table ";

            if(is_array($id)){
                $where=$this->a2s($id);
                $sql=$sql . " WHERE ". join(" && ",$where);
            }else{
                $sql .=  " WHERE `id`='$id' ";
            }

        return $this->fetchOne($sql);
    }

    //3.刪除
    function del($id){
        $sql="DELETE FROM $this->table ";

            if(is_array($id)){
                $where=$this->a2s($id);
                $sql=$sql . " WHERE ". join(" && ",$where);
            }else{
                $sql .=  " WHERE `id`='$id' ";
            }
            echo $sql;  
            return $this->pdo->exec($sql);
    }

    //4. save

    function save($array){
        if(isset($array['id'])){
            //update
            // update table set `欄位1`='值1',`欄位2`='欄位2' where `id`='值'
            // 因為新增裡無法有id，所以用unset刪掉
            $id=$array['id'];
            unset($array['id']);
            $set=$this->a2s($array);
            $sql ="UPDATE $this->table SET ".join(',',$set)." where `id`='$id'";
                
        }else{
            //insert
            $cols=array_keys($array);
            $sql="INSERT INTO $this->table (`".join("`,`",$cols)."`) VALUES('".join("','",$array)."')";

        }
    
        echo $sql;
        return $this->pdo->exec($sql);
    }


    // 將陣列轉成條件字串陣列
    // a2s => array to string

    function a2s($array){
        $tmp=[];


        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        return $tmp;
    }

    function fetchOne($sql){
        // echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function fetchAll($sql){
        // echo $sql
        return $this->pdo->query($sql)->fetchALL(PDO::FETCH_ASSOC);
    }

    // function q($sql){
    //     return $this->pdo->query($sql)->fetchALL();
    // }



}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo"</pre>";
}

$DEPT=new DB('dept');

// $dept=$DEPT->q("SELECT * FROM dept");

// 1.如果是要撈全部資料時
// $dept=$DEPT->all(" Order by `id` DESC ");
//2.只要找單一筆資料時
$dept=$DEPT->find(['code'=>'401']);
//3.刪除
// $DEPT->del(2);
// $DEPT->del(['code'=>'401']);

// //如果有id 就無法新增 
// $DEPT->save(['code'=>'504','id'=>'7','name'=>'資訊發展部']);
// dd($dept);


echo $DEPT->math('max','id',['code'=>'503']);

?>