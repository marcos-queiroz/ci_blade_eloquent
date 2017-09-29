<?php defined('BASEPATH') or exit('No direct script access allowed');
class Blade
{
    private $factory;
    public function __construct()
    {        
        $path = [APPPATH . 'views/'];
        $cachePath = APPPATH . 'cache/views';        
        $file = new \Xiaoler\Blade\Filesystem;
        $compiler = new \Xiaoler\Blade\Compilers\BladeCompiler($file, $cachePath);       
        $compiler->directive('datetime', function($timestamp) {
            return preg_replace('/(\(\d+\))/', 
                    '<?php echo date("Y-m-d H:i:s", $1); ?>', $timestamp);
        });
        $compiler->directive('now_datetime', function() {
            return '<?php echo date("Y-m-d H:i:s", '.(strtotime('now')).'); ?>';
        });        
        $resolver = new \Xiaoler\Blade\Engines\EngineResolver;
        $resolver->register('blade', function () use ($compiler) {
            return new \Xiaoler\Blade\Engines\CompilerEngine($compiler);
        });
        $this->factory = new \Xiaoler\Blade\Factory($resolver, 
                            new \Xiaoler\Blade\FileViewFinder($file, $path));
        $this->factory->addExtension('tpl', 'blade');
    }    
    public function view($path, $vars = [])
    {
        echo $this->factory->make($path, $vars);
    }
    public function exists($path)
    {
        return $this->factory->exists($path);
    }
    public function share($key, $value)
    {
        return $this->factory->share($key, $value);
    }
    public function render($path, $vars = [])
    {
        return $this->factory->make($path, $vars)->render();
    }
}