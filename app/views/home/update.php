<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 19:31
 */

use app\models\Task;
use app\models\Status;

/** @var $task array */
/** @var $model Task */

?>
<h1>Update task #<?=$task['id']?> (<?=$task['username']?>)</h1>
<br><br>
<div class="row">
    <div class="col">
        <form action="/home/update/<?=$task['id']?>" method="post" accept-charset="UTF-8" id="formCreate">
            <div class="form-check">
                <input <?=$task['status_id'] == Status::STATUS_FINISHED ? 'checked="checked"' : ''?> name="status_id" value="<?=Status::STATUS_FINISHED?>" class="form-check-input" type="checkbox" id="status">
                <label class="form-check-label" for="status">
                    Finished
                </label>
            </div>
            <div class="form-group">
                <label for="text">Text</label>
                <textarea class="form-control" name="text" id="text" rows="6"><?=$task['text']?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Save</button>
        </form>
    </div>
</div>
