<?php

namespace Xiaoler\Blade\Compilers;

use FileManager1;
use InvalidArgumentException;
use Xiaoler\Blade\Filesystem;

abstract class Compiler
{
    /**
     * The Filesystem instance.
     *
     * @var \Xiaoler\Blade\Filesystem
     */
    protected $files;

    /**
     * Get the view_cache path for the compiled views.
     *
     * @var string
     */
    protected $cachePath;

    /**
     * Create a new compiler instance.
     *
     * @param  \Xiaoler\Blade\Filesystem $files
     * @param  string $cachePath
     */
    public function __construct(Filesystem $files, $cachePath)
    {
        if (! $cachePath) {
            throw new InvalidArgumentException('Please provide a valid view_cache path.');
        }

        $this->files = $files;
        $this->cachePath = $cachePath;
    }

    /**
     * Get the path to the compiled version of a views.
     *
     * @param  string  $path
     * @return string
     */
    public function getCompiledPath($path){
        $cachePath = $this->cachePath.'/'.sha1($path).'.php';
        if(!isset(\exBlade1::$LOADED_VIEW_AND_CACHE_LIST[$path])) \exBlade1::$LOADED_VIEW_AND_CACHE_LIST[$path] = FileManager1::normalizeFilePathSeparator($cachePath);
        return $cachePath;
    }

    /**
     * Determine if the views at the given path is expired.
     *
     * @param  string  $path
     * @return bool
     */
    public function isExpired($path)
    {



        $compiled = $this->getCompiledPath($path);


        //dd($path);

//        // xamtax ehex edit [x2x]
//        \exBlade1::$LOADED_VIEW_AND_CACHE_LIST[$compiled] = $path;
//
//        // add layouts for layout assets
//        if(!\exBlade1::$CURRENT_LAYOUT_PATH && \String1::startsWith($path, resources_path_view().DIRECTORY_SEPARATOR.'layouts')){
//            \exBlade1::$CURRENT_LAYOUT_PATH = $path;
//        }





        // If the compiled file doesn't exist we will indicate that the views is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if (! $this->files->exists($compiled)) {
            return true;
        }

        return $this->files->lastModified($path) >=
               $this->files->lastModified($compiled);
    }
}
