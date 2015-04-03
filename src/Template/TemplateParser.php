<?php

namespace ScoreYa\Cinderella\Template;

use JMS\Parser\AbstractParser;
use JMS\Parser\SimpleLexer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class TemplateParser extends AbstractParser
{
    const T_STRING         = 2;
    const T_OPEN_VARIABLE  = 3;
    const T_CLOSE_VARIABLE = 4;
    const REGEX_NAME       = '([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)';

    /**
     * @param string $opener
     * @param string $closer
     */
    public function __construct($opener, $closer)
    {
        parent::__construct(
            new SimpleLexer(
                '/
                # Template variable opener

                (' . preg_quote($opener) . ')

                # Template variable closer

                | (' . preg_quote($closer) . ')

            /x',
                array(
                    self::T_OPEN_VARIABLE  => 'T_OPEN_VARIABLE',
                    self::T_CLOSE_VARIABLE => 'T_CLOSE_VARIABLE',
                    self::T_STRING         => 'T_STRING'
                ),
                function ($value) use ($opener, $closer) {
                    switch ($value) {
                        case $opener:
                            return array(TemplateParser::T_OPEN_VARIABLE, $opener);
                        case $closer:
                            return array(TemplateParser::T_CLOSE_VARIABLE, $closer);
                        default:
                            return array(TemplateParser::T_STRING, $value);
                    }
                }
            )
        );
    }

    /**
     * @return array
     */
    protected function parseInternal()
    {
        $vars = [];
        do {
            if (!$this->lexer->isNext(self::T_OPEN_VARIABLE)) {
                continue;
            }

            $variable = $this->match(self::T_OPEN_VARIABLE);

            if (!$this->lexer->isNext(self::T_STRING)) {
                throw new \RuntimeException('Expected a variable after opening.');
            }

            $variableName = $this->match(self::T_STRING);
            $variable    .= $variableName;

            preg_match(self::REGEX_NAME, $variableName, $matches);
            if (count($matches) === 0 || $matches[0] !== trim($variableName)) {
                throw new \UnexpectedValueException(sprintf('"%s" is not a valid template variable.', $variableName));
            }

            if (!$this->lexer->isNext(self::T_CLOSE_VARIABLE)) {
                throw new \RuntimeException('Expected closing after variable name.');
            }
            $variable       .= $this->match(self::T_CLOSE_VARIABLE);
            $vars[$variable] = trim($variableName);
        } while ($this->lexer->moveNext());

        return $vars;
    }
}
