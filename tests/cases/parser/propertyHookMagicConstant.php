<?php
class C {
    public string $p {
        get => __PROPERTY__;
        set { echo __PROPERTY__; }
    }
}
