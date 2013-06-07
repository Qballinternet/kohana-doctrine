<?php

namespace DoctrineExtensions\Query\PostgreSql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 *  method for postgresql < 9array_version a 9. Does not support ordering
 *
 */
class StringAgg extends FunctionNode
{
    public $isDistinct = false;
    public $expression = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
    	return sprintf('array_to_string(array_agg(%s), \',\')',
    		$this->expression->dispatch($sqlWalker));
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_DISTINCT)) {
            $parser->match(Lexer::T_DISTINCT);

            $this->isDistinct = true;
        }

        $this->expression = $parser->SingleValuedPathExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}
