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
namespace QuackCompiler\Ast\Stmt;

use \QuackCompiler\Lexer\Tag;
use \QuackCompiler\Parser\Parser;
use \QuackCompiler\Scope\Meta;

class OperatorStmt extends Stmt
{
    public $type;
    public $operator;
    public $precedence;

    public function __construct($type, $operator, $precedence)
    {
        $this->type = $type;
        $this->operator = $operator;
        $this->precedence = $precedence;
    }

    public function format(Parser $parser)
    {
        $names = [
            Tag::T_PREFIX => 'prefix ',
            Tag::T_INFIXL => 'infixl ',
            Tag::T_INFIXR => 'infixr ',
            Tag::T_SUFFIX => 'suffix '
        ];

        $source = $names[$this->type];

        if (null !== $this->precedence) {
            $source .= (string) $this->precedence;
            $source .= ' ';
        }

        $source .= '&(' . $this->operator . ')';
        $source .= PHP_EOL;
        return $source;
    }

    public function injectScope(&$parent_scope)
    {
        // TODO: Use Meta::M_OPERATOR;
        // If already defined, error
        // Else define
        // TODO: Fix bug on setMeta and getMeta
        // Putz! A meta needs a symbol to be chained! That's why!
        // var_dump($parent_scope);
        // $parent_scope->setMeta(Meta::M_OPERATOR, '+', '-');
        // exit;
        // TODO: Refactor scope to keep different tables for shapes, classes
        // and everything else, allowing access O(1) by kind
    }

    public function runTypeChecker()
    {
        // Pass
    }
}
