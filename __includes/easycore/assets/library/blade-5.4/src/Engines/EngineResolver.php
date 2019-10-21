<?php

namespace Xiaoler\Blade\Engines;

use Closure;
use InvalidArgumentException;

class EngineResolver
{
    /**
     * The array of engine resolvers.
     *
     * @var array
     */
    protected $resolvers = [];

    /**
     * The resolved engine instances.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a new engine resolver.
     *
     * The engine string typically corresponds to a file extension.
     *
     * @param  string   $engine
     * @param  \Closure  $resolver
     * @return void
     */
    public function register($engine, Closure $resolver)
    {
        unset($this->resolved[$engine]);

        $this->resolvers[$engine] = $resolver;
    }

    /**
     * Resolver an engine instance by name.
     *
     * @param  string  $engine
     * @return \Xiaoler\Blade\Engines\EngineInterface
     * @throws \InvalidArgumentException
     */
    public function resolve($engine)
    {
        if (isset($this->resolved[$engine])) {
            return $this->resolved[$engine];
        }

        if (isset($this->resolvers[$engine])) {
            return $this->resolved[$engine] = call_user_func($this->resolvers[$engine]);
        }

        //[Xamtax Edit]
        echo '<h1>View      Not     Properly    Named </h1><p>Ehex              Error [- view   name  should  ends with .blade.php or Declared Extension in __config/init.php -] <br/>Make     Sure    your    view    filename    ends    with <strong>".blade.php"</strong></p>';
        throw new InvalidArgumentException("Engine $engine not found.");
    }
}
