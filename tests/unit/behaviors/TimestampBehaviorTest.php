<?php

namespace trex\yii\artimestamps;

use trex\yii\artimestamps\TimestampBehavior;
use app\_data\ar\Client;

function date($format, $time = '')
{
    TimestampBehaviorTest::$dateCalls[] = func_get_args();
    TimestampBehaviorTest::$dateCallsCounter++;

    if ($format = 'Y-m-d H:i:s' && empty($time)) {
        $result = TimestampBehaviorTest::$now;
    } else {
        if (empty($time)) {
            $time = \time();
        }
        $result = \date($format, $time);
    }
    return $result;
}

class TimestampBehaviorTest extends \Codeception\Test\Unit
{
    public static $lastDateCall;
    public static $dateCalls = [];
    public static $dateCallsCounter = 0;
    public static $now = 'now';
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function setUp()
    {
        parent::setUp();

    }

    public function resetDateFunction()
    {
        TimestampBehaviorTest::$dateCalls = [];
        TimestampBehaviorTest::$dateCallsCounter = 0;
        TimestampBehaviorTest::$now = 'now';
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

    public function testCreated_atAndUpdated_atWhenIsSaved()
    {
        TimestampBehaviorTest::$now = 'nowbefore';
        $client = new Client;

        expect($client->created_at)->equals('nowbefore');
        expect($client->updated_at)->equals('nowbefore');

        TimestampBehaviorTest::$now = '2017-01-01 01:02:03';
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
        TimestampBehaviorTest::$now = '2017-01-02 04:05:06';
        expect($client->save())->true();
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-02 04:05:06');

        //has been saved correctly?
        $client = Client::findOne($client->id);
        expect($client->created_at)->equals('2017-01-01 01:02:03');
        expect($client->updated_at)->equals('2017-01-02 04:05:06');
    }
}
