<?php
/**
 * TimestampBehavior class file
 */

namespace trex\yii\artimestamps;

use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 * TimestampBehavior class
 *
 * This behavior adds a creation and update timestamps in the Active Record
 * when it is created, inserted and updated.
 *
 * <h4>Usage</h4>
 * 1. Add a create column and update column in your table
 *
 * 2. Add the behavior in your ActiveRecord
 * <pre>
 * public function behaviors()
 * {
 *     return [
 *         "timestamp" => [
 *             "class" => \trex\yii\artimestamps\TimestampBehavior::className(),
 *             "createdAtField" => {{ my create field }},
 *             "updatedAtField" => {{ my update field }},
 *         ]
 *     ];
 * }
 * </pre>
 * @author Jose Luis Orta <infoluis85@gmail.com>
 */
class TimestampBehavior extends Behavior
{
    /**
     * Field that represents the creation time in the ActiveRecord
     *
     * @var string
     */
    public $createdAtField = 'created_at';

    /**
     * Field that represents the update time in the ActiveRecord
     *
     * @var string
     */
    public $updatedAtField = 'updated_at';

    /**
     * Timestamps format
     *
     * @var string
     */
    public $format = 'Y-m-d H:i:s';

    /**
     * Events definition
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'initEvent',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * Init event handler
     *
     * This method is executed after the owner class is initialized.
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#EVENT_INIT-detail
     *
     * @param  yii\base\Event $event
     */
    public function initEvent()
    {
        $this->owner->{$this->createdAtField} = date($this->format);
        $this->owner->{$this->updatedAtField} = date($this->format);
    }

    /**
     * Insert event handler
     *
     * This method is executed after the active record is inserted.
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#EVENT_BEFORE_INSERT-detail
     *
     * @param  yii\base\Event $event
     */
    public function beforeInsert()
    {
        $this->owner->{$this->createdAtField} = date($this->format);
        $this->owner->{$this->updatedAtField} = date($this->format);
    }

    /**
     * Update event handler
     *
     * This method is executed after the active record is updated.
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#EVENT_BEFORE_UPDATE-detail
     *
     * @param  yii\base\Event $event
     */
    public function beforeUpdate()
    {
        $this->owner->{$this->updatedAtField} = date($this->format);
    }
}
