<?php

namespace trex\yii\artimestamps;

use trex\yii\artimestamps\TimestampBehavior;
use app\_data\ar\Client;
use app\_data\ar\Product;

function date($format, $time = '')
{
    TimestampBehaviorTest::$dateCalls[] = func_get_args();
    TimestampBehaviorTest::$dateCallsCounter++;

    $result = TimestampBehaviorTest::$date;
    return $result;
}

class TimestampBehaviorTest extends \Codeception\Test\Unit
{
    public static $lastDateCall;
    public static $dateCalls = [];
    public static $dateCallsCounter = 0;
    public static $date = 'now';
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function setUp()
    {
        parent::setUp();
        $this->resetDateFunction();
    }

    public function resetDateFunction()
    {
        TimestampBehaviorTest::$dateCalls = [];
        TimestampBehaviorTest::$dateCallsCounter = 0;
        TimestampBehaviorTest::$date = 'now';
    }

    public function testCreated_atAndUpdated_atOnActiveRecordConstruct()
    {
        $client = new Client;

        expect($client->created_at)->notNull();
        expect($client->updated_at)->notNull();
        expect($client->created_at)->equals('now');
        expect(self::$dateCallsCounter)->equals(2);
        expect(self::$dateCalls[0][0])->equals('Y-m-d H:i:s');
        expect($client->updated_at)->notNull('now');
        expect(self::$dateCalls[1][0])->equals('Y-m-d H:i:s');


    }

    public function testFormat()
    {
        $client = new Product;

        expect($client->createdAt)->notNull();
        expect($client->updatedAt)->notNull();

        expect(self::$dateCalls[0][0])->equals('Y/d/m H,i,s');
    }


    public function testCreated_atAndUpdated_atWhenIsSaved()
    {
        TimestampBehaviorTest::$date = 'nowbefore';
        $client = new Client;

        expect($client->created_at)->equals('nowbefore');
        expect($client->updated_at)->equals('nowbefore');

        TimestampBehaviorTest::$date = '2017-01-01 01:02:03';
        $client->name = 'Test name';
        expect($client->save())->true();
        expect($client->id)->notEmpty();
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-01 01:02:03');

        //has been saved correctly?
        $client = Client::findOne($client->id);
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-01 01:02:03');

        //a date at the future
        TimestampBehaviorTest::$date = '2017-01-02 04:05:06';
        expect($client->save())->true();
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-02 04:05:06');

        //has been saved correctly?
        $client = Client::findOne($client->id);
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-02 04:05:06');
    }
}
