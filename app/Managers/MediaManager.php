<?php

namespace Managers;

use Repositories\UnitOfWork;
use Media;

class MediaManager
{
    private $_unitOfWork;

    public function __construct(UnitOfWork $unitOfWork)
    {
        $this->_unitOfWork = $unitOfWork;
    }

    public function getMedia($id){
        return $this->_unitOfWork->medias()->find($id);
    }

    public function addMedia(Media $media){
        $this->_unitOfWork->medias()->create($media);
        $this->_unitOfWork->commit();
    }

    public function updateMedia(Media $media){
        $this->_unitOfWork->medias()->update($media);
        $this->_unitOfWork->commit();
    }

    public function deleteMedia($mediaId){
        $media = $this->_unitOfWork->medias()->find($mediaId);
        if ($media != null){
            $this->_unitOfWork->medias()->delete($media);
            $this->_unitOfWork->commit();
        }
    }


}