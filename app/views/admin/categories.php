
<?php

while ($category = mysql_fetch_array($data['categories'])) {
    $id = $category['ID'];
    $name = $category['Category'];
    $l = "<a href='./?url=admin/deleteProduct/$id' class='btn btn--xsmall btn-primary'><i class='fas fa-trash'></i></a>";
    if ($product['Deleted']) {
        $l = "<a href='./?url=admin/restoreProduct/$id' class='btn btn--xsmall btn-primary'><i class='fas fa-trash-restore'></i></a>";
    }
    echo "
        <div class=' centeredRow borderBottom product space-between mx-auto w-10'>
            <span>$name</span>
            <div class='centeredRow icon_holder'>
            <a href='./?url=admin/updateCategory/$id' class='btn btn--small btn-primary'><i class='fas fa-pen'></i></a>
            <a href='./?url=admin/deleteCategory/$id' class='btn btn--small btn-primary'><i class='fas fa-trash'></i></a>
            </div>
            
           
        </div>";
}
//print_r($data['products']);
