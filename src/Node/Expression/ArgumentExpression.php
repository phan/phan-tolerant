<?php
/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/

namespace Microsoft\PhpParser\Node\Expression;

use Microsoft\PhpParser\MissingToken;
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
}
