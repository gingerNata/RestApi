<?php

class m180722_130729_test extends \yii\mongodb\Migration
{
    private $collection = 'user';

    public function up()
    {
        $this->createCollection($this->collection);
        $this->createIndex($this->collection, 'url', ['unique' => true]);
    }

    public function down()
    {
        $this->dropIndex($this->collection, 'url');

        $this->dropCollection($this->collection);
    }
}
