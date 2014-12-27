<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Tests\Request;

use Prophecy\Prophecy\ObjectProphecy;
use ScoreYa\Cinderella\Bundle\CoreBundle\Request\RequestBodyParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @covers ScoreYa\Cinderella\Bundle\CoreBundle\Request\RequestBodyParamConverter
 */
class RequestBodyParamConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $baseConverter;

    /**
     * @var RequestBodyParamConverter
     */
    private $converter;

    /**
     * @test
     */
    public function supports()
    {
        $configuration = $this->prophesize(ParamConverter::class);

        $this->baseConverter->supports($configuration)->willReturn(true);

        $this->assertTrue($this->converter->supports($configuration->reveal()));
    }

    /**
     * @test
     */
    public function applyAndToNothingWithViolationsIfNotSet()
    {
        $request = $this->prophesize(Request::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $configuration = $this->prophesize(ParamConverter::class);

        $request->attributes = $attributes->reveal();

        $this->baseConverter->apply($request, $configuration)->willReturn(true);

        $this->assertTrue($this->converter->apply($request->reveal(), $configuration->reveal()));
    }

    /**
     * @test
     */
    public function apply()
    {
        $request = $this->prophesize(Request::class);
        $attributes = $this->prophesize(ParameterBagInterface::class);
        $configuration = $this->prophesize(ParamConverter::class);
        $violations = $this->prophesize(ConstraintViolationListInterface::class);

        $attributes->get('violations')->willReturn($violations);
        $violations->addAll($violations)->shouldBeCalled();
        $attributes->set('violations', $violations)->shouldBeCalled();

        $request->attributes = $attributes->reveal();

        $this->baseConverter->apply($request, $configuration)->willReturn(true);

        $this->assertTrue($this->converter->apply($request->reveal(), $configuration->reveal()));
    }

    protected function setUp()
    {
        $this->baseConverter = $this->prophesize(ParamConverterInterface::class);

        $this->converter = new RequestBodyParamConverter($this->baseConverter->reveal(), 'violations');
    }
}
