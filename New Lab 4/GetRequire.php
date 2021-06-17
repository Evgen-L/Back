<link rel="stylesheet" type="text/css" href="styles.css" />
<form id= "form" action="GetRequire.php" method="POST"  class = "forma">
    limit:<select name="limit" onchange="this.form.submit()"> 
                <option value="10" <?= (isset($_POST['limit']) && $_POST['limit'] == "10") ? "selected" : "" ?>>10</option>
                <option value="20" <?= (isset($_POST['limit']) && $_POST['limit'] == "20") ? "selected" : "" ?>>20</option>
                <option value="30" <?= (isset($_POST['limit']) && $_POST['limit'] == "30") ? "selected" : "" ?>> 30 </option>
                <option value="40" <?= (isset($_POST['limit']) && $_POST['limit'] == "40") ? "selected" : "" ?>> 40 </option>
                <option value="50" <?= (isset($_POST['limit']) && $_POST['limit'] == "50") ? "selected" : "" ?>> 50 </option>
    </select>

    id:<input type="text" class = "id_task" name="id_task" value="<?=isset($_POST['id_task']) ? $_POST['id_task'] : ''?>" >
    description:<input type="text" name="description" value="<?=isset($_POST['description']) ? $_POST['description'] : ''?>" >
    date_start:<input type="text" name="date_start" value="<?=isset($_POST['date_start']) ? $_POST['date_start'] : ''?>" >
    date_end:<input type="text" name="date_end" value="<?=isset($_POST['date_end']) ? $_POST['date_end'] : ''?>" >
    priority:<select name="priority"> 
            <option value=""    <?= (isset($_POST['priority']) && $_POST['priority' ] == "")   ? "selected" : "" ?>> None </option>        
            <option value="A"     <?= (isset($_POST['priority']) && $_POST['priority'] == "A")     ? "selected" : "" ?>>A</option>
            <option value="B" <?= (isset($_POST['priority']) && $_POST['priority'] == "B") ? "selected" : "" ?>>B</option>
            <option value="C"  <?= (isset($_POST['priority']) && $_POST['priority'] == "C")  ? "selected" : "" ?>> C </option>
            <option value="D"    <?= (isset($_POST['priority']) && $_POST['priority'] == "D")    ? "selected" : "" ?>> D </option>
            <option value="E"    <?= (isset($_POST['priority']) && $_POST['priority' ] == "E")   ? "selected" : "" ?>> E </option>
    </select>
    
    <input type="submit" class="search" name="search" value="search">

    <select name="sort_by"  onchange="this.form.submit()"> 
            <option value="id_task"     <?= (isset($_POST['sort_by']) && $_POST['sort_by'] == "id_task")     ? "selected" : "" ?>>id</option>
            <option value="description" <?= (isset($_POST['sort_by']) && $_POST['sort_by'] == "description") ? "selected" : "" ?>>description</option>
            <option value="date_start"  <?= (isset($_POST['sort_by']) && $_POST['sort_by'] == "date_start")  ? "selected" : "" ?>> date start </option>
            <option value="date_end"    <?= (isset($_POST['sort_by']) && $_POST['sort_by'] == "date_end")    ? "selected" : "" ?>> date end </option>
            <option value="priority"    <?= (isset($_POST['sort_by']) && $_POST['sort_by' ] == "priority")   ? "selected" : "" ?>> priority </option>
    </select>


    <select name="type_sort"  onchange="this.form.submit()"> 
            <option value="ASC" <?= (isset($_POST['type_sort']) && $_POST['type_sort'] == "ASC") ? "selected" : "" ?>>ascending</option>
            <option value="DESC" <?= (isset($_POST['type_sort']) && $_POST['type_sort'] == "DESC") ? "selected" : "" ?>>descending</option>
    </select>

</form>



<?php
    $con = new PDO('sqlsrv:Server=DESKTOP-1RV149P\SQLEXPRESS;Database=Lw4DB', NULL, NULL);
    function POSTDBSize(&$con, $whereCause)
    {
        $query = 'SELECT COUNT(*) FROM lw4T '.$whereCause;
        $request = $con->prepare($query);
        $request->execute();
        $request->setFetchMode(PDO::FETCH_NUM);
        $args = $request->fetchAll();
        return $args[0][0];
    }
?>







<?php         
        if (isset($_POST['id_task']) && !empty($_POST['id_task']))
        {
            $params[] = 'id_task = \''.trim($_POST['id_task']).'\'';
        }
        if (isset($_POST['description']) && !empty($_POST['description']) )
        {
            $str = 'description LIKE \'%'.trim($_POST['description']).'%\'';
            $str = preg_replace('/\s+/', ' ', $str);
            $params[] = $str;

        }
        if (isset($_POST['date_start']) && !empty($_POST['date_start']))
        {
            $params[] = 'date_start = \''.strval(trim($_POST['date_start'])).'\'';
        }
        if (isset($_POST['date_end']) && !empty($_POST['date_end']))
        {
            $params[] = 'date_end = \''.strval(trim($_POST['date_end'])).'\'';
        }
        if (isset($_POST['priority']) && !empty($_POST['priority']))
        {
            $params[] = 'priority = \''.$_POST['priority'].'\'';
        }
        $whereCause = 'WHERE ';
        if(!empty($params))
        {
            $whereCause .= implode($params, ' AND ');
        }
        else
        {
            $whereCause = '';
        }
        

        $limit = (isset($_POST['limit']) && ($_POST['limit'] == 10 
                                            || $_POST['limit'] == 20 
                                            || $_POST['limit'] == 30 
                                            || $_POST['limit'] == 40    
                                            || $_POST['limit'] == 50) ? $_POST['limit'] : 10); 
        if(!is_numeric($limit))
        {
            $limit = 10;
        }
        else
        {
            $limit = ABS($limit);
        }

        $total_results = POSTDBSize($con, $whereCause);
        $total_pages = ceil($total_results/$limit); 

        $page = (isset($_POST['page']) ? $_POST['page'] : 1); 
        if(!is_numeric($page))
            {
                $page = 1;
            }
            else 
            {
                if (ABS($page) > $total_pages)
                {
                    $page = 1;
                }
                else
                {
                    $page = ABS($page);
                }
            }        
        
        $start = $limit * ($page - 1);


        if (isset($_POST['sort_by']))
        {
            if ($_POST['sort_by'] == "id" || $_POST['sort_by'] == "description" || $_POST['sort_by'] == "date_start" || $_POST['sort_by'] == "date_end" || $_POST['sort_by'] == "priority")
            {
                $sort_by = $_POST['sort_by']; 
            }
            else
            {
                $sort_by = "id_task";
            }
        } 
        else 
        {
            $sort_by = "id_task";
        }

        if (isset($_POST['type_sort']))
        {
            if ($_POST['type_sort'] == "ASC" || $_POST['type_sort'] == "DESC" )
            {
                $type_sort = $_POST['type_sort']; 
            }
            else
            {
                $type_sort = "ASC";
            }
        } 
        else 
        {
            $type_sort = "ASC";
        }
        
            
        $query = 'SELECT * FROM lw4T '.$whereCause.' ORDER BY '.$sort_by.' '.$type_sort.' OFFSET '.$start.' ROWS FETCH NEXT '.$limit.' ROWS ONLY';
       

        $request = $con->prepare($query);
        $request->execute();
        $result = $request->fetchAll();

   
?>

<?php if($total_results > 0): ?>
    <table class = "bordered">
    <?php foreach($result as $value): ?>
        <tr>
            <td><?= $value['id_task']     ?></td>
            <td><?= $value['description'] ?></td>
            <td><?= $value['date_start']  ?></td>
            <td><?= $value['date_end']    ?></td>
            <td><?= $value['priority']    ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

    <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <button name="page" value=<?= $i ?> type="submit" form= "form" ><?= $i ?></button> 
    <?php endfor; ?>      

    <div class="space">
        Страница: <?=$page?>
    </div>
<?php endif; ?>




