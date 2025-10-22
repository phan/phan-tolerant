<?php

class Book
{
    public function __construct(
        public private(set) string $title,
        public protected(set) string $author,
        public string $bar,
    ) {}
}
