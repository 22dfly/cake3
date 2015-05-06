<?= $this->Html->link(
    'All post',
    '/posts/index',
    ['class' => 'button']
); ?>

<?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('Edit Post') ?></legend>
        <?= $this->Form->input('title') ?>
        <?= $this->Form->input('content', ['rows' => 3]) ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
