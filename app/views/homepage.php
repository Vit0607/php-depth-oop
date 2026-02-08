<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>
<p>Hello, <?=$this->e($name)?></p>

<?php foreach($postsInView as $post): ?>
<?php echo $post['title'] . '<br>'; ?>
<?php endforeach; ?>