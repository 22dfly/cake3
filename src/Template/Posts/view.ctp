<?= $this->Html->link(
    'All post',
    '/posts/index',
    ['class' => 'button']
); ?>

<fieldset>
    <legend><?= h($post->title) ?></legend>
    <?= h($post->content) ?>
</fieldset>
