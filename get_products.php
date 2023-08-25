<?php
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);
    $productos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }
?>