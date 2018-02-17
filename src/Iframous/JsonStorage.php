<?php

namespace Iframous;

/**
 * JSON storage.
 *
 * @author joannesource
 */
class JsonStorage {

    public $loaded;
    private $path;
    private $populated;

    function __construct($path) {
        $this->path = "$path/db";
        if (!file_exists($this->path) || (($content = file_get_contents($this->path))) && empty($content)) {
            file_put_contents($this->path, '[]');
            $this->populated = false;
        } else {
            $this->populated = true;
        }
        $this->loaded = json_decode(file_get_contents($this->path), true);
    }

    function isPopulated() {
        return $this->populated;
    }

    function getAll($table, $default = []) {
        if (isset($this->loaded[$table])) {
            return $this->loaded[$table];
        }else{
            return $default;
        }
    }
    function getCount($table, $key, $default) {
        if (isset($this->loaded[$table][$key])) {
            return count($this->loaded[$table][$key]);
        }
        return 0;
    }

    function get($table, $key, $default = false) {
        if (isset($this->loaded[$table][$key])) {
            return $this->loaded[$table][$key];
        }
        return $default;
    }
    
    function set($table, $key, $value) {
        if(!isset($this->loaded[$table]))
            $this->loaded[$table] = [];
         $this->loaded[$table][$key] = $value;
    }

    function append($table, $key, $value) {
        if (!isset($this->loaded[$table][$key])) {
            $this->loaded[$table][$key] = [];
        }
        $this->loaded[$table][$key][] = $value;
        $this->loaded[$table][$key] = array_unique($this->loaded[$table][$key]);
    }

    function appendVal($table, $val) {
        $this->loaded[$table][] = $val;
    }

    function removeKey($table, $key) {
        unset($this->loaded[$table][$key]);
    }

    function removeVal($table, $key, $value) {
        $this->loaded[$table][$key] = array_diff($this->loaded[$table][$key], [$value]);
    }

    function populate($table, $values) {
        $this->loaded[$table] = $values;
    }

    function __destruct() {
        file_put_contents($this->path, json_encode($this->loaded, JSON_PRETTY_PRINT), LOCK_EX);
    }

}
