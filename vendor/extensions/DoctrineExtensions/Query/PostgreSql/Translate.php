<?php

namespace DoctrineExtensions\Query\PostgreSql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;


/**
 * translate(str, from_str, to_str)
 * "translate" "(" StringPrimary "," StringPrimary "," StringPrimary ")"
 */
class Translate extends FunctionNode
{
    protected $stringStr, $stringFromStr, $stringToStr;

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'translate(%s, %s, %s)',
            $sqlWalker->walkStringPrimary($this->stringStr),
            $sqlWalker->walkStringPrimary($this->stringFromStr),
            $sqlWalker->walkStringPrimary($this->stringToStr)
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);                // translate
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->stringStr = $parser->StringPrimary();        // str
        $parser->match(Lexer::T_COMMA);
        $this->stringFromStr = $parser->StringPrimary();    // from_str
        $parser->match(Lexer::T_COMMA);
        $this->stringToStr = $parser->StringPrimary();      // to_str
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}