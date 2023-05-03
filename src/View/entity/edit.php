<?php include_once('../partials/header.php'); ?>

<div class="container mt-5">
    <h2>Edit Entity</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="id" value="<?php echo $entity->id; ?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $entity->title; ?>">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea class="form-control" name="content"><?php echo $entity->content; ?></textarea>
        </div>
        <div class="form-group">
            <label>Author</label>
            <select class="form-control" name="author_id">
                <?php while ($row = $authors->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $row['id']; ?>"
                    <?php if ($row['id'] == $entity->author_id) echo "selected"; ?>><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<?php include_once('../partials/footer.php'); ?>