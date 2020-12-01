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
    public $collapsed      = true;
    public $inSubAccordion = false;
    public $toggle         = 'collapse';
    public $collapseClass  = '';
    public $containerClass = '';
    public $headerClass    = '';
    public $titleClass     = '';

    public function init()
    {
        parent::init();
        if (isset($this->id))
        {
            $idCapitalized = ucfirst($this->id);
        }

        if (!isset($this->icon))
        {
            $this->icon = Icon::show('circle', ['framework' => Icon::FAR]);
        }

        echo Html::beginTag('div', [
            'class' => 'card' . ($this->inSubAccordion ? ' sub-card' : '') . (0 < strlen($this->containerClass) ? ' ' . $this->containerClass : ''),
            'id'    => $this->id,
        ]);

        if (isset($this->title))
        {
            echo Html::beginTag('div', [
                'class'         => ($this->inSubAccordion ? 'card-body' : 'card-header') . (0 < strlen($this->headerClass) ? ' ' . $this->headerClass : ''),
                'id'            => isset($idCapitalized) ? 'heading' . $idCapitalized : null,
                'data-toggle'   => $this->toggle,
                'data-target'   => isset($idCapitalized) ? '#collapse' . $idCapitalized : null,
                'aria-expanded' => 'false',
                'aria-controls' => isset($idCapitalized) ? 'collapse' . $idCapitalized : null,
            ]);
            echo Html::tag($this->inSubAccordion ? 'h3' : 'h2', $this->icon . ' ' . $this->title, [
                'class' => ($this->inSubAccordion ? 'h6' : 'h5') . ' mb-0 text-primary collapsed' . (0 < strlen($this->titleClass) ? ' ' . $this->titleClass : ''),
            ]);
            echo Html::endTag('div');
        }

        echo Html::beginTag('div', [
            'class'           => 'collapse' . ($this->collapsed ? '' : ' show') . (0 < strlen($this->collapseClass) ? ' ' . $this->collapseClass : ''),
            'id'              => isset($idCapitalized) ? 'collapse' . $idCapitalized : null,
            'aria-labelledby' => isset($idCapitalized) ? 'heading' . $idCapitalized : null,
            'data-parent'     => isset($this->parent) ? '#' . $this->parent : null,
        ]);
        echo Html::beginTag('div', [
            'class' => 'card-body' . ($this->inSubAccordion ? ' pt-0' : ''),
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