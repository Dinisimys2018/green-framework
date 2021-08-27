<?php


interface Fab {
    public function a(string $b):int;
}

class Fab1 implements Fab {
    public function a(string $b): int
    {
        return 1;
    }
}


class Fab2 implements Fab {
    public function a(string $b): int
    {
        return 2;
    }
}

function rr(Fab $fab) {
    var_dump($fab->a('bb'));
}

rr(new Fab1());
rr(new Fab2());