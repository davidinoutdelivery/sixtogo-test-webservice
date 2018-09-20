<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Facebook extends Model
{
	public function saveResponse($userAttributes)
	{
		$session = Yii::$app->session;
        $session->open();

        $session['facebook'] = $userAttributes;
	}
}