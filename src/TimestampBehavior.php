<?php

namespace trex\yii\artimestamps;

use yii\db\ActiveRecord;
use yii\base\Behavior;

class TimestampBehavior extends Behavior
{
    public $createdAtField = 'created_at';
    public $updatedAtField = 'updated_at';

    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'initEvent',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function initEvent($event)
    {
        $this->owner->{$this->createdAtField} = date('Y-m-d H:i:s');
        $this->owner->{$this->updatedAtField} = date('Y-m-d H:i:s');
    }

    public function beforeInsert($event)
    {
        $this->owner->{$this->createdAtField} = date('Y-m-d H:i:s');
        $this->owner->{$this->updatedAtField} = date('Y-m-d H:i:s');
    }

    public function beforeUpdate($event)
    {
        $this->owner->{$this->updatedAtField} = date('Y-m-d H:i:s');
    }
}
