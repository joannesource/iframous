<?php

namespace Iframous;

/**
 * Configurator for Tagger component.
 *
 * @author joannesource
 */
class TaggerConf {

    private $selectedElements;
    private $selectableElements;
    private $taggedFrameUrl;
    private $tagsFrameUrl;
    private $inputFrameUrl;
    private $postAddRoute;
    private $removeUrlTpl;
    private $addUrlTpl;
    private $viewUrl;
    private $isEditionMode;
    private $viewModeTarget;

    function validate() {
        $class_vars = get_class_vars(get_class($this));
        foreach ($class_vars as $name => $value) {
            if (is_null($this->$name)) {
                throw new \Exception("Unset TaggerConf option : $name");
            }
        }
    }

    function getSelectedElements() {
        return $this->selectedElements;
    }

    function getSelectableElements() {
        return $this->selectableElements;
    }

    function getTaggedFrameUrl() {
        return $this->taggedFrameUrl;
    }

    function getTagsFrameUrl() {
        return $this->tagsFrameUrl;
    }

    function getInputFrameUrl() {
        return $this->inputFrameUrl;
    }

    function getPostAddRoute() {
        return $this->postAddRoute;
    }

    function getRemoveUrlTpl() {
        return $this->removeUrlTpl;
    }

    function getAddUrlTpl() {
        return $this->addUrlTpl;
    }

    function setSelectedElements($selectedElements) {
        $this->selectedElements = $selectedElements;
    }

    function setSelectableElements($selectableElements) {
        $this->selectableElements = $selectableElements;
    }

    function setTaggedFrameUrl($taggedFrameUrl) {
        $this->taggedFrameUrl = $taggedFrameUrl;
    }

    function setTagsFrameUrl($tagsFrameUrl) {
        $this->tagsFrameUrl = $tagsFrameUrl;
    }

    function setInputFrameUrl($inputFrameUrl) {
        $this->inputFrameUrl = $inputFrameUrl;
    }

    function setPostAddRoute($postAddRoute) {
        $this->postAddRoute = $postAddRoute;
    }

    function setRemoveUrlTpl($removeUrlTpl) {
        $this->removeUrlTpl = $removeUrlTpl;
    }

    function setAddUrlTpl($addUrlTpl) {
        $this->addUrlTpl = $addUrlTpl;
    }

    function getViewUrl() {
        return $this->viewUrl;
    }

    function setViewUrl($viewUrl) {
        $this->viewUrl = $viewUrl;
    }

    function isEditionMode() {
        return $this->isEditionMode;
    }

    function setEditionMode($isEditionMode) {
        $this->isEditionMode = $isEditionMode;
    }

    function getViewModeTarget() {
        return $this->viewModeTarget;
    }

    function setViewModeTarget($viewModeTarget) {
        $this->viewModeTarget = $viewModeTarget;
    }

}
