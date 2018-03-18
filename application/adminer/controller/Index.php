<?php
namespace app\adminer\controller;


class Index extends Adminbase
{
    public function index()
    {
        return $this->fetch();
    }
}
