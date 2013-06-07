<?php

namespace DoctrineExtensions\Query\PostgreSql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * array_agg method for postgresql version >= 9. Supports ordering.
 *
 * Example: ArrayAgg(file.id, ORDER BY photo.position ASC)
 *
 */
class ArrayAgg extends FunctionNode
{
    private $expr1;
    private $expr2;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
    	$lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();

        if(Lexer::T_COMMA === $lexer->lookahead['type']){
	        $parser->match(Lexer::T_COMMA);
	        $this->expr2 = $parser->OrderByClause();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {

    	$value = 'array_agg('.$sqlWalker->walkArithmeticPrimary($this->expr1);

    	if ($this->expr2)
    	{
    		$value .= ' '.$sqlWalker->walkArithmeticPrimary($this->expr2);
    	}

    	$value .= ')';

    	return $value;
    }

}
