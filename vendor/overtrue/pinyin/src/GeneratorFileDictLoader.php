<?php

/*
 * This file is part of the overtrue/pinyin.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\Pinyin;

use Closure;
use SplFileObject;
use Generator;

/**
 * Generator syntax(yield) Dict File loader.
 */
class GeneratorFileDictLoader implements DictLoaderInterface
{
    /**
     * Data directory.
     *
     * @var string
     */
    protected $path;

    /**
     * Words segment name.
     *
     * @var string
     */
    protected $segmentName = 'words_%s';

    /**
     * SplFileObjects.
     *
     * @var array
     */
    protected static $handles = [];

    /**
     * surnames.
     *
     * @var SplFileObject
     */
    protected static $surnamesHandle;

    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        for ($i = 0; $i < 100; ++$i) {
            $segment = $this->path.'/'.sprintf($this->segmentName, $i);

            if (file_exists($segment) && is_file($segment)) {
                // 后期静态绑定，参考：http://php.net/manual/zh/language.oop5.late-static-bindings.php
                array_push(static::$handles, $this->openFile($segment));
            }
        }
    }

    /**
     * Construct a new file object.
     *
     * @param string $filename file path
     *
     * @return SplFileObject
     */
    protected function openFile($filename, $mode = 'r')
    {
        // 文件处理类SplFileObject，参考：http://php.net/manual/zh/class.splfileobject.php
        // 构造函数，参考：http://php.net/manual/zh/splfileobject.construct.php
        return new SplFileObject($filename, $mode);
    }

    /**
     * get Generator syntax.
     *
     * @param array $handles SplFileObjects
     */
    protected function getGenerator(array $handles)
    {
        foreach ($handles as $handle) {
            // seek函数：将文件指针定位到首行
            $handle->seek(0);
            // eof函数：判断文件指针是否到达文件末尾
            while ($handle->eof() === false) {
                // fgets函数：获取文件中的一行
                // str_replace函数：去除字符串中的指定的字符（由第一个参数数组指定）
                $string = str_replace(['\'', ' ', PHP_EOL, ','], '', $handle->fgets());

                // strpos函数：查找字符串首次出现的位置
                if (strpos($string, '=>') === false) {
                    continue;
                }

                // explode函数：使用一个字符串分割另一个字符串，返回子字符串数组
                // list函数：把数组中的值赋给一组变量
                list($string, $pinyin) = explode('=>', $string);

                // 生成器，参考：http://php.net/manual/zh/language.generators.syntax.php
                // 生成一个键值对数组
                yield $string => $pinyin;
            }
        }
    }

    /**
     * Traverse the stream.
     *
     * @param Generator $generator
     * @param Closure   $callback
     *
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function traversing(Generator $generator, Closure $callback)
    {
        foreach ($generator as $string => $pinyin) {
            $callback([$string => $pinyin]);
        }
    }

    /**
     * Load dict.
     *
     * @param Closure $callback
     */
    public function map(Closure $callback)
    {
        $this->traversing($this->getGenerator(static::$handles), $callback);
    }

    /**
     * Load surname dict.
     *
     * @param Closure $callback
     */
    public function mapSurname(Closure $callback)
    {
        if (!static::$surnamesHandle instanceof SplFileObject) {
            static::$surnamesHandle = $this->openFile($this->path.'/surnames');
        }

        $this->traversing($this->getGenerator([static::$surnamesHandle]), $callback);
    }
}
