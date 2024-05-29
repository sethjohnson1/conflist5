<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conferences Model
 *
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Conference newEmptyEntity()
 * @method \App\Model\Entity\Conference newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Conference> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Conference get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Conference findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Conference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Conference> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Conference|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Conference saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Conference>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conference>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conference>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conference> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conference>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conference>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conference>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conference> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConferencesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('conferences');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Tags', [
            'foreignKey' => 'conference_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'conferences_tags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('edit_key')
            ->maxLength('edit_key', 10)
            ->allowEmptyString('edit_key');

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->notEmptyString('title','Title is required');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->scalar('institution')
            ->maxLength('institution', 100)
            ->allowEmptyString('institution');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->allowEmptyString('city');

        $validator
            ->scalar('country')
            ->maxLength('country', 100)
            ->allowEmptyString('country');

        $validator
            ->scalar('meeting_type')
            ->maxLength('meeting_type', 100)
            ->allowEmptyString('meeting_type');

        $validator
            ->scalar('subject_area')
            ->maxLength('subject_area', 100)
            ->allowEmptyString('subject_area');

        $validator
            ->scalar('homepage')
            ->maxLength('homepage', 400)
            ->allowEmptyString('homepage');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 100)
            ->allowEmptyString('contact_name');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 100)
            ->allowEmptyString('contact_email');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }
}
