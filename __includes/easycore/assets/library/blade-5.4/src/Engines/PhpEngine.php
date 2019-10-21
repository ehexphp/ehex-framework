<?php

namespace Xiaoler\Blade\Engines;

use Exception;
use Throwable;

class PhpEngine implements EngineInterface
{

    /**
     * Get the evaluated contents of the views.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = []){
        return $this->evaluatePath($path, $data);
    }



    /**
     * Get the evaluated contents of the views at the given path.
     *
     * @param  string  $__path
     * @param  array   $__data
     * @return string
     */
    protected function evaluatePath($__path, $__data){
        $obLevel = ob_get_level();

        ob_start();

        extract($__data, EXTR_SKIP);

        // We'll evaluate the contents of the views inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $__path;
        } catch (Exception $e) {

            //[Xamtax Edit]
            echo '<h1>Failed     to     Render     View</h1><p>Ehex              Error [- View Needs to be Debug for error  -]</p>';
            $this->handleViewException($e, $obLevel);

        } catch (Throwable $e) {

            //[Xamtax Edit]
            echo '<h1>View           Error</h1><p>Ehex              Error [- View Needs to be Debug for error  -]</p>';
            $this->handleViewException(new Exception($e), $obLevel);
        }

        return ltrim(ob_get_clean());
    }




    /**
     * Handle a views exception.
     *
     * @param  \Exception  $e
     * @param  int  $obLevel
     * @return void
     *
     * @throws \Exception
     */
    protected function handleViewException(Exception $e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        echo '<pre>';
        throw $e;
    }
}
