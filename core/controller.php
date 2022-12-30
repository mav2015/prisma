<?php

namespace core;

/**
 *  Controller parent
 *
 *  Each controller should inherit from this
 *
 */


class controller
{

    protected function getJson()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}
