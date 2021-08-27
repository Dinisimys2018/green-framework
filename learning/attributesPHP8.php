<?php
#[Attribute]
class MyAttribute {
    const VALUE = 'value';

    public function __construct(private $value = null)
    {}


    public function getValue():mixed
    {
        return $this->value;
    }
}


#[MyAttribute(MyAttribute::VALUE)]
class Thing
{
}



function dumpAttributeData($reflection) {
    $attributes = $reflection->getAttributes();

    foreach ($attributes as $attribute) {
        $obj = $attribute->newInstance();
        echo $obj->getValue() . PHP_EOL;
    }
}

dumpAttributeData(new ReflectionClass(Thing::class));