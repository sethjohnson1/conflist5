<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conference Entity
 *
 * @property int $id
 * @property string|null $edit_key
 * @property string|null $title
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $end_date
 * @property string|null $institution
 * @property string|null $city
 * @property string|null $country
 * @property string|null $meeting_type
 * @property string|null $subject_area
 * @property string|null $homepage
 * @property string|null $contact_name
 * @property string|null $contact_email
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Tag[] $tags
 */
class Conference extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'edit_key' => true,
        'title' => true,
        'start_date' => true,
        'end_date' => true,
        'institution' => true,
        'city' => true,
        'country' => true,
        'meeting_type' => true,
        'subject_area' => true,
        'homepage' => true,
        'contact_name' => true,
        'contact_email' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'tags' => true,
    ];
}
