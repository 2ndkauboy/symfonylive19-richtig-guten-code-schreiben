<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'irishgauge\\blackcube' => '/BlackCube.php',
                'irishgauge\\cube' => '/Cube.php',
                'irishgauge\\dividendcubedraw' => '/DividendCubeDraw.php',
                'irishgauge\\exception' => '/Exception.php',
                'irishgauge\\pinkcube' => '/PinkCube.php',
                'irishgauge\\toofewcubesexception' => '/TooFewCubesException.php',
                'irishgauge\\toomanycubesexception' => '/TooManyCubesException.php',
                'irishgauge\\whitecube' => '/WhiteCube.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
