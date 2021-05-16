<link rel="stylesheet" type="text/css" href="styles.css" />
<form id= "form" action="" method="POST">
<select name="quantity_entries"  onchange="this.form.submit()"> 
         <option value="10" <?= (isset($_POST['quantity_entries']) && $_POST['quantity_entries'] == "10") ? "selected" : "" ?>>10</option>
         <option value="20" <?= (isset($_POST['quantity_entries']) && $_POST['quantity_entries'] == "20") ? "selected" : "" ?>>20</option>
		 <option value="30" <?= (isset($_POST['quantity_entries']) && $_POST['quantity_entries'] == "30") ? "selected" : "" ?>> 30 </option>
		 <option value="40" <?= (isset($_POST['quantity_entries']) && $_POST['quantity_entries'] == "40") ? "selected" : "" ?>> 40 </option>
         <option value="50" <?= (isset($_POST['quantity_entries']) && $_POST['quantity_entries'] == "50") ? "selected" : "" ?>> 50 </option>
</select>

</form>





<?php
    $con = new PDO('sqlsrv:Server=DESKTOP-1RV149P\SQLEXPRESS;Database=Lw3DB', NULL, NULL);
    function GetBDSize(&$DBH)
    {
        $query = 'SELECT COUNT(*) FROM lw3T';
        $STH = $DBH->prepare($query);
        $STH->execute();
        $STH->setFetchMode(PDO::FETCH_NUM);
        $args = $STH->fetchAll();
        return $args[0][0];
    }

?>



    
   
    
    
    <?php $total_results = GetBDSize($con) ?>
    <?php $quantity_entries = (isset($_POST['quantity_entries']) ? $_POST['quantity_entries'] : 10) ?>
    <?php $total_pages = ceil($total_results/$quantity_entries); ?>
    <?php $page = (isset($_POST['page']) ? $_POST['page'] : 1) ?>
    
    <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <button name="page" value=<?= $i ?> type="submit" form="form" ><?= $i ?></button>
    <?php endfor;?>
    <?php echo $page ?>
    <?php $start = $quantity_entries * ($page - 1) ?>
    <?php $end = $start +  $quantity_entries?>
    <?php $query = 'SELECT * FROM lw3T ORDER BY id_task OFFSET '.$start.' ROWS FETCH NEXT '.$quantity_entries.' ROWS ONLY'; ?>
    <?php $request = $con->prepare($query); ?>
    <?php $request->execute() ?>
    <?php $result = $request->fetchAll() ?>

    

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
