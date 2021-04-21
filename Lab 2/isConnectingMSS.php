
<link rel="stylesheet" type="text/css" href="styles.css" />
<?php
    try 
    {
        
            $con = new PDO('sqlsrv:Server=DESKTOP-9JUV7U6\SQLEXPRESS;Database=Lw2DB', NULL, NULL);
            $request = $con->prepare('SELECT * FROM lw2T');
            $request->execute();

            
    }
    catch (PDOException $e)
    {
        echo "Suka?";
        return $e;
    }
    ?>
<table class = "bordered">
    
   
    <?php while($row = $request->fetch()): ?>
        <tr>
            <td><?= $row['id_task'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['date_start'] ?></td>
            <td><?= $row['date_end'] ?></td>
            <td><?= $row['priority'] ?></td> 
        </tr>
    <?php endwhile; ?>    
</table>

