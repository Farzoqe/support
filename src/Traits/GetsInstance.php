<?php

namespace Farzoqe\Support\Traits;

trait GetsInstance
{
    public static function getInstance($id = null)
    {
        if (!$id) {
            $id = request('id');
        }
        return $id ? self::findOrFail($id) : new self();
    }
}
