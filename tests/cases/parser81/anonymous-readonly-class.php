<?php
$a = new readonly class {
    public function __construct(public int $x = 1) {}
};
$b = new #[A] readonly class(1) {};
$c = new readonly class extends B implements C {};
