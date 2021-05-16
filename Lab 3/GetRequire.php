<link rel="stylesheet" type="text/css" href="styles.css" />
<form id= "form" action="" method="POST">
<select name="limit"  onchange="this.form.submit()"> 
         <option value="10" <?= (isset($_POST['limit']) && $_POST['limit'] == "10") ? "selected" : "" ?>>10</option>
         <option value="20" <?= (isset($_POST['limit']) && $_POST['limit'] == "20") ? "selected" : "" ?>>20</option>
		 <option value="30" <?= (isset($_POST['limit']) && $_POST['limit'] == "30") ? "selected" : "" ?>> 30 </option>
		 <option value="40" <?= (isset($_POST['limit']) && $_POST['limit'] == "40") ? "selected" : "" ?>> 40 </option>
         <option value="50" <?= (isset($_POST['limit']) && $_POST['limit'] == "50") ? "selected" : "" ?>> 50 </option>
</select>
</form>


<?php
    $con = new PDO('sqlsrv:Server=DESKTOP-1RV149P\SQLEXPRESS;Database=Lw3DB', NULL, NULL);
    function GetDBSize(&$con)
    {
        $query = 'SELECT COUNT(*) FROM lw3T';
        $request = $con->prepare($query);
        $request->execute();
        $request->setFetchMode(PDO::FETCH_NUM);
        $args = $request->fetchAll();
        return $args[0][0];
    }
    $total_results = GetDBSize($con);
    $limit = (isset($_POST['limit']) ? $_POST['limit'] : 10); 
    $total_pages = ceil($total_results/$limit); 
    $page = (isset($_POST['page']) ? $_POST['page'] : 1); 
?>

<div class="space">
    Страница: <?=$page?>
</div>

<?php for($i = 1; $i <= $total_pages; $i++): ?>
    <button name="page" value=<?= $i ?> type="submit" form="form" ><?= $i ?></button> 
<?php endfor; ?>

    
<?php         
    
     $start = $limit * ($page - 1);
     $end = $start +  $limit;
     $query = 'SELECT * FROM lw3T ORDER BY id_task OFFSET '.$start.' ROWS FETCH NEXT '.$limit.' ROWS ONLY'; 
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


