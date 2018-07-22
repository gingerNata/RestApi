<?php

namespace app\models;

use Yii;
use Yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "pages".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $name
 * @property mixed $title
 * @property mixed $create
 * @property mixed $update
 * @property mixed $url
 * @property mixed $status
 * @property mixed $tags
 * @property mixed $metatags
 * @property mixed $content
 */
class Page extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['api', 'pages'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'name',
            'title',
            'create',
            'update',
            'url',
            'status',
            'tags',
            'metatags',
            'content',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title', 'create', 'update', 'url', 'status', 'tags', 'metatags', 'content'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'create' => Yii::t('app', 'Create'),
            'update' => Yii::t('app', 'Update'),
            'url' => Yii::t('app', 'Url'),
            'status' => Yii::t('app', 'Status'),
            'tags' => Yii::t('app', 'Tags'),
            'metatags' => Yii::t('app', 'Metatags'),
            'content' => Yii::t('app', 'Content'),
        ];
    }
}
