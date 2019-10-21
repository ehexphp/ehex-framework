<?php

namespace Xiaoler\Blade\Compilers\Concerns;

use Xiaoler\Blade\Factory as ViewFactory;

trait CompilesLayouts
{
    /**
     * The name of the last section that was started.
     *
     * @var string
     */
    protected $lastSection;

    /**
     * Compile the extends statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileExtends($expression)
    {

        //dd($expression);
        $expression = $this->stripParentheses($expression);


        /**
         *  Xamtax Ehex  ex x2x Edit
         */
        $p1 = explode(',', $expression)[0]; // split from parameter
        $p1 = trim($p1, '\'"');             // trim quote
        //$p1 = dirname( \exBlade1::convertViewPathToPath($p1)); //resources_path_view().DIRECTORY_SEPARATOR.\String1::replace($p1, '.',DIRECTORY_SEPARATOR) ); //get full view path minute themeName

        // execute extends
        $echo = "<?php echo \$__env->make({$expression}, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        $this->footer[] = $echo;

        // save layout path
        return '<?php register_path_for_layout_asset("'."$p1".'") ?>';
    }

    /**
     * Compile the section statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileSection($expression)
    {


        $this->lastSection = trim($expression, "()'\" ");
        return "<?php \$__env->startSection{$expression}; ?>";
    }

    /**
     * Replace the @parent directive to a placeholder.
     *
     * @return string
     */
    protected function compileParent()
    {
        return ViewFactory::parentPlaceholder($this->lastSection ?: '');
    }

    /**
     * Compile the yield statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileYield($expression)
    {
        return "<?php echo \$__env->yieldContent{$expression}; ?>";
    }

    /**
     * Compile the show statements into valid PHP.
     *
     * @return string
     */
    protected function compileShow()
    {
        return '<?php echo $__env->yieldSection(); ?>';
    }

    /**
     * Compile the append statements into valid PHP.
     *
     * @return string
     */
    protected function compileAppend()
    {
        return '<?php $__env->appendSection(); ?>';
    }

    /**
     * Compile the overwrite statements into valid PHP.
     *
     * @return string
     */
    protected function compileOverwrite()
    {
        return '<?php $__env->stopSection(true); ?>';
    }

    /**
     * Compile the stop statements into valid PHP.
     *
     * @return string
     */
    protected function compileStop()
    {
        return '<?php $__env->stopSection(); ?>';
    }

    /**
     * Compile the end-section statements into valid PHP.
     *
     * @return string
     */
    protected function compileEndsection()
    {
        return '<?php $__env->stopSection(); ?>';
    }
}
