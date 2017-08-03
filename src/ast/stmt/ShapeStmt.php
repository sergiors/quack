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

use \QuackCompiler\Ast\Types\ObjectType;
use \QuackCompiler\Intl\Localization;
use \QuackCompiler\Parser\Parser;
use \QuackCompiler\Scope\Kind;
use \QuackCompiler\Scope\Meta;

class ShapeStmt extends Stmt
{
    public $name;
    public $members;

    public function __construct($name, $members)
    {
        $this->name = $name;
        $this->members = $members;
    }

    public function format(Parser $parser)
    {
        $source = 'shape ';
        $source .= $this->name;
        $source .= PHP_EOL;

        $parser->openScope();

        foreach ($this->members as $name => $type) {
            $source .= $parser->indent();
            $source .= $name . ' :: ' . $type;
            $source .= PHP_EOL;
        }

        $parser->closeScope();

        $source .= $parser->indent();
        $source .= 'end';
        $source .= PHP_EOL;

        return $source;
    }

    public function injectScope(&$parent)
    {
        $this->scope = $parent;
        $this->scope->insert($this->name, Kind::K_SHAPE | Kind::K_VARIABLE);
    }

    public function runTypeChecker()
    {
        $type = new ObjectType($this->members);
        $this->scope->setMeta(Meta::M_TYPE, $this->name, $type);
    }
}
