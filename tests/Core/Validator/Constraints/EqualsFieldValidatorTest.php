<?php

namespace ScoreYa\Cinderella\Core\Tests\Validator\Constraints;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Core\Validator\Constraints\EqualsField;
use ScoreYa\Cinderella\Core\Validator\Constraints\EqualsFieldValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;


/**
 * @author Alexander Miehe <thelex@beamscore.com>
 * 
 * @covers ScoreYa\Cinderella\Core\Validator\Constraints\EqualsFieldValidator
 */
class ValidPasswordValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $context;

    /**
     * @var EqualsFieldValidator
     */
    private $validator;

    /**
     * @test
     */
    public function validateCorrectValues()
    {
        $this->context->getRoot()->willReturn((object)['other' => 'test']);
        $this->validator->validate('test', new EqualsField(['field' => 'other']));
    }

    /**
     * @test
     */
    public function shouldBuildViolation()
    {
        $violation = $this->prophesize(ConstraintViolationBuilderInterface::class);

        $this->context->getRoot()->willReturn((object)['other' => 'none']);

        $this->context->buildViolation('This value does not equal the {{ field }} field')->willReturn($violation->reveal());
        $violation->setParameter('{{ field }}', 'other')->willReturn($violation->reveal());
        $violation->addViolation()->shouldBeCalled();

        $this->validator->validate('test', new EqualsField(['field' => 'other']));
    }

    protected function setUp()
    {
        $this->context =  $this->prophesize(ExecutionContextInterface::class);
        $this->validator = new EqualsFieldValidator();
        $this->validator->initialize($this->context->reveal());
    }
}
