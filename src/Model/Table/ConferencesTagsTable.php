<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConferencesTags Model
 *
 * @property \App\Model\Table\ConferencesTable&\Cake\ORM\Association\BelongsTo $Conferences
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\ConferencesTag newEmptyEntity()
 * @method \App\Model\Entity\ConferencesTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ConferencesTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConferencesTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ConferencesTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ConferencesTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ConferencesTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConferencesTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ConferencesTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ConferencesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConferencesTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConferencesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConferencesTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConferencesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConferencesTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ConferencesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ConferencesTag> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ConferencesTagsTable extends Table
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

        $this->setTable('conferences_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
            ->integer('conference_id')
            ->allowEmptyString('conference_id');

        $validator
            ->integer('tag_id')
            ->allowEmptyString('tag_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['conference_id'], 'Conferences'), ['errorField' => 'conference_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}
