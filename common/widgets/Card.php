<?php

namespace common\widgets;

use kartik\icons\Icon;
use yii\base\Widget;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\bootstrap4\Html;

/**
 * Class Table
 *
 * @package common\widgets
 */
class Card extends Widget
{
    public $id;
    public $parent;
    public $title;
    public $icon;
    public $collapsed = true;
    public $inSubAccordion = false;
    public $toggle = 'collapse';
    public $collapseClass = '';

    public function init()
    {
        parent::init();

        $idCapitalized = ucfirst($this->id);
        if(!isset($this->icon))
        {
            $this->icon = Icon::show('circle', ['framework' => Icon::FAR]);
        }

        echo Html::beginTag('div', [
            'class' => 'card' . ($this->inSubAccordion ? ' sub-card' : ''),
            'id'    => $this->id,
        ]);
        echo Html::beginTag('div', [
            'class' => $this->inSubAccordion ? 'card-body' : 'card-header',
            'id'    => 'heading' . $idCapitalized,
        ]);
        echo Html::tag($this->inSubAccordion ? 'h3' : 'h2', $this->icon . ' ' . $this->title, [
            'class'         =>  ($this->inSubAccordion ? 'h6' : 'h5') . ' mb-0 text-primary collapsed',
            'data-toggle'   => $this->toggle,
            'data-target'   => '#collapse' . $idCapitalized,
            'aria-expanded' => 'false',
            'aria-controls' => 'collapse' . $idCapitalized,
        ]);
        echo Html::endTag('div');
        echo Html::beginTag('div', [
            'class'           => 'collapse' . ($this->collapsed ? '' : ' show') . (0 <strlen($this->collapseClass) ? ' ' . $this->collapseClass : ''),
            'id'              => 'collapse' . $idCapitalized,
            'aria-labelledby' => 'heading' . $idCapitalized,
            'data-parent'     => '#' . $this->parent,
        ]);
        echo Html::beginTag('div', [
            'class' => 'card-body',
        ]);
    }

    public function run()
    {
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');
        BootstrapPluginAsset::register($this->getView());
    }
}