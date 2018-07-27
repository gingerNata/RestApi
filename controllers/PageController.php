<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Page;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;


/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends ActiveController
{
    public $modelClass = 'app\models\Page';

    public $reservedParams = ['sort','q'];

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(), [
            'authenticator' => [
                'authMethods' => [
                    'basicAuth' => [
                        'class' => HttpBasicAuth::className(),
                        'auth'  => function ($username, $password) {
                            $user = User::findByUsername($username);
                            if ($user !== null &&
                                $user->validatePassword($password)
                            ) {
                                return $user;
                            }
                            return null;
                        },
                    ]
                ]
            ]
        ]
        );
    }


    public function actions() {
        $actions = parent::actions();
        // 'prepareDataProvider' is the only function that need to be overridden here
        $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    }

    public function indexDataProvider() {
        $params = \Yii::$app->request->queryParams;

        $model = new $this->modelClass;
        $modelAttr = $model->attributes;

        $search = [];

        if (!empty($params)) {
            foreach ($params as $key => $value) {

                if(!is_scalar($key) or !is_scalar($value)) {
                    throw new BadRequestHttpException('Bad Request');
                }

                if (!in_array(strtolower($key), $this->reservedParams)
                    && ArrayHelper::keyExists($key, $modelAttr, false)) {
                    $search[$key] = $value;
                }
            }
        }

        $searchByAttr = $search;
        $searchModel = new \app\models\PageSearch();
        return $searchModel->search($searchByAttr);
    }

    public function actionView($id)
    {

        $model=$this->findModel($id);

        $this->setHeader(200);
        echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);

    }
    /* function to find the requested record/model */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {

            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'message'=>'Bad request'),JSON_PRETTY_PRINT);
            exit;
        }
    }

    public function actionCreate()
    {

        $params = $_REQUEST;
        $tags = (array) json_decode($params['tags']);
        if ($tags) {
            $params['tags'] = $tags['array'];
        }
        $model = new Page();
        $model->attributes = $params;
        $model->update = date('Y/m/d h:i:s', time());
        $model->create = date('Y/m/d h:i:s', time());

        if ($model->save()) {

            $this->setHeader(200);
            echo json_encode(
                array(
                    'status' => 1,
                    'data'   => array_filter($model->attributes)
                ), JSON_PRETTY_PRINT
            );

        } else {
            $this->setHeader(400);
            echo json_encode(
                array(
                    'status' => 0,
                    'error_code' => 400,
                    'errors' => $model->errors
                ), JSON_PRETTY_PRINT
            );
        }

    }

    public function actionUpdate($id)
    {
        $params=$_REQUEST;

        $model = $this->findModel($id);

        $model->attributes=$params;

        if ($model->save()) {

            $this->setHeader(200);
            echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);

        }
        else
        {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }

    }

//    /**
//     * Lists all Page models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        $filter = new ActiveDataFilter([
//                                           'searchModel' => 'app\models\PageSearch'
//                                       ]);
//
//        $filterCondition = null;
//
//// You may load filters from any source. For example,
//// if you prefer JSON in request body,
//// use Yii::$app->request->getBodyParams() below:
//        if ($filter->load(\Yii::$app->request->get())) {
//            $filterCondition = $filter->build();
//            if ($filterCondition === false) {
//                // Serializer would get errors out of it
//                return $filter;
//            }
//        }
//
//        $query = Page::find();
//        if ($filterCondition !== null) {
//            $query->andWhere($filterCondition);
//        }
//
//        return new ActiveDataProvider([
//                                          'query' => $query,
//                                      ]);
//    }
//
//    /**
//     * Displays a single Page model.
//     * @param string $_id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionView($id)
//    {
//        $id = (string) $id;
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//
//    public function actionGetPage()
//    {
//        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
//        $pages = Page::findOne(['url' => 'efficitur999983']);
//        if(count($pages) > 0 ) {
//            return new ActiveDataProvider(['query' => Page::find()->each()]);
//        } else {
//            return array('status'=>false,'data'=> 'No Student Found');
//        }
//    }
//
//    /**
//     * Creates a new Page model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreatePage()
//    {
////        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
//        $page = new Page();
//        $page->scenario = Page:: SCENARIO_CREATE;
//        $page->attributes = \yii::$app->request->post();
//
//        if ($page->validate()) {
//            $page->save();
//
//            return array(
//                'status' => true,
//                'data'   => 'Student record is successfully updated'
//            ); } else {
//            return array('status' => false, 'data' => $page->getErrors());
//        }
////        $model = new Page();
////
////        if ($model->load(Yii::$app->request->post()) && $model->save()) {
////            return $this->redirect(['view', 'id' => (string)$model->_id]);
////        }
////
////        return $this->render('create', [
////            'model' => $model,
////        ]);
//    }
//
//    /**
//     * Updates an existing Page model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $_id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => (string)$model->_id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Page model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $_id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
//
//    /**
//     * Finds the Page model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param integer $_id
//     * @return Page the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id)
//    {
//        if (($model = Page::findOne($id)) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//    }
}
