<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 18:29
 */

use core\App;
use app\helpers\StatusHelper;
use app\helpers\Url;

/** @var $tasks mixed[] */
/** @var $counts int */
/** @var $page int */
/** @var $sort string|int */

$user = App::init()->auth->getUserAuth();

?>
<h1>List of tasks</h1>
<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered table-hover">
            <thead  class="thead-light">
            <tr>
                <th scope="col"><a href="/?<?=Url::createSort('id', $sort)?>">#</a></th>
                <th scope="col"><a href="/?<?=Url::createSort('status_id', $sort)?>">Status</a></th>
                <th scope="col"><a href="/?<?=Url::createSort('username', $sort)?>">Name</a></th>
                <th scope="col"><a href="/?<?=Url::createSort('email', $sort)?>">Email</a></th>
                <th scope="col">Text</th>
                <th scope="col">Created</th>
                <th scope="col">Updated</th>
                <?php if ($user) { ?>
                    <th scope="col"> </th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <th scope="row"><?=$task['id']?></th>
                <td><img src="<?=StatusHelper::getImage($task['status_id'])?>" alt="<?=StatusHelper::getStatusName($task['status_id'])?>" style="max-width: 40px;" title="<?=StatusHelper::getStatusName($task['status_id'])?>"></td>
                <td><?=$task['username']?></td>
                <td><?=$task['email']?></td>
                <td><?=nl2br($task['text'])?></td>
                <td><?=$task['create_at']?></td>
                <td><?=$task['update_at']?></td>
                <?php if ($user) { ?>
                    <td><a href="/home/update/<?=$task['id']?>" class="btn btn-success btn-sm" title="Update">Update</a></td>
                <?php } ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col">
                <ul class="pagination">
                    <li class="page-item<?=$page <= 1 ? ' disabled' : ''?>">
                        <a class="page-link" href="/<?=Url::createPrevious($sort, $page)?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $counts; $i++) { ?>
                        <li class="page-item<?=$page == $i ? ' active' : ''?>">
                            <a class="page-link" href="/<?=Url::createList($sort, $i)?>"><?=$i?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item<?=$page >= $counts ? ' disabled' : ''?>">
                        <a class="page-link" href="/<?=Url::createNext($sort, $page)?>">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
