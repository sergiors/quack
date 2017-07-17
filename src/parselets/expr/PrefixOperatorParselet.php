<?php
/**
 * Quack Compiler and toolkit
 * Copyright (C) 2016 Marcelo Camargo <marcelocamargo@linuxmail.org> and
 * CONTRIBUTORS.
 *
 * This file is part of Quack.
 *
 * Quack is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Quack is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Quack.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace QuackCompiler\Parselets\Expr;

use \QuackCompiler\Ast\Expr\PrefixExpr;
use \QuackCompiler\Lexer\Token;
use \QuackCompiler\Parselets\PrefixParselet;
use \QuackCompiler\Parser\Grammar;
use \QuackCompiler\Parser\Precedence;

class PrefixOperatorParselet implements PrefixParselet
{
    private $reader;

    public function __construct($reader)
    {
        $this->reader = $reader;
    }

    public function parse($parser, Token $token)
    {
        // TODO: kill resolveScope, make everything cleaner. Have a custom error
        // for operators
        $operator = $this->reader->resolveScope($token->getPointer());
        if (!isset($this->reader->prefix_operators[$operator])) {
            // throw new \Exception('Undeclared operator ' . $operator);
        }

        $operand = $parser->_expr(Precedence::PREFIX);
        return new PrefixExpr($token, $operand);
    }
}
