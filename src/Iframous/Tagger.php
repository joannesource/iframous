<?php

namespace Iframous;

use DiDom\Element;
use DiDom\Document;

/**
 * Tagging iframe component using TaggerConf as configurator.
 *
 * @author joannesource
 */
class Tagger {

    public $removeHandler;
    public $addHandler;
    private $options;
    private $id;

    const IFNAME_TAGGING = 'iframous-tagging';
    const IFNAME_TAGGED = 'iframous-tagged';
    const IFNAME_INPUT = 'iframous-input';

    function __construct(TaggerConf $opt) {
        $this->options = $opt;
        $this->options->validate();
    }

    public function show($id) {
        $this->id = $id;
        $document = new Document();
        
        $edit_param = $this->options->isEditionMode() ? '?edit=1' : '';
        
        $element = new Element('iframe');
        $url = $this->options->getTaggedFrameUrl();
        $url = str_replace(':id', $this->id, $url);
        $element->attr('src', $url.$edit_param);
        $element->attr('name', self::IFNAME_TAGGED);
        $element->attr('style', 'height:80px;width:90%;');
        $document->appendChild($element);

        $element = new Element('iframe');
        $url = $this->options->getTagsFrameUrl();
        $url = str_replace(':id', $this->id, $url);
        $element->attr('src', $url.$edit_param);
        $element->attr('name', self::IFNAME_TAGGING);
        $element->attr('style', 'height:80px;width:90%;');
        $document->appendChild($element);

        $element = new Element('iframe');
        $url = $this->options->getInputFrameUrl();
        $url = str_replace(':id', $this->id, $url);
        $element->attr('src', $url);
        $element->attr('name', self::IFNAME_INPUT);
        $element->attr('style', 'height:80px;width:90%;');
        $document->appendChild($element);

        echo $document->html();
    }

    public function showNewTagInput($id) {
        $document = new Document();
        $element = new Element('form');
        $element->attr('action', $this->options->getPostAddRoute());
        $element->attr('method', 'POST');
        $element->attr('target', self::IFNAME_TAGGED);
        $input = new Element('input');
        $input->attr('name', 'tag');
        $element->appendChild($input);
        $input = new Element('input');
        $input->attr('name', 'id');
        $input->attr('value', $id);
        $input->attr('type', 'hidden');
        $element->appendChild($input);
        $document->appendChild($element);
        echo $document->html();
    }

    public function showSelectedTags($id) {
        $this->id = $id;
        $this->listLinks($this->options->getSelectedElements(), $this->options->getRemoveUrlTpl());
    }

    public function showSelectableTags($id) {
        $this->id = $id;
        $this->listLinks($this->options->getSelectableElements(), $this->options->getAddUrlTpl());
    }

    private function listLinks($elements, $handler) {
        $document = new Document();
        foreach ($elements as $el) {
            $proper_val = str_replace(' ', '-', $el);
            $target = self::IFNAME_TAGGED;
            if (!$this->options->isEditionMode()) {
                $handler = $this->options->getViewUrl();
                $target = $this->options->getViewModeTarget();
            }
            $url = str_replace(':tag', $proper_val, $handler);
            $href = str_replace(':id', $this->id, $url);
            if(!$this->options->isEditionMode())
                $href .= '&origin='. urlencode(dirname($this->id));
            $element = new Element('a', $el);
            $element->attr('href', $href);
            $element->attr('target', $target);
            $document->appendChild($element);
        }
        echo $document->html();
    }

}
