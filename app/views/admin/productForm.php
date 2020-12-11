<form action="./?url=admin/<?php echo $data['operation']; ?>Product/<?php echo $data['id'] ?>" method='POST'>
    <?php
   echo $_SESSION['data']['result'];
    if (isset($_SESSION['data']['result'])) {
        echo "<p class='uppercase c-prm ta-c bold' >".$_SESSION['data']['result']."</p>";
    }
   // print_r($_SESSION['data']);
    ?>
    <div class="form__input w-12">
        <label for="cat">Category:</label>
        <select class='select' name="CategoryID" id="cat">
            <?php echo $viewUtil->buildOptions($data['categories'], $viewUtil->checkIfDataExists('CategoryID'), "Category") ?>
        </select>

        <?php $viewUtil->printError('category'); ?>
    </div>

    <div class="form__input w-12">
        <label for="prod">Product Name:</label>
        <input type="text" id="prod" class='input' name="Product" <?php $viewUtil->printInputData('Product'); ?>>
        <?php $viewUtil->printError('product'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Price">Price:</label>
        <input type="number" id="Price" min=0 class='input' name="Price" <?php $viewUtil->printInputData('Price'); ?>>
        <?php $viewUtil->printError('price'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Qty">Quantity:</label>
        <input type="number" id="Qty" min=0 class='input' name="Qty" <?php $viewUtil->printInputData('Qty'); ?>>
        <?php $viewUtil->printError('qty'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Discount">Discount:</label>
        <input type="number" min=0 max=100 id="Discount" class='input' name="Discount" <?php $viewUtil->printInputData('Discount'); ?>>
        <?php $viewUtil->printError('discount'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Image">Image:</label>
        <input type="text" id="Image" class='input' placeholder="x-y_z.png" name="Image" <?php $viewUtil->printInputData('Image'); ?>>
        <?php $viewUtil->printError('image'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Dimensions">Dimensions:</label>
        <input type="text" id="prod" class='input' name="Dimensions" placeholder="30x30x30" <?php $viewUtil->printInputData('Dimensions'); ?>>
        <?php $viewUtil->printError('dimensions'); ?>
    </div>

    <div class="form__input w-12">
        <label for="Description">Description:</label>
        <textarea type="text" id="Description" class='textarea' rows=10 name="Description"><?php echo $viewUtil->checkIfDataExists('Description'); ?>
        </textarea>
        <?php $viewUtil->printError('description'); ?>
    </div>
    <button type='submit' class="btn btn-primary w-12"><?php echo $data['operation']; ?></button>
</form>