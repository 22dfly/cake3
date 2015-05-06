<?= $this->Html->link(
    'Add post',
    '/posts/add',
    ['class' => 'button']
); ?>

<h3>All Posts</h3>

<table>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

<!-- Here's where we iterate through our $articles query object, printing out article info -->

<?php foreach ($posts as $post): ?>
    <tr>
        <td>
            <?= $this->Html->link($post->title, ['action' => 'view', $post->id]) ?>
        </td>
        <td>
            <?= h($post->content) ?>
        </td>
        <td>
            <?= $post->created->timeAgoInWords() ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $post->id]) ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>
