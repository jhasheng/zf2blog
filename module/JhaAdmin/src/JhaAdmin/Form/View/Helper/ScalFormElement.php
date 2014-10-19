<?php
namespace JhaAdmin\Form\View\Helper;

use Zend\Form\View\Helper\FormElement;
use Zend\Form\ElementInterface;

class ScalFormElement extends FormElement
{

    protected $spanContent = null;

    protected $spanFormart = "<span class=\"help-block m-b-none\">%s</span>";

    protected $formart = "<div class=\"form-group\">%s<div class=\"col-sm-10\">%s</div></div>";

    public function __invoke(ElementInterface $element = null, $spanContent = null)
    {
        if (! empty($spanContent)) {
            $this->spanContent = sprintf($this->spanFormart, $spanContent);
        } else {
            $this->spanContent = null;
        }
        if (! $element) {
            return $this;
        }
        return $this->render($element);
    }

    public function render(ElementInterface $element)
    {
        $labelContent = '';
        if (! empty($element->getLabel())) {
            $labelContent = $this->getView()->formLabel($element);
        }
        
        $renderer = $this->getView();
        if (! method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable 
            return '';
        }
        
        $renderedInstance = $this->renderInstance($element);
        
        if ($renderedInstance !== null) {
            return $this->joinContent($labelContent, $renderedInstance);
        }
        
        $renderedType = $this->renderType($element);
        if ($renderedType !== null) {
            return $this->joinContent($labelContent, $renderedType);
        }
        return $this->joinContent($labelContent, $this->renderHelper($this->defaultHelper, $element));
    }

    protected function joinContent($labelContent, $inputContent)
    {
        if (! empty($this->spanContent)) {
            $inputContent = $inputContent . $this->spanContent;
        }
        return sprintf($this->formart, $labelContent, $inputContent);
    }
}