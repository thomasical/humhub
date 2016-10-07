<?php

namespace app\modules\advance_search\controllers;

use Yii;
use yii\base\ErrorHandler;
use yii\web\Controller;


/**
 * Default controller for the `advance_search` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        
        return $this->render('joby');
    }

    

}
