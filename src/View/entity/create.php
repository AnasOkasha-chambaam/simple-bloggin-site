<?php include_once(__DIR__.'/../header.php') ?>

<h2>Create a new entity</h2>

<form method="POST" action="<?php echo $base_url ?>/entity/store">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" required>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" name="content" rows="10" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<?php include_once(__DIR__.'/../footer.php') ?>