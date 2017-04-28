<?php
namespace CodeQuestionEngine;
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 22.11.16
 * Time: 14:41
 */
class DockerEngine
{

    /**
     * Путь к корневой папке приложения
     */
    private $app_path;

    /**
     * Переменная, хранящая шаблон команды запуска виртуальной машины.
     * @var string
     */
    private $command_pattern;



    public function __construct()
    {
        $cache_dir = EngineGlobalSettings::CACHE_DIR;
        $memory_limit = EngineGlobalSettings::MEMORY_LIMIT;
        $image_name = EngineGlobalSettings::IMAGE_NAME;
        //DEBUG COMMENT
      //$this->command_pattern = "docker run -v $this->app_path/$cache_dir:/opt/$cache_dir -m $memory_limit $image_name /sbin/my_init --skip-startup-files --quiet";
        $this->app_path = app_path();
    }

    /**
     * Запуск консольной команды на виртуальной машине.
     * @param $command - текст команды
     * @return mixed - результат выполнения команды
     */
    public function run($command){

        error_reporting(E_ALL);
        ini_set('display_errors',1);

        exec("docker run -v $this->app_path/temp_cache:/opt/temp_cache -m 50M baseimage-ssh /sbin/my_init --skip-startup-files --quiet $command",$output);

        return $output;
    }

    public function runAsync($command){
        $descriptorspec = array(
            0 => array('pipe', 'r'),
        );
        $pipes = array();

        $process = proc_open("docker run -v $this->app_path/temp_cache:/opt/temp_cache -m 50M baseimage-ssh /sbin/my_init --skip-startup-files --quiet $command",
                   $descriptorspec,$pipes);

        return $process;

    }






}