<div class="di"
    style="height:540px; border:#999 1px solid; width:76.5%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
    <!--正中央-->
    <?php include_once "logout.php";?>
    <div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
        <p class="t cent botli">管理者帳號管理</p>
        <form method="post" action="./api/edit_<?=$do;?>.php">
            <table width="100%">
                <tbody>
                    <tr class="yel">
                        <td width="45%">帳號</td>
                        <td width="45%">密碼</td>
                        <td width="10%">刪除</td>
                    </tr>
                    <?php
                    $rows=$Admin->all();
                    foreach($rows as $row){
                        // 不一定要做**
                        //保護管理者帳號
                        // if($row['acc']!='admin')
                    ?>
                    <tr>
                        <!-- [] =>表示多筆資料 -->
                        <td>
                            <input type="text" name="acc[]" value="<?=$row['acc'];?>">
                        </td>
                        <td>
                            <input type="password" name="pw[]" value="<?=$row['pw'];?>">
                        </td>
                        <td>
                            <input type="checkbox" name="del[]" value="<?=$row['id'];?>">
                        </td>

                        <!-- 因為須給對應刪除的欄位有一個id -->
                        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <table style="margin-top:40px; width:70%;">
                <tbody>
                    <tr>
                        <td width="200px">
                            <input type="button"
                                onclick="op(&#39;#cover&#39;,&#39;#cvr&#39;,&#39;./modal/<?=$do;?>.php?table=<?=$do;?>&#39;)"
                                value="新增管理者帳號管理">
                        </td>
                        <td class="cent">
                            <input type="submit" value="修改確定">
                            <input type="reset" value="重置">
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
</div>