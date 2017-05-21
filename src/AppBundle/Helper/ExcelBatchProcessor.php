<?php

namespace AppBundle\Helper;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class ExcelBlockProcessor
 * @package App\Helper
 * @DI\Service("excel_batch_processor")
 */
class ExcelBatchProcessor
{
    private static $split = 'split --numeric-suffixes=1 --suffix-length=4 --lines=10000 %s %s';
    private static $in2csv = 'in2csv "%s" > "%s"';

    /**
     * @var string
     */
    public $tempDir;

    /**
     * ExcelBatchProcessor constructor.
     * @param $cacheDir
     *
     * @DI\InjectParams({
     *     "cacheDir"=@DI\Inject("%kernel.cache_dir%")
     * })
     */
    public function __construct($cacheDir)
    {
        $this->tempDir = $cacheDir.'/excel_processor';

        if (!@mkdir($this->tempDir, 0777, true) && !is_dir($this->tempDir)) {
            throw new \RuntimeException(sprintf('Cannot create folder %s', $this->tempDir));
        }
    }

    /**
     * @param $path
     * @param $tempcsv
     * @return string
     */
    public static function excelToCsv($path, $tempcsv)
    {
        shell_exec(sprintf(self::$in2csv, $path, $tempcsv));

        return $tempcsv;
    }

    /**
     * @param $tempdir
     * @param $tempcsv
     * @param $prefix
     * @return array
     */
    public function generateBatches($tempdir, $tempcsv, $prefix)
    {
        $prefix = $tempdir.'/'.$prefix;
        $blocks = glob($prefixGlob = $prefix.'*');

        if (0 === count($blocks)) {
            shell_exec(sprintf(self::$split, realpath($tempcsv), $prefix));
            $blocks = glob($prefixGlob);
        }

        return $blocks;
    }

    /**
     * @param $filepath
     * @param $prefix
     * @param callable $callback
     */
    public function process($filepath, $prefix, callable $callback)
    {
        $source = realpath($filepath);
        $tempcsv = sprintf('%s/full_%s.csv', $this->tempDir, time());

        if (!file_exists(self::excelToCsv($source, $tempcsv))) {
            throw new \RuntimeException('Cannot create file '.$tempcsv);
        }

        foreach ($this->generateBatches($this->tempDir, $tempcsv, $prefix) as $block) {
            $rows = array_map(function ($row) {
                return explode(',', $row);
            }, file($block, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

            $callback($rows);

            unset($rows); // free memory
            @unlink($block); // delete current block
        }
    }
}