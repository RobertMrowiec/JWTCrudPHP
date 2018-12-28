<?php
    function checkRecordExists($connection, $query) {
        $checkStmt = $connection->prepare($query);
        $checkStmt->execute(); 
        $num = $checkStmt->rowCount();
        if ($num > 0) return 0;
        return 1;
    }
?>
