<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\Link;
use yii\db\Query;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\base\Model;


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
class Page extends ActiveRecord implements Linkable
{
    const SCENARIO_CREATE = 'create';
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

//    public $id;
//    public $name;

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['url'];
    }

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

    public function fields()
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
            [['name', 'title', 'create', 'update', 'url', 'status', 'content', 'metatags', '_id', 'tags'], 'safe'],
            [['name', 'title', 'url', 'status'], 'required'],
            [['name', 'title'], 'string', 'min' => 2],
            ['_id', 'string'],
            [['_id', 'url'], 'unique'],
            ['url', 'trim'],
            ['url', 'match', 'pattern' => '/^[a-z0-9-]+$/'],
        ];
    }

    /**
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['Name','Title','Url'];
        return $scenarios;
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
    
    public function beforeSave($insert)
    {
        $this->update = time();
        $this->tags = explode(', ', $this->tags);
        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return [
//            Link::REL_SELF => Url::to(['index'], true),
        ];
    }
}
