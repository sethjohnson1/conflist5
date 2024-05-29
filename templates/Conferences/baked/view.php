<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Conference $conference
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Conference'), ['action' => 'edit', $conference->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Conference'), ['action' => 'delete', $conference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conference->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Conferences'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Conference'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="conferences view content">
            <h3><?= h($conference->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Edit Key') ?></th>
                    <td><?= h($conference->edit_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($conference->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Institution') ?></th>
                    <td><?= h($conference->institution) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($conference->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($conference->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Meeting Type') ?></th>
                    <td><?= h($conference->meeting_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject Area') ?></th>
                    <td><?= h($conference->subject_area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Homepage') ?></th>
                    <td><?= h($conference->homepage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Name') ?></th>
                    <td><?= h($conference->contact_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Email') ?></th>
                    <td><?= h($conference->contact_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($conference->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($conference->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($conference->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($conference->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($conference->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($conference->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Tags') ?></h4>
                <?php if (!empty($conference->tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($conference->tags as $tag) : ?>
                        <tr>
                            <td><?= h($tag->id) ?></td>
                            <td><?= h($tag->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tag->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tag->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
