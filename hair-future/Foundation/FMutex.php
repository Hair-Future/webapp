<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 31/10/17
 * Time: 16.15
 */

class FMutex extends FDb
{
    public function wait()
    {
        $this->sql = $this->con->prepare("BEGIN TRANSACTION;");
        parent::queryNoValues();
    }

    public function signal()
    {
        $this->sql = $this->con->prepare("COMMIT;");
        parent::queryNoValues();

    }
}