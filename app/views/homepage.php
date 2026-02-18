<?php $this->layout('layout', ['title' => 'Posts']) ?>

<h1>Posts</h1>
<!-- <p>Hello, <?=$this->e($name)?></p> -->

<?php foreach($postsInView as $post): ?>
<?php echo $post['title'] . '<br>'; ?>
<?php endforeach; ?>