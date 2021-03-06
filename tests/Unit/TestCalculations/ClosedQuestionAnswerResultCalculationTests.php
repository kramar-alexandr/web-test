<?php


use TestEngine\AnswerChecker;

class ClosedQuestionAnswerResultCalculationTest extends TestCase
{


   /**
     * Метод подсчёта оценки на закрытый вопрос должен возвращать 0, если не было выбрано ни одного ответа.
     */
    public function testCalculatePointsForClosedAnswerShouldReturn0IfNoAnswersGiven()
    {
        //Arrange
        //Возможные ответы на вопрос - 2 правильных и 2 неправильных.
        $firstAnswer = ['id' => 1, 'isRight' => true];
        $secondAnswer = ['id' => 2, 'isRight' => false];
        $thirdAnswer = ['id' => 3, 'isRight' => true];
        $fourthAnswer = ['id' => 4, 'isRight' => false];

        //Act
        $noAnswersMark = AnswerChecker::calculatePointsForClosedAnswer(
            array($firstAnswer, $secondAnswer, $thirdAnswer, $fourthAnswer), array());

        //Assert
        $this->assertEquals(0, $noAnswersMark);
    }

    //Выбор только 2 правильных ответов
    public function testCalculatePointsForClosedAnswerShouldReturn100IfAllRightAnswersSelected()
    {
        //Arrange
        //Возможные ответы на вопрос - 2 правильных и 2 неправильных.
        $firstAnswer = ['id' => 1, 'isRight' => true];
        $secondAnswer = ['id' => 2, 'isRight' => false];
        $thirdAnswer = ['id' => 3, 'isRight' => true];
        $fourthAnswer = ['id' => 4, 'isRight' => false];

        //Act
        $twoRightOnlyMark = AnswerChecker::calculatePointsForClosedAnswer(
            array($firstAnswer, $secondAnswer, $thirdAnswer, $fourthAnswer), array(1,3));

        //Assert
        $this->assertEquals(100, $twoRightOnlyMark);
    }

    //Выбор только неправильного ответа
    public function testCalculatePointsForClosedAnswerShouldReturn0IfNoRightAnswersSelected(){
        //Arrange
        //Возможные ответы на вопрос - 2 правильных и 2 неправильных.
        $firstAnswer = ['id' => 1, 'isRight' => true];
        $secondAnswer = ['id' => 2, 'isRight' => false];
        $thirdAnswer = ['id' => 3, 'isRight' => true];
        $fourthAnswer = ['id' => 4, 'isRight' => false];

        //Act
        $wrongOnlyMark = AnswerChecker::calculatePointsForClosedAnswer(
            array($firstAnswer, $secondAnswer, $thirdAnswer, $fourthAnswer), array(4));

        //Assert
        $this->assertEquals(0, $wrongOnlyMark);
    }

    /**
     * За выбор неправильных вариантов ответов должны сниматься баллы.
     */
    public function testCalculatePointsForClosedAnswerShouldDecreaseMarkForWrongAnswersSelected(){
        //Arrange
        //Возможные ответы на вопрос - 2 правильных и 2 неправильных.
        $firstAnswer = ['id' => 1, 'isRight' => true];
        $secondAnswer = ['id' => 2, 'isRight' => false];
        $thirdAnswer = ['id' => 3, 'isRight' => true];
        $fourthAnswer = ['id' => 4, 'isRight' => false];

        //Act
        //Выбор 2 правильных и одного неправильного ответа (50 + 50 - 50 = 50)
        $twoRightOneWrongMark = AnswerChecker::calculatePointsForClosedAnswer(
            array($firstAnswer, $secondAnswer, $thirdAnswer, $fourthAnswer), array(1,3,4));

        //Assert
        $this->assertEquals(50, $twoRightOneWrongMark);
    }


}
