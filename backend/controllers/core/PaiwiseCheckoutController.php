<?php

namespace backend\controllers\core;

use backend\components\core\BaseController;
use common\models\core\SystemLog;
use common\models\core\PaiwiseCheckout;
use yii\web\NotFoundHttpException;

class PaiwiseCheckoutController extends BaseController {

    public function actionWebhook() {
        // TODO: Missing changing the table depends from response
        $checkoutResponse = @file_get_contents('php://input');
        $systemLog = new SystemLog();
        $systemLog->message_short = 'Test message of webhook';
        $systemLog->data_format = $checkoutResponse;
        $systemLog->save();
    }

    /**
     * Finds the PaiwiseCheckout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaiwiseCheckout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaiwiseCheckout::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
