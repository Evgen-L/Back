<link rel="stylesheet" type="text/css" href="styles.css" />
<form id= "form" action="GetRequire.php" method="POST">
    <select name="limit"  onchange="this.form.submit()"> 
            <option value="10" <?= (isset($_POST['limit']) && $_POST['limit'] == "10") ? "selected" : "" ?>>10</option>
            <option value="20" <?= (isset($_POST['limit']) && $_POST['limit'] == "20") ? "selected" : "" ?>>20</option>
            <option value="30" <?= (isset($_POST['limit']) && $_POST['limit'] == "30") ? "selected" : "" ?>> 30 </option>
            <option value="40" <?= (isset($_POST['limit']) && $_POST['limit'] == "40") ? "selected" : "" ?>> 40 </option>
            <option value="50" <?= (isset($_POST['limit']) && $_POST['limit'] == "50") ? "selected" : "" ?>> 50 </option>
    </select>

    <input type="text" name="id_task" value=<?=isset($_POST['id_task']) ? $_POST['id_task'] : ''?> >
    <input type="text" name="description" value=<?=isset($_POST['description']) ? $_POST['description'] : ''?> >
    <input type="text" name="date_start" value=<?=isset($_POST['date_start']) ? $_POST['date_start'] : ''?> >
    <input type="text" name="date_end" value=<?=isset($_POST['date_end']) ? $_POST['date_end'] : ''?> >
    <input type="text" name="priority" value=<?=isset($_POST['priority']) ? $_POST['priority'] : ''?> >
    <input type="submit" name= "search" value="search">

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
    function GetDBSize(&$con, $whereCause)
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
    $limit = (isset($_POST['limit']) ? $_POST['limit'] : 10); 
    $page = (isset($_POST['page']) ? $_POST['page'] : 1);          
     $start = $limit * ($page - 1);
?>



<?php         
        if (isset($_POST['id_task']) && !empty($_POST['id_task']))
        {
            $params[] = 'id_task = '.$_POST['id_task'].'';
        }
        if (isset($_POST['description']) && !empty($_POST['description']) )
        {
            $params[] = 'description = \''.$_POST['description'].'\'';
        }
        if (isset($_POST['date_start']) && !empty($_POST['date_start']))
        {
            $params[] = 'date_start = \''.$_POST['date_start'].'\'';
        }
        if (isset($_POST['date_end']) && !empty($_POST['date_end']))
        {
            $params[] = 'date_end = \''.$_POST['date_end'].'\'';
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
        
        $total_results = GetDBSize($con, $whereCause);
        $total_pages = ceil($total_results/$limit); 

        $sort_by = (isset($_POST['sort_by']) ? $_POST['sort_by'] : "id_task");
        
        if(isset($_POST['type_sort']))
            $type_sort = $_POST['type_sort'];
        else
            $type_sort = "ASC";
            
        $query = 'SELECT * FROM lw4T '.$whereCause.' ORDER BY '.$sort_by.' '.$type_sort.' OFFSET '.$start.' ROWS FETCH NEXT '.$limit.' ROWS ONLY';
        

        $request = $con->prepare($query);
        $request->execute();
        $result = $request->fetchAll();

   
?>
 
<table class = "bordered">
<?php foreach($result as $value): ?>
    <tr>
        <td><?= $value['id_task'] ?></td>
        <td><?= $value['description'] ?></td>
        <td><?= $value['date_start'] ?></td>
        <td><?= $value['date_end'] ?></td>
        <td><?= $value['priority'] ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php for($i = 1; $i <= $total_pages; $i++): ?>
    <button name="page" value=<?= $i ?> type="submit" form= "form" ><?= $i ?></button> 
<?php endfor; ?>

<div class="space">
    Страница: <?=$page?>
</div>