<?php

namespace app\modules\advanced_search\controllers;

use Yii;
use yii\filters\AccessControl;
use humhub\modules\user\models\ProfileField;
use humhub\modules\user\models\ProfileFieldCategory;

class AdvancedSearchController extends \yii\web\Controller {
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','search','whole-search'],
                'rules' => [
                    [
                        'actions' => ['index','search','whole-search'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $profile_fields = ProfileField::find()->where(['searchable' => 1, 'visible' => 1])->all();
        $profile_field_category = ProfileFieldCategory::find()->all();
        return $this->render('index', ['profile_fields' => $profile_fields, 'field_category' => $profile_field_category]);
    }

    /**
     * Action to get the result of search
     * @return string
     */
    public function actionSearch() {
        $category = Yii::$app->request->post('condition');
        $proffield = Yii::$app->request->post('prof_field');
        $operator = Yii::$app->request->post('operator');
        $profile_fields = ProfileField::find()->where(['searchable' => 1, 'visible' => 1])->all();
        $str = 'SELECT * FROM `profile` WHERE ';
        $i = 0;
        $flag = 0;
        foreach ($profile_fields as $value) {
            if ($proffield[$i] !== '') {
                $data = "'%$proffield[$i]%'";
                if ($flag == 1) {
                    $str .= ($operator[$i - 1] == 0 ? ' OR ' : ' AND ') . $value->internal_name . ($category[$i] == 0 ? ' LIKE ' : ' NOT LIKE ') . $data;
                } else {
                    $str .= $value->internal_name . ($category[$i] == 0 ? ' LIKE ' : ' NOT LIKE ') . $data;
                    $flag = 1;
                }
            }
            $i++;
        }
        if ($str !== 'SELECT * FROM `profile` WHERE ') {
            $users = Yii::$app->db->createCommand("$str")->queryAll();
            return $this->render('searchresult', ['users' => $users]);
        } else {
            $str = 'SELECT * FROM `profile` WHERE user_id=12000000000000000 ';
            $users = Yii::$app->db->createCommand("$str")->queryAll();
            return $this->render('searchresult', ['users' => $users]);
        }
    }

    /**
     * Action to get the result of search
     * @return string
     */
    public function actionWholeSearch() {
        $search_box = Yii::$app->request->post('search_box');
        $profile_fields = ProfileField::find()->where(['searchable' => 1, 'visible' => 1])->all();
        $flag = 0;
        if (!empty($search_box)) {
            $str = 'SELECT * FROM `profile` WHERE ';
            $data = "'%$search_box%'";
            foreach ($profile_fields as $value) {
                if ($flag == 1) {
                    $str .= ' OR ' . $value->internal_name . ' LIKE ' . $data;
                } else {
                    $str .= $value->internal_name . ' LIKE ' . $data;
                    $flag = 1;
                }
            }
        } else {
            $str = 'SELECT * FROM `profile` WHERE user_id=12000000000000000 ';
        }
        $users = Yii::$app->db->createCommand("$str")->queryAll();
        return $this->render('searchresult', ['users' => $users]);
    }

}
