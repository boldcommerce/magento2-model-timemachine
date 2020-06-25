<?php


namespace Bold\ModelTimemachine\Service;


use Magento\Framework\UrlInterface;

class Origin
{
    /**
     * @var UrlInterface
     */
    private $url;

    public function __construct(
        UrlInterface $url
    ) {
        $this->url = $url;
    }

    public function calculate()
    {
        if (PHP_SAPI == 'cli') {
            return $this->getCliCommand();
        }

        return $this->url->getCurrentUrl();
    }

    private function getCliCommand()
    {
        global $argv;

        return implode(' ', $argv);
    }
}