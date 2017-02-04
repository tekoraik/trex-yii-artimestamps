# trex-yii-artimestamps
Timestamps created_at and updated_at with date format for ActiveRecord

<h1>Instalation</h1>

Via composer:
<pre>
composer require trex/yii-artimestamps
</pre>

or add this lines in your composer.json:

<pre>
"trex/yii-artimestamps": "*"
</pre>


<h1>Usage</h1>
<p>1. Add a create column and update column in your table</p>
<p>2. Add the behavior in your ActiveRecord</p>
<pre>
public function behaviors()
{
    return [
        "timestamp" => [
            "class" => \trex\yii\artimestamps\TimestampBehavior::className(),
            "createdAtField" => {{ my create field }},
            "updatedAtField" => {{ my update field }},
        ]
    ];
}
</pre>
