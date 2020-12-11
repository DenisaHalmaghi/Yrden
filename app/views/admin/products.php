<form action="./" class='mb-1 mx-auto  w-md-6 ' autocomplete="off" method='GET'>
  <input name="url" type="text" value="admin/getProducts" hidden>
  <label for="prod">Product:</label>

  <div id='prod' class="input centeredRow space-between mx-auto mb-1">
    <input name="Product" type="text" value="<?php echo $data['product']; ?>">
    <i class="fas fa-search"></i>
  </div>
  <div class='mb-1'>
    <label for="cat">Category:</label>
    <select name="CategoryID" id="cat" class='select w-12'>
      <?php echo $viewUtil->buildOptions($data['categories'], $data['category'], "Category") ?>
    </select>
  </div>

  <button type='submit' class='btn btn-primary btn--small mx-auto'><span>Filter </span><i
       class="fas fa-filter"></i></button>

</form>

<?php
while ($product = mysql_fetch_array($data['products'])) {
  $url = PRODUCTS_URL . $product['Image'];
  $id = $product['ID'];
  $name = $product['Product'];
  $l = "<a href='./?url=admin/deleteProduct/$id' class='btn btn--xsmall btn-primary'><i class='fas fa-trash'></i></a>";
  if ($product['Deleted']) {
    $l = "<a href='./?url=admin/restoreProduct/$id' class='btn btn--xsmall btn-primary'><i class='fas fa-trash-restore'></i></a>";
  }
  echo "
        <div class=' centeredRow borderBottom product'>
            <a href='./?url=admin/product/$id'><img src='$url' alt='$name'></a>
            <div class='product__details'>
                <p>$name</p>
                <p class=''>$${product['Price']}</p>
                <ul class='centeredRow icon_holder'>
                    <li> <a href='./?url=admin/updateProduct/$id' class='btn btn--xsmall btn-primary'><i class='fas fa-pen'></i></a>
                    </li>
                    <li>$l</li>
                </ul>
            </div>
        </div>";
}
