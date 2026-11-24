<?php
class C {
    const A = 1;
    public ?int $a = null { get => $this->a; }
    public mixed $b = true { get { return $this->b; } set { $this->b = $value; } }
    public bool $c = false { get => $this->c; }
    public int $d = self::A { get => $this->d; }
    public int $e = PHP_INT_MAX { get => $this->e; }
}
