Bem vindo
========

O CodeIgniter conhecido como CI é um Frameworks PHP simples e poderoso, já bem maduro,
rápido, confiável e com uma comunidade extremamente ativa, funciona no padrão
MVC (Model-View-Controller). Oferece uma documentação clara e completa, mesmo que inglês,
é simples e ajuda muito com seus exemplos claros.

Vou demonstrar como usar o Eloquent e Blade que são usados nativamente no Laravel.


## Integrar Eloquent e Blade no CI


1. Criar o Projeto;
2. Instalar as dependências;
3. Configurar os ganchos;
4. Testar a Integração.


### Criar o Projeto


Vamos usar o Composer para criar (caso queira fazer do zero, se não clone esse repositório) nosso projeto e instalar as dependências.

No seu diretório execute o comando, via terminal:

    composer create-project bcit-ci/codeigniter ci_eloquent_blade --prefer-dist

Após concluir a criação do projeto, acesse o diretório com o comando:

    cd ci_eloquent_blade



## Instalar as dependências


Já no diretório instale as dependências com os comandos:

    composer require xiaoler/blade

    composer illuminate/database

Pronto o projeto já está criado e com suas dependências instaladas.


## Configurando o projeto


Para que você posso utilizar o Blade e o Eloquent, execute as configurações a seguir.


### composer.json


Abra o arquivo composer.json na raiz de seu projeto, adicione o seguinte atributo.

``` json
"autoload": {
    "classmap": [
       "application/models"
    ]
}
```

Depois da edição o arquivo deverá ter essa aparência:

``` json
{
    "description": "Projeto usando Eloquent e Blade no CI",
    "name": "marcos-queiroz/ci_eloquent_blade",
    "type": "project",
    "license": "MIT",
    "require": {
        "php": ">=5.3.7",
        "illuminate/database": "^5.5",
        "xiaoler/blade": "^5.4"
    },
    "suggest": {
        "paragonie/random_compat": "Provides better randomness in PHP 5.x"
    },
    "require-dev": {
        "mikey179/vfsStream": "1.1.*",
        "phpunit/phpunit": "4.* || 5.*"
    },
    "autoload": {
        "classmap": [
           "application/models"
        ]
    }
}
```


#### application/config/config.php


Como você está utilizando pacotes instalados via Composer, vai precisar ajustar a
configuração para que esses pacotes sejam carregados corretamente. Para isso vá até
o diretório application/config e abra o arquivo config.php. Nele voce deve alterar
a configuração do autoload do Composer, conforme código a seguir:

``` php

$config['composer_autoload'] = './vendor/autoload.php';

``` 


## Configure Hooks (ganchos)


Precisamos informar ao CI que precisando usar o Hooks. Abra application/config/config.php e altere o valor:

``` php

$config['enable_hooks'] = TRUE;

``` 

Crie o arquivo hooks.php no diretório: application/config/ e adicione o seguinte código:

``` php

$hook['post_controller_constructor'][] = [
    'class'    => 'EloquentHook',
    'function' => 'bootEloquent',
    'filename' => 'EloquentHook.php',
    'filepath' => 'hooks'
];

``` 

Este gancho é chamado após o método do construtor do Controller ser executado. Crie o arquivo
EloquentHook.php no diretório: application/hooks e adicione o seguinte código:

``` php

<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentHook {

    /**
     * Holds the instance
     * @var object
     */
    protected $instance;

    /**
     * Gets CI instance
     */
    private function setInstance() {
        $this->instance =& get_instance();
    }

    /**
     * Loads database
     */
    private function loadDatabase() {
        $this->instance->load->database();
    }

    /**
     * Returns the instance of the db
     * @return object
     */
    private function getDB() {
        return $this->instance->db;
    }

    public function bootEloquent() {

        $this->setInstance();

        $this->loadDatabase();

        $config = $this->getDB();

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $config->hostname,
            'database'  => $config->database,
            'username'  => $config->username,
            'password'  => $config->password,
            'charset'   => $config->char_set,
            'collation' => $config->dbcollat,
            'prefix'    => $config->dbprefix,
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}

``` 

Ele vai usar as configurações que você definir em application/config/database.php.


### application/libraries/Blade.php


Crie um arquivo chamadao Blade.php no diretório application/libraries para que possa
adicionar as regras de integração entre o CodeIgniter e a Blade Template Engine.
Após criar o arquivo, adicione o código a seguir nele:

``` php

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

``` 

Após criar a library você deverá atualizar o arquivo application/config/autoload.php de
modo que ela seja carregada junto da aplicação, de forma automática.

``` php

$autoload['libraries'] = array('Blade');

``` 

## Importante


Crie o diretório views em application/cache/ e lembre-se que o diretório precisa ter permissão de escrita para
que os arquivos de cache sejam criados. Caso ao executar o teste de funcionamento no
browser você se depare com erros envolvendo file_get_contents, verifique as permissões do diretório.

*******
Testando as Integrações
*******

Agora que acabamos de configurar o projeto, adicione os Models, Controllers e Views para falicitar
o entendimento.


## Nota


Após criar seus Models execute o comando no terminal:

    composer dump-autoload

Caso contrário, você verá a exeção da classe como não encontrada, quando você tentar usar o Model.
