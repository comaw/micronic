<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 21:31
 */

use app\models\Admin;

/** @var $model Admin */
/** @var $post array */

?>
<h1>Sign In</h1>
<?php if ($model->error) { ?>
<p class="text-danger"><?=$model->error?></p>
<?php } ?>
<form action="" method="post" accept-charset="UTF-8" id="form-login">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" name="username" value="<?=$post['username'] ?? null?>" class="form-control" id="login" placeholder="Enter login">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Sign In</button>
</form>
