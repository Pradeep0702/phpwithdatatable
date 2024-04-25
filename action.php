<?php

include_once "config.php";
$select = "select * from datatable_demo ";
$select2 = "select * from datatable_demo ";
$age = $_GET["age"];
$search = $_GET["search"];
if (
    isset($_GET["age"]) &&
    !empty($_GET["age"]) &&
    isset($_GET["search"]) &&
    !empty($_GET["search"])
) {
    $select .= " Where name like '%$search%' ";
    $select .= " AND age=$age ";
} else {
    if (!empty($_GET["age"]) && isset($_GET["age"])) {
        $select .= " Where age=$age ";
    }
    if (!empty($_GET["search"]) && isset($_GET["search"])) {
        $select .= " Where name like '%$search%' ";
        $select .= " OR age like '%$search%' ";
    }

    if (
        !empty($_GET["length"]) && isset($_GET["length"]) or
        !empty($_GET["start"]) && isset($_GET["start"])
    ) {
        $start = $_GET["start"];
        $length = $_GET["length"];
        $select .= "  limit $start , $length ";
    }
}

$query = $config->prepare($select);
$query->execute();
$query2 = $config->prepare($select2);
$query2->execute();
$recordsTotal = $query2->rowCount();

if ($_GET["age"] or $_GET["search"]) {
    $recordsFiltered = $query->rowCount();
} else {
    $recordsFiltered = $query2->rowCount();
}

$datas = $query->fetchAll(PDO::FETCH_ASSOC);
$newdata = [];
foreach ($datas as $data) {
    $newdata[] = [
        "id" => $data["id"],
        "name" => $data["name"],
        "age" => $data["age"],
        "action" =>
            '<a class="btn btn-success" href="'.$data["id"].'">Edit</a>
		    <a class="btn btn-danger" href="'.$data["id"].'">Delete</a>',
    ];
}

echo json_encode([
    "draw" => intval($_GET["draw"]),
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => $newdata,
]);
