
<?php include __DIR__ . '/../header.php'; ?>


<h1><?= $article->getName() ?></h1>
<p><?= $article->getText() ?></p>
<hr>
<a href='/articles/<?= $article->getId();?>/edit'>Редактировать</a>
&nbsp;
<a href='/articles/<?= $article->getId();?>/delete'>Удалить</a>
<p>Автор: <?= $article->getAuthor()->getNickName(); ?></p>



<?php include __DIR__ . '/../footer.php'; ?>

