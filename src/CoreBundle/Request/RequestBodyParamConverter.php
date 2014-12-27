<?php

namespace ScoreYa\Cinderella\Bundle\CoreBundle\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class RequestBodyParamConverter implements ParamConverterInterface
{
    private $requestBodyParamConverter;
    private $validationErrorsArgument;

    /**
     * @param ParamConverterInterface $requestBodyParamConverter
     * @param string                  $validationErrorsArgument
     */
    public function __construct(ParamConverterInterface $requestBodyParamConverter, $validationErrorsArgument)
    {
        $this->requestBodyParamConverter = $requestBodyParamConverter;
        $this->validationErrorsArgument  = $validationErrorsArgument;
    }

    /**
     * {@inheritDoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $existingViolations = $request->attributes->get($this->validationErrorsArgument);
        $isSet              = $this->requestBodyParamConverter->apply($request, $configuration);
        $violations         = $request->attributes->get($this->validationErrorsArgument);

        if ($existingViolations instanceof ConstraintViolationListInterface
            && $violations instanceof ConstraintViolationListInterface
        ) {
            $violations->addAll($existingViolations);
            $request->attributes->set($this->validationErrorsArgument, $violations);
        }

        return $isSet;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return $this->requestBodyParamConverter->supports($configuration);
    }
}
