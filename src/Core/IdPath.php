<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

namespace Angujo\PhpRosa\Core;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Util\Strings;

/**
 * Description of IdPath
 *
 * @author bangujo
 */
class IdPath
{
    private static $me;

    /** @var Path[] */
    private $paths = [];
    private $root;

    protected function __construct()
    {

    }

    protected function root($root)
    {
        $this->root = $root;
        foreach ($this->paths as $path) {
            $path->setRoot($root);
        }
        return $this;
    }

    /**
     *
     * @param string $id
     * @return Path
     */
    public static function getPath(&$id)
    {
        return self::init($id)->paths[$id];
    }

    /**
     *
     * @return self
     */
    private static function init(&$id)
    {
        $id = null === $id ? uniqid('pid', true) : $id;
        $s = self::$me = self::$me ?: new self();
        if (!isset($s->paths[$id])) {
            $s->paths[$id] = Path::create($id, 'unknown');
            if ($s->root) $s->paths[$id]->setRoot($s->root);
        }
        return $s;
    }

    /**
     * @param $root string
     * @return IdPath
     */
    public static function setRoot($root)
    {
        self::$me = self::$me ?: new self();
        self::$me->root($root);
        return self::$me;
    }

    /**
     * @return Path[]
     */
    public static function getPaths()
    {
        return (self::$me ?: new self())->paths;
    }

    /**
     * @return array
     */
    public static function optimizedPaths()
    {
        $paths = self::getPaths();
        $ps = [];
        foreach ($paths as $path) {
            if ($path->isIgnored()) continue;
            Strings::dottedToArray($ps,implode('.',$path->rootXPath()),$path->getValue());
        }
        return $ps;
    }
}
