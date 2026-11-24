<?php
class C {
    use T {
        f as list;
        list as protected;
        T::f as public array;
        T::list as print;
        f as public static;
        namespace as ns;
    }
}
