<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\widgets;

/**
 * Description of FilterPopover
 *
 * @author User
 */
class FilterPopover extends \yii\bootstrap\Widget {

    public $btnOptions;
    public $content;
    public $footer;

    //put your code here
    public function run() {
        $btnId = $this->btnOptions['id'];
        $popoverId = $btnId . "-popover";

        $popoverClass = "popover-filter popover popover-x popover-default popover-md has-footer kv-popover-active in bottom bottom-left";
        //$popoverClass = "modal";
        if($this->view->isMobile())
            $popoverClass = "popover-filter-mobile " . $popoverClass;
        $popoverHtml = "<div id='$popoverId' class='$popoverClass' hidden>";
        if(!$this->view->isMobile())
            $popoverHtml .= "<div class='arrow'></div>";
        $popoverHtml .= "<div class='popover-body popover-content'>{$this->content} </div>";
        $popoverHtml .= "<div class='popover-footer'> {$this->footer}</div>";
        $popoverHtml .= "</div>";
        //$popoverHtml .= "<div id='$popoverId-shadow' class='popover-shadow' style='position: fixed; top:0; left:0; width: 100%; height: 100%; background-color: black; opacity: 0.3' hidden> </div>";
        $label = $this->btnOptions['label'];
        unset($this->btnOptions['label']);

        if ($this->view->isMobile()) {
            $leftCode = '15';
        } else {
            $leftCode = '$(this).offset().left';
        }

        $jsCode = "$('#$popoverId').css('left', $leftCode).toggle();"
                . "$('.popover:not([id=\"$popoverId\"])').hide();"
                . "if($('#$popoverId').is(':visible')) { "
                . "$('body>.wrap>.container').css('opacity', 0.2)} "
                . "else{ $('body>.wrap>.container').css('opacity', 1) };"
        ;
        $this->btnOptions['onclick'] = $jsCode;
        $btn = \yii\helpers\Html::button($label, $this->btnOptions);

        return $btn . $popoverHtml;
    }

}
