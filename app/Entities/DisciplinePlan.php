<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * DisciplinePlan
 *
 * @ORM\Table(name="discipline_plan", indexes={@ORM\Index(name="discipline_plan_discipline_id_foreign", columns={"discipline_id"}), @ORM\Index(name="discipline_plan_studyplan_id_foreign", columns={"studyplan_id"})})
 * @ORM\Entity
 */
class DisciplinePlan
{
/**
 * @var boolean
 *
 * @ORM\Column(name="start_semester", type="boolean", nullable=true)
 */
private $startSemester;

/**
 * @var boolean
 *
 * @ORM\Column(name="semesters_count", type="boolean", nullable=true)
 */
private $semestersCount;

/**
 * @var integer
 *
 * @ORM\Column(name="hours", type="smallint", nullable=true)
 */
private $hours;

/**
 * @var boolean
 *
 * @ORM\Column(name="has_project", type="boolean", nullable=true)
 */
private $hasProject;

/**
 * @var boolean
 *
 * @ORM\Column(name="has_exam", type="boolean", nullable=true)
 */
private $hasExam;

/**
 * @var integer
 *
 * @ORM\Column(name="id", type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="IDENTITY")
 */
private $id;

/**
 * @var \Discipline
 *
 * @ORM\ManyToOne(targetEntity="Discipline")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="discipline_id", referencedColumnName="id")
 * })
 */
private $discipline;

/**
 * @var \Studyplan
 *
 * @ORM\ManyToOne(targetEntity="Studyplan")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="studyplan_id", referencedColumnName="id")
 * })
 */
private $studyplan;


/**
 * Set startSemester
 *
 * @param boolean $startSemester
 *
 * @return DisciplinePlan
 */
public function setStartSemester($startSemester)
{
$this->startSemester = $startSemester;

return $this;
}

/**
 * Get startSemester
 *
 * @return boolean
 */
public function getStartSemester()
{
return $this->startSemester;
}

/**
 * Set semestersCount
 *
 * @param boolean $semestersCount
 *
 * @return DisciplinePlan
 */
public function setSemestersCount($semestersCount)
{
$this->semestersCount = $semestersCount;

return $this;
}

/**
 * Get semestersCount
 *
 * @return boolean
 */
public function getSemestersCount()
{
return $this->semestersCount;
}

/**
 * Set hours
 *
 * @param integer $hours
 *
 * @return DisciplinePlan
 */
public function setHours($hours)
{
$this->hours = $hours;

return $this;
}

/**
 * Get hours
 *
 * @return integer
 */
public function getHours()
{
return $this->hours;
}

/**
 * Set hasProject
 *
 * @param boolean $hasProject
 *
 * @return DisciplinePlan
 */
public function setHasProject($hasProject)
{
$this->hasProject = $hasProject;

return $this;
}

/**
 * Get hasProject
 *
 * @return boolean
 */
public function getHasProject()
{
return $this->hasProject;
}

/**
 * Set hasExam
 *
 * @param boolean $hasExam
 *
 * @return DisciplinePlan
 */
public function setHasExam($hasExam)
{
$this->hasExam = $hasExam;

return $this;
}

/**
 * Get hasExam
 *
 * @return boolean
 */
public function getHasExam()
{
return $this->hasExam;
}

/**
 * Get id
 *
 * @return integer
 */
public function getId()
{
return $this->id;
}

/**
 * Set discipline
 *
 * @param \Discipline $discipline
 *
 * @return DisciplinePlan
 */
public function setDiscipline(\Discipline $discipline = null)
{
$this->discipline = $discipline;

return $this;
}

/**
 * Get discipline
 *
 * @return \Discipline
 */
public function getDiscipline()
{
return $this->discipline;
}

/**
 * Set studyplan
 *
 * @param \Studyplan $studyplan
 *
 * @return DisciplinePlan
 */
public function setStudyplan(\Studyplan $studyplan = null)
{
$this->studyplan = $studyplan;

return $this;
}

/**
 * Get studyplan
 *
 * @return \Studyplan
 */
public function getStudyplan()
{
return $this->studyplan;
}
}

