<!-- project/src/View/entity/index.php -->


<div class="row">
    <div class="col-md-12">
        <h1>All Blog Posts</h1>
        <a class="btn btn-success" href="/entity/create">Create New Post</a>
    </div>
</div>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="col-md-4">
        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo substr($row['content'], 0, 50); ?>...</p>
        <p>Created on <?php echo date('F j, Y', strtotime($row['created_at'])); ?> by <?php echo $row['author_name']; ?>
        </p>
        <a class="btn btn-primary" href="/entity/view/<?php echo $row['id']; ?>">Read More</a>
    </div>
    <?php } ?>
</div>

<!-- <?php
//  include(ROOT_PATH . "/src/View/includes/header.php");
  ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <h1 class="my-4">All Posts</h1>
            <?php 
            // foreach ($entities as $entity):
             ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title"><?php 
                    // echo $entity['title'];
                     ?></h2>
                    <p class="card-text"><?php 
                    // echo $entity['content'];
                     ?></p>
                    <a href="<?php
                    //  echo BASE_URL . '/entity/show.php?id=' . $entity['id'];
                      ?>"
                        class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on <?php
                    //  echo date('F jS, Y', strtotime($entity['created_at'])); 
                     ?> by
                    <?php
                    //  echo $entity['author_name'];
                      ?>
                </div>
            </div>
            <?php 
        // endforeach;
         ?>
        </div>
    </div>
</div>

<?php
//  include(ROOT_PATH . "/src/View/includes/footer.php"); 
 ?> -->