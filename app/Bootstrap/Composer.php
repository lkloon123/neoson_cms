<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 5/9/2019
 * Time: 5:25 PM.
 */

namespace App\Bootstrap;


use Illuminate\Filesystem\Filesystem;

/**
 * Class Composer
 *
 * Some code picked from OctoberCMS
 *
 * @package App\Bootstrap
 * @original_author Alexey Bobkov, Samuel Georges
 */
class Composer extends \Illuminate\Support\Composer
{
    /* @var \Composer\Autoload\ClassLoader $classLoader */
    protected $classLoader;

    protected $classMapStore = [];
    protected $psr4Store = [];
    protected $namespaceStore = [];
    protected $filesStore = [];

    public function __construct(Filesystem $files, $workingPath = null)
    {
        parent::__construct($files, $workingPath);

        $this->initialize();
    }

    public function initialize()
    {
        $this->classLoader = include base_path() . '/vendor/autoload.php';

        $this->classMapStore = array_fill_keys(array_keys($this->classLoader->getClassMap()), true);
        $this->psr4Store = array_fill_keys(array_keys($this->classLoader->getPrefixes()), true);
        $this->namespaceStore = array_fill_keys(array_keys($this->classLoader->getPrefixesPsr4()), true);
        $this->filesStore = $this->filesStore();
    }

    protected function phpBinary()
    {
        //default php searcher add single colon to result
        //removed it to avoid unfound
        $phpPath = parent::phpBinary();
        return str_replace("'", '', $phpPath);
    }

    protected function filesStore()
    {
        $result = [];
        $vendorPath = base_path() . '/vendor';

        if (file_exists($file = $vendorPath . '/composer/autoload_files.php')) {
            $files = require $file;
            foreach ($files as $file) {
                $relativeFile = $this->stripVendorPath($file, $vendorPath);
                $result[$relativeFile] = true;
            }
        }

        return $result;
    }

    protected function stripVendorPath($path, $vendorPath)
    {
        $path = realpath($path);
        $vendorPath = realpath($vendorPath);

        if (strpos($path, $vendorPath) === 0) {
            $path = substr($path, strlen($vendorPath));
        }

        return $path;
    }

    public function registerPluginAutoLoader($pluginPath)
    {
        $vendorPath = $pluginPath . '/vendor';
        $composerPath = $vendorPath . '/composer';

        if (file_exists($file = $composerPath . '/autoload_classmap.php')) {
            $classMap = require $file;
            if ($classMap) {
                $classMapDiff = array_diff_key($classMap, $this->classMapStore);
                $this->classLoader->addClassMap($classMapDiff);
                $this->classMapStore += array_fill_keys(array_keys($classMapDiff), true);
            }
        }

        if (file_exists($file = $composerPath . '/autoload_psr4.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->psr4Store[$namespace])) {
                    continue;
                }
                $this->classLoader->setPsr4($namespace, $path);
                $this->psr4Store[$namespace] = true;
            }
        }

        if (file_exists($file = $composerPath . '/autoload_namespaces.php')) {
            $map = require $file;
            foreach ($map as $namespace => $path) {
                if (isset($this->namespaceStore[$namespace])) {
                    continue;
                }
                $this->classLoader->set($namespace, $path);
                $this->namespaceStore[$namespace] = true;
            }
        }

        if (file_exists($file = $composerPath . '/autoload_files.php')) {
            $includeFiles = require $file;
            foreach ($includeFiles as $includeFile) {
                $relativeFile = $this->stripVendorPath($includeFile, $vendorPath);
                if (isset($this->filesStore[$relativeFile])) {
                    continue;
                }
                require $includeFile;
                $this->filesStore[$relativeFile] = true;
            }
        }
    }

    public function installDependencies($pluginPath)
    {
        ini_set('max_execution_time', 300);

        $this->setWorkingPath($pluginPath);

        $command = array_merge($this->findComposer(), ['install']);

        $process = $this->getProcess($command);

        $process->run();
    }
}
