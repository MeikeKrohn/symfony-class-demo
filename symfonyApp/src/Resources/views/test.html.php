<?php $view->extend('layout.html.php') ?>
<?php $view['slots']->set('title', 'Only testing here') ?>

<h1>Testing</h1>
<div>
    This is a test page
    <br>
        <a href="http://localhost:4567/hello">Go to Hello Page</a>
    </br>

    <?php
    for($i = 0; $i < count($data); $i ++)
    {
        echo "<p>" . $data[$i] . "</p>";
    }
    ?>

</div>