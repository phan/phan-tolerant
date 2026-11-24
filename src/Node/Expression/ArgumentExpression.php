<?php
/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/

namespace Microsoft\PhpParser\Node\Expression;

use Microsoft\PhpParser\Diagnostic;
use Microsoft\PhpParser\DiagnosticKind;
use Microsoft\PhpParser\MissingToken;
use Microsoft\PhpParser\Node\DelimitedList\ArgumentExpressionList;
use Microsoft\PhpParser\Node\Expression;
use Microsoft\PhpParser\Token;

class ArgumentExpression extends Expression {
    /** @var Token|null for php named arguments. If this is set, dotDotDotToken will not be set. */
    public $name;

    /** @var Token|null */
    public $colonToken;

    /** @var Token|null */
    public $dotDotDotToken;

    /**
     * @var Token|null the placeholder `?` of partial function application (php 8.6): `f(?, 2)`, `f(b: ?)`.
     * If this is set, dotDotDotToken and expression will not be set.
     */
    public $questionToken;

    /**
     * @var Expression|MissingToken|null
     * Null for the placeholders of first-class callable syntax and partial function application: `f(...)`, `f(1, ...)`, `f(?)`.
     */
    public $expression;

    const CHILD_NAMES = [
        'name',
        'colonToken',
        'dotDotDotToken',
        'questionToken',
        'expression'
    ];

    /**
     * @return bool whether this is the variadic placeholder of first-class callable syntax and partial function application: `f(...)`, `f(1, ...)`
     */
    public function isVariadicPlaceholder(): bool {
        return $this->dotDotDotToken !== null && $this->expression === null;
    }

    /**
     * PHP rejects a variadic placeholder that is followed by another argument (`f(..., 1)`) at compile time.
     * @return Diagnostic|null
     */
    public function getDiagnosticForNode() {
        if (!$this->isVariadicPlaceholder() || !($this->parent instanceof ArgumentExpressionList)) {
            return null;
        }
        $isAfter = false;
        foreach ($this->parent->children as $sibling) {
            if ($sibling === $this) {
                $isAfter = true;
            } elseif ($isAfter && $sibling instanceof self) {
                return new Diagnostic(
                    DiagnosticKind::Error,
                    $sibling->isVariadicPlaceholder() ? 'Variadic placeholder may only appear once' : 'Variadic placeholder must be last',
                    $this->dotDotDotToken->start,
                    $this->dotDotDotToken->length - ($this->dotDotDotToken->start - $this->dotDotDotToken->fullStart)
                );
            }
        }
        return null;
    }
}
