<?php

namespace App\Models;

use ProAI\Datamapper\Annotations as ORM;
use ProAI\Datamapper\Support\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="given_answers")
 */
class GivenAnswer extends Entity
{
    /**
     *  @ORM\Id
     *  @ORM\Column(type="integer")
     *  @ORM\AutoIncrement
     */
    public  $id;

    /**
     *  @ORM\Relation(type="belongsTo", relatedEntity="App\Models\Test")
     */
    public $testId;

    /**
     *  @ORM\Relation(type="belongsTo", relatedEntity="App\Models\Question")
     */
    public $questionId;

    /**
     *  @ORM\Column(type="text")
     */
    public $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    public $isRight;
}
