<?php
$x = (void) f();
g((void) f());
echo (void) f();
function h() { return (void) f(); }
(void) (void) f();
(void) f();
for ((void) f(); ; ) {}
