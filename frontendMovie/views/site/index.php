<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use common\models\DetailGalleryArticle;

/* @var $this yii\web\View */
/* @var $mainCategoryList array */

$this->title = 'My Yii Application';
?>
<div class="advanced-search primary">
    <?php $form = ActiveForm::begin([
                                        'action'  => [''],
                                        'method'  => 'get',
                                        'options' => ['class' => 'col-12 form-ui row'],
                                    ]); ?>

    <?= Html::label(Yii::t('app', 'البحث المتقدم'), null, [
        'class' => 'col-lg-2',
    ]) ?>
    <?= Html::input('text', null, null, [
        'class'       => 'col-lg-5',
        'placeholder' => Yii::t('app', 'كلمات البحث'),
    ]) ?>

    <?= Html::dropDownList('text', null, $mainCategoryList, [
        'class'  => 'col-lg-3',
        'prompt' => Yii::t('app', 'الكل'),
    ]) ?>
    <div class="col-lg-2" style="bottom: 3px">
        <?= Html::submitButton(Yii::t('app', 'بدأ البحث'), [
            'name'  => 'contact-button',
            'class' => 'btn btn-danger rounded',
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<div class="categories-tabs row">

    <div class="category-block active col-lg-2">
        <div class="content-box fillter" data-get="latest">
            <?= Html::a(Html::img('https://shahid4u.im/themes/Arablionz/img/Designbolts-Free-Multimedia-Film.png', [
                'class' => '',
                'style' => 'width: 100%;max-width: 100%;max-height: 100%;height: 100%',
            ]), ['javascript:'], ['class' => 'icon']) ?>
            <?= Html::a('<h3>' . Yii::t('app', 'الأحدث') . '</h3>', ['javascript:']) ?>
        </div>
    </div>

    <div class="category-block col-lg-2">
        <div class="content-box fillter" data-get="imdb">
            <?= Html::a(Html::img('https://shahid4u.im/themes/Arablionz/img/imdb.png', [
                'class' => '',
                'style' => 'width: 100%;max-width: 100%;max-height: 100%;height: 100%',
            ]), ['javascript:'], ['class' => 'icon']) ?>
            <?= Html::a('<h3>' . Yii::t('app', 'الأعلى تقيما') . '</h3>', ['javascript:']) ?>
        </div>
    </div>

    <div class="category-block col-lg-2">
        <div class="content-box fillter" data-get="view">
            <a href="javascript:;" class="icon">
                <img style="width: 100%;max-width: 100%;max-height: 100%;height: 100%" src="https://shahid4u.im/themes/Arablionz/img/sport_badges-02-512.png">
            </a>
            <a href="javascript:;"><h3>الأكثر مشاهدة</h3></a>
        </div>
    </div>

    <div class="category-block col-lg-2">
        <div class="content-box fillter" data-get="pin">
            <a href="javascript:;" class="icon">
                <img style="width: 100%;max-width: 100%;max-height: 100%;height: 100%" src="https://shahid4u.im/themes/Arablionz/img/pin.png">
            </a>
            <a href="javascript:;"><h3>المثبت</h3></a>
        </div>
    </div>

    <div class="category-block col-lg-2">
        <div class="content-box fillter" data-get="newFilms">
            <a href="javascript:;" class="icon">
                <img style="width: 100%;max-width: 100%;max-height: 100%;height: 100%" src="https://shahid4u.im/themes/Arablionz/img/films.png">
            </a>
            <a href="javascript:;"><h3>جديد الافلام</h3></a>
        </div>
    </div>

    <div class="category-block col-lg-2">
        <div class="content-box fillter" data-get="newEpisode">
            <a href="javascript:;" class="icon">
                <img style="width: 100%;max-width: 100%;max-height: 100%;height: 100%" src="https://shahid4u.im/themes/Arablionz/img/icon.png">
            </a>
            <a href="javascript:;"><h3>جديد الحلقات</h3></a>
        </div>
    </div>
</div>

<div class="advanced-search">
    <form class="form-ui small col-12 row gutter-small margin-fix">
        <?= Html::label(Yii::t('app', 'ترتيب حسب'), null, [
            'class' => 'col-lg-2',
        ]) ?>

        <?= Html::dropDownList('', ['li data-tax="category" data-cat=""'], $mainCategoryList, [
            'class'  => 'col-lg-3',
            'prompt' => '--' . Yii::t('app', 'القسم') . '--',
        ]) ?>

        <?= Html::dropDownList('text', null, $mainCategoryList, [
            'class'  => 'col-lg-2',
            'prompt' => '--' . Yii::t('app', 'النوع') . '--',
        ]) ?>

        <?= Html::dropDownList('text', null, $mainCategoryList, [
            'class'  => 'col-lg-3',
            'prompt' => '--' . Yii::t('app', 'السنة') . '--',
        ]) ?>

        <?= Html::dropDownList('text', null, $mainCategoryList, [
            'class'  => 'col-lg-2',
            'prompt' => '--' . Yii::t('app', 'الجودة') . '--',
        ]) ?>
</div>

<div class="row MediaGrid">
    <?php foreach ($modelDetailGalleryArticle as $detailGalleryArticle) : ?>
        <?php if ($detailGalleryArticle->bookGalleries->book_photo != null) : ?>
            <?php $image = DetailGalleryArticle::subcategoryImagePath($detailGalleryArticle->bookGalleries->book_photo); ?>
            <div class="box-5x1 media-block">
                <div class="content-box">
                    <?= Html::a('', ['information/view', 'id' => $detailGalleryArticle->id], [
                        'class' => 'fullClick',
                    ]) ?>
                    <?= Html::a('', ['information/view', 'id' => $detailGalleryArticle->id], [
                        'class'    => 'image',
                        'data-src' => $image,
                        'style'    => 'background-image: url("' . $image . '")',
                    ]) ?>
                    <span class="quality" style="background: #563d7c">جديد</span>

                    <span class="rate ti-star">6.7</span>
                    <span class="views ti-eye">23</span>
                    <div class="hvr">
                        <?= Html::a('', [''], [
                            'class' => 'ti-slow-motion play-btn',
                        ]) ?>
                        <?= Html::a('<h5>' . $detailGalleryArticle->article_name_ar . '</h5>', ['']) ?>
                        <p>مشاهدة وتحميل مسلسل الخيال العلمي الحاجز La valla S01 HD الموسم الاول مترجم اون لاين وتحميل مباشر مسلسل The...</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>