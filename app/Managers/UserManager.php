<?php

namespace Managers;

use App\models\User;
use App\models\UserRole;
use Repositories\UserRepository;

class UserManager
{
    private $_userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->_userRepo = $userRepo;
    }

    public function addUser($fullName, $login, $password, $userRole, $year = null, $groupId = null)
    {
        //TODO: Проверять уникальность логина
        $user = new User();

        $user->fullName = $fullName;
        $user->login = $login;
        $user->role = $userRole;
        $user->password = $password;
        $user->admissionYear = $year;
        $user->groupId = $groupId;

        $this->_userRepo->create($user);
    }

    public function updateUser($id, $fullName, $year, $groupId)
    {
        $userToUpdate = $this->_userRepo->find($id);

        $userToUpdate->fullName = $fullName;
        $userToUpdate->admissionYear = $year;
        $userToUpdate->groupId = $groupId;

        $this->_userRepo->update($userToUpdate);
    }

    public function setStudentYearShift($userId, $yearsCount)
    {
        $user = $this->_userRepo->find($userId);
        $user->yearShift = $yearsCount;
        $this->_userRepo->update($user);
    }

    public function getUser($id)
    {
        return $this->_userRepo->find($id);
    }

    public function getUserByRememberToken($id,$token){
        return $this->_userRepo->findByRememberToken($id,$token);
    }

    public function deleteUser($id){

        $userToDelete = $this->_userRepo->find($id);

        if($userToDelete != null){
            $this->_userRepo->delete($userToDelete);
        }
    }

    public function getStudents()
    {
        return $this->_userRepo->where('role', '=', UserRole::Student);
    }

    public function getLecturers()
    {
        return $this->_userRepo->where('role', '=', UserRole::Lecturer);
    }
}