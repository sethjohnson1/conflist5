<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Conference $conference
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $conference->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $conference->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Conferences'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="conferences form content">
            <?= $this->Form->create($conference) ?>
            <fieldset>
                <legend><?= __('Edit Conference') ?></legend>
                <?php
                    echo $this->Form->control('edit_key');
                    echo $this->Form->control('title');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('end_date', ['empty' => true]);
                    echo $this->Form->control('institution');
                    echo $this->Form->control('city');
                    echo $this->Form->control('country');
                    echo $this->Form->control('meeting_type');
                    echo $this->Form->control('subject_area');
                    echo $this->Form->control('homepage');
                    echo $this->Form->control('contact_name');
                    echo $this->Form->control('contact_email');
                    echo $this->Form->control('description');
                    echo $this->Form->control('tags._ids', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
