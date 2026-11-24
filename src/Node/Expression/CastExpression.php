<?php
/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/

namespace Microsoft\PhpParser\Node\Expression;

use Microsoft\PhpParser\Diagnostic;
use Microsoft\PhpParser\DiagnosticKind;
use Microsoft\PhpParser\Node\DelimitedList\ExpressionList;
use Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Microsoft\PhpParser\Node\Statement\ForStatement;
use Microsoft\PhpParser\Token;
use Microsoft\PhpParser\TokenKind;

class CastExpression extends UnaryExpression {

    /** @var Token */
    public $openParen;

    /** @var Token */
    public $castType;

    /** @var Token */
    public $closeParen;

    /** @var Variable */
    public $operand;

    const CHILD_NAMES = [
        'openParen',
        'castType',
        'closeParen',
        'operand'
    ];

    /**
     * `(void)` (php 8.5) is only allowed as a statement and in the expression lists of `for`: `$x = (void) f();` is a syntax error.
     * @return Diagnostic|null
     */
    public function getDiagnosticForNode() {
        $castType = $this->castType;
        if (!($castType instanceof Token) || $castType->kind !== TokenKind::VoidCastToken) {
            return null;
        }
        $parent = $this->parent;
        if ($parent instanceof ExpressionStatement || ($parent instanceof ExpressionList && $parent->parent instanceof ForStatement)) {
            return null;
        }
        return new Diagnostic(
            DiagnosticKind::Error,
            "Unexpected '(void)'",
            $castType->start,
            $castType->length - ($castType->start - $castType->fullStart)
        );
    }
}
