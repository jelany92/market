<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use kartik\icons\Icon;
use common\models\ArticleInfo;

use yii\bootstrap4\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


        <p>Please fill out the following fields to login:</p>
    <div class="page-content">
        <div class="container">
            <div class="toolbox">
                <div class="toolbox-left">
                    <?= Html::a(Icon::show('bars', ['style' => 'margin-right: 5px;']) . Yii::t('app', 'Filters'), ['site/index#'], ['class' => 'sidebar-toggler']) ?>
                </div><!-- End .toolbox-left -->
            </div><!-- End .toolbox -->

            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
            <aside class="sidebar-shop sidebar-filter">
                <div class="sidebar-filter-wrapper">
                    <div class="widget widget-clean">
                        <?= Html::label(Icon::show('bars', ['style' => 'margin-right: 5px;']) . Yii::t('app', 'Filters'), ['class' => 'widget widget-clean']) ?>
                        <?= Html::a(Yii::t('app', 'Clear All'), '#', ['options' => ['class' => 'sidebar-filter-clear']]) ?>
                    </div><!-- End .widget -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <?= Html::a(Yii::t('app', 'Category'), '#widget-1', [
                                'data-toggle'   => 'collapse',
                                'role'          => 'button',
                                'aria-expanded' => true,
                                'aria-controls' => 'widget-1',
                            ]) ?>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <?php foreach ($mainCategories as $mainCategory) : ?>
                                    <div class="filter-items filter-items-count">
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-<?= $mainCategory->id ?>">
                                                <?= Html::label($mainCategory->category_name, 'cat-' . $mainCategory->id, ['class' => 'custom-control-label']) ?>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">
                                                <?= count($mainCategory->articles) ?>
                                            </span>
                                        </div><!-- End .filter-item -->

                                    </div><!-- End .filter-items -->
                                <?php endforeach; ?>
                            </div><!-- End .widget-body -->

                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->

                </div><!-- End .sidebar-filter-wrapper -->
            </aside><!-- End .sidebar-filter -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
    </div>
</div>
