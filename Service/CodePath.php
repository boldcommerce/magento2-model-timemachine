<?php

namespace Bold\ModelTimemachine\Service;

class CodePath
{
    public function calculate()
    {
        $trace = array_map( [$this, 'formatItem'], debug_backtrace());

        return implode(PHP_EOL, $trace);
    }

    public function formatItem($item)
    {
        if (!isset($item['class'])) {
            return $item['file'] . ' - ' . $item['function'] . '():' . $item['line'];
        }

        $output = $item['class'] . $item['type'] . $item['function'] . '()';

        if (isset($item['line'])) {
            $output .= ':' . $item['line'];
        }

        return $output;
    }
}