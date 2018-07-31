<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

namespace Angujo\PhpRosa\Core;

/**
 * Description of IdPath
 *
 * @author bangujo
 */
class IdPath {
    private static $me;
    
    /** @var Path[] */
    private $paths=[];
    private $root;

    protected function __construct() {
        
    }
    
    protected function root($root) {
        $this->root=$root;
        foreach ($this->paths as $path) {
            $path->setRoot($root);
        }
        return $this;
    }
    
    public function addPath($id,$name) {
        $p= Path::create($id, $name);
        self::init()->paths[$id]=&$p;
        return $p;
    }
    
    /**
     * 
     * @param string $id
     * @return Path
     */
    public static function getPath($id) {
        $me=self::init();
        if(isset($me->paths[$id])) return $me->paths[$id];
        return $me->paths[$id]= Path::create($id, 'unknown');
    }
    
    /**
     * 
     * @return self
     */
    private static function init() {
        return self::$me=self::$me?:new self();
    }
    
    public static function getPaths() {
        return self::init()->paths;
    }
}
