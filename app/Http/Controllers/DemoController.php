<?php

namespace App\Http\Controllers;


use App\Process;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Managers\DisciplineManager;
use Managers\GroupManager;
use Managers\UserManager;
use Mockery\CountValidator\Exception;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;
use Collective\Remote\RemoteServiceProvider;

class DemoController extends BaseController
{
    public $_userManager;
    public $_groupManager;
    public $_disciplineManager;

    public function __construct(UserManager $userManager,
                                GroupManager $groupManager,
                                DisciplineManager $disciplineManager)
    {
        $this->_userManager = $userManager;
        $this->_groupManager = $groupManager;
        $this->_disciplineManager = $disciplineManager;
    }

    public function index(){

    //   $container_id = exec("docker run -d -i -t baseimage-ssh /sbin/my_init",$output);

        error_reporting(E_ALL);
        ini_set('display_errors',1);
        $command_pattern = 'docker run -v $PWD/temp_cache:/opt/temp_cache -m 50M baseimage-ssh /sbin/my_init --skip-startup-files --quiet';
        $command = 'echo hello wold';
        //$result =  exec("$command_pattern $command",$output);


        //$this->_userManager->addUser('Иван Петрович','vasya','123456',UserRole::Lecturer, 2013, 1);

        //$usersRepo->create($user);
        //$this->_userManager->updateUser(20,'Колян', 2055, 3);

        //dd($this->_groupManager->addGroup(0,'ИСб',4,true,1));
        dd($this->_disciplineManager->getLecturerWithDisciplines(1));

    }

    public function editor(){

        return view('editor');
    }



}
