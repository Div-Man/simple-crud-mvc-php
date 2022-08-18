<?php include __DIR__ . '/../header.php'; ?>
<h2>Список статей</h2>

   <?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
    <p><?= $article->getText() ?></p>
    <p>Дата: <?= $article->getData();?></p>
    <hr>

<?php endforeach; ?>


<?php if(!empty($articles)): ?>

<div style="text-align: center">
    <?php foreach($pagination->get() as $page): ?>
        <?php echo $page;?>
    <?php endforeach;?>
        
</div>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>

