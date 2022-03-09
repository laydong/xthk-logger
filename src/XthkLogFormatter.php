<?php

namespace Xthk\Logger;

class XthkLogFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter());
        }
    }
}
