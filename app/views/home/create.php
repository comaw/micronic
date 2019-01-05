<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 19:31
 */


?>
<h1>Create task</h1>
<div class="row">
    <div class="col">
        <form action="/home/create" method="post" accept-charset="UTF-8" id="formCreate">
            <div class="form-group">
                <label for="username">Name</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <label for="text">Text</label>
                <textarea class="form-control" name="text" id="text" rows="6"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Create</button>
            <button type="button" class="btn btn-light mb-2" id="formReset">Reset</button>
        </form>
    </div>
</div>
