<?php
class C {
    public function __construct(
        public int $x = 1 { get => $this->x; set => $value; },
        private(set) string $y = "a" { &get => $this->y; },
        int $z = 3 { get => 2; },
    ) {}
}
class WithObjectDefault {
    public function __construct(
        public \stdClass $x = new \stdClass() { get => $this->x; },
        public \stdClass $y = new \stdClass { get => $this->y; },
    ) {}
}
