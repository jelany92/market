<?php
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

/**
 * Collection of tools
 *
 * Class ToolsController
 * @package console\controllers
 */
class ToolsController extends Controller
{
    /**
     * Creates an Backup
     *
     * @throws \yii\base\Exception
     */
    public function actionBackup()
    {
        /** @var \demi\backup\Component $backup */
        $backup = \Yii::$app->backup;

        $file = $backup->create();

        $this->stdout('Backup file created: ' . $file . PHP_EOL, Console::FG_GREEN);
    }
}