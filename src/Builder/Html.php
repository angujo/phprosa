<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 4:58 AM
 */

namespace Angujo\PhpRosa\Builder;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Html
{
    /** @var Body */
    private $body;
    /** @var Head */
    private $head;
    /** @var Writer */
    private $writer;

    private $processed = false;

    public function __construct(Writer $writer = null) { $this->writer = $writer ? new Writer() : $writer; }

    /**
     * @param mixed $body
     * @return Html
     */
    public function setBody(Body $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param mixed $head
     * @return Html
     */
    public function setHead(Head $head)
    {
        $this->head = $head;
        return $this;
    }

    public function write(Writer $writer = null)
    {
        if ($writer) $this->writer = $writer;
        return $this->wrap(
            function (Writer $writer) {
                if (!$this->head) return;
                $this->head->write($writer);
            },
            function (Writer $writer) {
                if (!$this->body) return;
                $this->body->write($writer);
            }
        );
    }

    public function wrap(\Closure $header, \Closure $body, Writer $writer = null)
    {
        if ($writer) $this->writer = $writer;
        if (!$this->writer) return $this;
        $this->writer->startElementNs(Args::NS_XHTML, Elmt::HTML, Args::URI_XHTML);
        if (is_callable($header)) $header($writer);
        if (is_callable($body)) $body($writer);
        $this->writer->endElement();
        $this->processed = true;
        return $this;
    }

    public function xml()
    {
        if (!$this->writer) return '';
        if (!$this->processed) $this->write();
        return $this->writer->xml();
    }

}