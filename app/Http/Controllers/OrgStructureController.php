<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Managers\OrgStructureManager;
use Profile;

class OrgStructureController extends Controller
{
    private $_orgStructureManager;

    public function __construct(OrgStructureManager $orgStructureManager)
    {
        $this->_orgStructureManager = $orgStructureManager;
    }

    public function getAllInstitutes()
    {
        return json_encode($this->_orgStructureManager->getInstitutes());
    }

    public function getInstituteProfiles($id)
    {
        return json_encode($this->_orgStructureManager->getInstituteProfiles($id));
    }

    public function getProfileGroups($id){
        return json_encode($this->_orgStructureManager->getProfileGroups($id));
    }

    public function getProfilePlans($id){
        return json_encode($this->_orgStructureManager->getProfilePlans($id));
    }

    public function deleteProfile($id){
        $this->_orgStructureManager->deleteProfile($id);
    }

    /*
     * Пример валидного JSON:
     * method: POST
     * url: http://www.web-test.ru/api/org/profile/create
     * body: { "profile": {"name":"test","semesters":5,"fullname":"fullnameTEST"} }
     */
    public function createProfile(Request $request){
        $profileData = $request->json('profile');
        $profile = new Profile();
        $profile->fillFromJson($profileData);
        $this->_orgStructureManager->addProfile($profile);
    }

    public function updateProfile(Request $request){
        $profileData = $request->json('profile');
        $profile = new Profile();
        $profile->fillFromJson($profileData);
        $this->_orgStructureManager->updateProfile($profile);
    }

}