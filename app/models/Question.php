<?php

namespace App\Models;

use ProAI\Datamapper\Annotations as ORM;
use ProAI\Datamapper\Support\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question extends Entity
{
    /**
     * @ORM\Id
     * @ORM\AutoIncrement
     * @ORM\Column(type="integer")
     * @ORM\Relation(type="belongsTo", relatedEntity="App\Models\Theme")
     */
    public $id;

    /**
     * @ORM\Column(type="text")
     */
    public $text;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $image;

    /**
     * @ORM\Column(type="smallInteger")
     */
    public $type;

    /**
     * @ORM\Column(type="smallInteger")
     */
    public $time;

    /**
     * @ORM\Column(type="smallInteger")
     */
    public $complexity;
}