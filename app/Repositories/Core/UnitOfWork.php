<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 10.10.16
 * Time: 22:36
 */

namespace Repositories;


use Doctrine\ORM\EntityManager;


class UnitOfWork
{
    private $_em;

    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    private $_userRepo;
    private $_disciplineRepo;
    private $_disciplinePlanPlanRepo;
    private $_instituteRepo;
    private $_profileRepo;
    private $_studyPlanRepo;
    private $_themeRepo;
    private $_roleUserRepo;

    public function users(){
        if ($this->_userRepo == null){
            $this->_userRepo = new UserRepository($this->_em);
        }
        return $this->_userRepo;
    }

    public function disciplines(){
        if ($this->_disciplineRepo == null){
            $this->_disciplineRepo = new DisciplineRepository($this->_em);
        }
        return $this->_disciplineRepo;
    }

    public function institutes(){
        if ($this->_instituteRepo == null){
            $this->_instituteRepo = new InstituteRepository($this->_em);
        }
        return $this->_instituteRepo;
    }

    public function disciplinePlans(){
        if ($this->_disciplinePlanPlanRepo == null){
            $this->_disciplinePlanPlanRepo = new DisciplinePlanRepository($this->_em);
        }
        return $this->_disciplinePlanPlanRepo;
    }

    public function profiles(){
        if ($this->_profileRepo == null){
            $this->_profileRepo = new ProfileRepository($this->_em);
        }
        return $this->_profileRepo;
    }

    public function studyPlans(){
        if ($this->_studyPlanRepo == null){
            $this->_studyPlanRepo = new StudyPlanRepository($this->_em);
        }
        return $this->_studyPlanRepo;
    }

    public function themes(){
        if ($this->_themeRepo == null){
            $this->_themeRepo = new ThemeRepository($this->_em);
        }
        return $this->_themeRepo;
    }

    public function userRoles(){
        if ($this->_roleUserRepo == null){
            $this->_roleUserRepo = new RoleUserRepository($this->_em);
        }
        return $this->_roleUserRepo;
    }

    public function commit(){
        $this->_em->flush();
    }
}