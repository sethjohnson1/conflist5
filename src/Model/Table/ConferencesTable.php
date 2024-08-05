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
            ->notEmptyDate('start_date','Please supply a valid date.');

        $validator
            ->date('end_date')
            ->notEmptyDate('end_date','Please supply a valid date.');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->notEmptyString('city','Please add this location information.');

        $validator
            ->scalar('country')
            ->maxLength('country', 100)
            ->notEmptyString('country');

        $url_validation_error="Please enter a valid URL, including https:// or http://";
        $validator
            ->notEmptyString('homepage',$url_validation_error)
            ->maxLength('homepage', 400)
            ->urlWithProtocol('homepage',$url_validation_error);

        $validator
            ->scalar('institution')
            ->maxLength('institution', 100)
            ->allowEmptyString('institution');

        $validator
            ->scalar('meeting_type')
            ->maxLength('meeting_type', 100)
            ->allowEmptyString('meeting_type');

        $validator
            ->scalar('subject_area')
            ->maxLength('subject_area', 100)
            ->allowEmptyString('subject_area');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 100)
            ->allowEmptyString('contact_name');

        $email_validation_error='Please provide a valid email. It will not be publicly visible.';
        $validator
            ->setStopOnFailure(true)
            ->notEmptyString('contact_email',$email_validation_error)
            ->maxLength('contact_email', 100)
            //2nd param verifies host exists, seems to work for oddball TLDs and ones with no website (checks MX DNS?)
            ->email('contact_email',true,$email_validation_error);

        $validator
            ->scalar('description')
            ->allowEmptyString('description');


        /* I don't think this has any effect, and I have tried everything I can think of like Tag, Tags, tag, tags, tag[_ids]
        $validator
            ->scalar('tag')
            ->notEmptyArray('tag','Please select at least one tag!')
            //->allowEmptyArray(false)
            ->hasAtleast('tag',1,'Please select at least one tag!!');
            //->add('Tag','needSome',['rule'=>['hasAtLeast','tags',1,'Please select at least one tag.'],'message'=>'Please select at least one tag.']);*/

        return $validator;
    }

    public function beforeSave(\Cake\Event\EventInterface $event, \Cake\Datasource\EntityInterface $entity, \ArrayObject $options){
        if (!$entity->edit_key){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
            $rando=substr( str_shuffle( $chars ), 0, 8);
            $entity->set('edit_key',$rando);
        }
        //no special handling for dates debug($entity) and you can see they are already Cake date objects
        return;
   
    }
}
