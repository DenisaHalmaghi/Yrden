<form action="./?url=admin/<?php echo $data['operation']; ?>Category/<?php echo $data['id'] ?>" method='POST'>
    <?php
    //echo $_SESSION['data']['result'];
    if (isset($_SESSION['data']['result'])) {
        echo "<p class='uppercase c-prm ta-c bold' >" . $_SESSION['data']['result'] . "</p>";
    }
    // print_r($_SESSION['data']);
    ?>
    <div class="form__input w-12">
        <label for="cat">Category:</label>
        <input type="text" id="cat" class='input' name="Category" <?php $viewUtil->printInputData('Category'); ?>>
        <?php $viewUtil->printError('cat'); ?>
    </div>

    <button type='submit' class="btn btn-primary w-12"><?php echo $data['operation']; ?></button>
    
</form>