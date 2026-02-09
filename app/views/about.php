<?php $this->layout('layout', ['title' => 'About Page']) ?>

<?php use function Tamtamchik\SimpleFlash\flash; ?>

<?= flash()->display(); ?>

<h1>About page</h1>
<p><?=$this->e($name)?></p>