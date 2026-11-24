<?php
class C {
    private array $d = [];
    public array $p { &get => $this->d; }
    public $q { final &get { return $this->d; } }
}
