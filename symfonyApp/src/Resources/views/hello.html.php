<?php $view->extend('layout.html.php') ?>
<?php $view['slots']->set('title', 'Welcome Page') ?>

<h1>Hello <?php echo $firstName . ' ' . $lastName?></h1>
<div>
    Welcome to this page
    <br>
    <a href="http://localhost:4567/test">Go to test page</a>
</  </br>
</div>