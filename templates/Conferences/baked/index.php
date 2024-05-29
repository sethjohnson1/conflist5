<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Conference> $conferences
 */
?>
<div class="conferences index content">
    <?= $this->Html->link(__('New Conference'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Conferences') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('edit_key') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('institution') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('meeting_type') ?></th>
                    <th><?= $this->Paginator->sort('subject_area') ?></th>
                    <th><?= $this->Paginator->sort('homepage') ?></th>
                    <th><?= $this->Paginator->sort('contact_name') ?></th>
                    <th><?= $this->Paginator->sort('contact_email') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conferences as $conference): ?>
                <tr>
                    <td><?= $this->Number->format($conference->id) ?></td>
                    <td><?= h($conference->edit_key) ?></td>
                    <td><?= h($conference->title) ?></td>
                    <td><?= h($conference->start_date) ?></td>
                    <td><?= h($conference->end_date) ?></td>
                    <td><?= h($conference->institution) ?></td>
                    <td><?= h($conference->city) ?></td>
                    <td><?= h($conference->country) ?></td>
                    <td><?= h($conference->meeting_type) ?></td>
                    <td><?= h($conference->subject_area) ?></td>
                    <td><?= h($conference->homepage) ?></td>
                    <td><?= h($conference->contact_name) ?></td>
                    <td><?= h($conference->contact_email) ?></td>
                    <td><?= h($conference->created) ?></td>
                    <td><?= h($conference->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $conference->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $conference->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $conference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conference->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
